<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class TravelPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $traveler;
    protected $busService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@travel.com',
            'phone'    => '01700000000',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $this->traveler = User::create([
            'name'     => 'Efaz Traveler',
            'email'    => 'user@travel.com',
            'phone'    => '01812345678',
            'password' => bcrypt('password123'),
            'is_admin' => false,
        ]);

        $this->busService = Package::create([
            'type'            => 'bus',
            'title'           => 'Green Line AC Business Class',
            'from_location'   => 'Dhaka',
            'to_location'     => "Cox's Bazar",
            'departure_time'  => '08:00 AM',
            'available_seats' => 40,
            'price'           => 1600.00,
            'description'     => 'Luxury AC express coach.',
            'location'        => "Cox's Bazar",
        ]);
    }

    /** 1. Test Public Routes */
    public function test_public_pages_load_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Advance Travel');

        $explore = $this->get('/explore');
        $explore->assertStatus(200);
        $explore->assertSee('Explore Bus, Train', false);

        $package = $this->get('/package');
        $package->assertStatus(200);

        $contact = $this->get('/contact');
        $contact->assertStatus(200);
    }

    /** 2. Test Guest Gating: Guest redirected to login when accessing booking or dashboard */
    public function test_guest_is_redirected_to_login_when_booking(): void
    {
        $response = $this->get('/booking');
        $response->assertRedirect('/login');

        $dashboard = $this->get('/my-bookings');
        $dashboard->assertRedirect('/login');
    }

    /** 3. Test Booking Validation: Past Dates are strictly blocked */
    public function test_booking_rejects_past_dates(): void
    {
        $yesterday = Carbon::yesterday()->toDateString();

        $response = $this->actingAs($this->traveler)->post('/booking/store', [
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'transport_type' => 'bus',
            'journey_date'   => $yesterday, // ❌ Past date!
            'seats'          => 2,
            'package_id'     => $this->busService->id,
        ]);

        $response->assertSessionHasErrors('journey_date');
        $this->assertDatabaseCount('bookings', 0);
    }

    /** 4. Test Booking Validation: Invalid Phone regex is rejected */
    public function test_booking_rejects_invalid_phone(): void
    {
        $response = $this->actingAs($this->traveler)->post('/booking/store', [
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => 'invalid-phone-abc', // ❌ Invalid!
            'transport_type' => 'bus',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'seats'          => 1,
            'package_id'     => $this->busService->id,
        ]);

        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseCount('bookings', 0);
    }

    /** 5. Test Successful Ticket Booking & Price Calculation */
    public function test_authenticated_user_can_book_ticket(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $response = $this->actingAs($this->traveler)->post('/booking/store', [
            'firstname'      => 'Efaz',
            'lastname'       => 'Thalha',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'transport_type' => 'bus',
            'from_city'      => 'Dhaka',
            'to_city'        => "Cox's Bazar",
            'journey_date'   => $tomorrow,
            'seats'          => 2,
            'room_type'      => 'AC Business Class',
            'package_id'     => $this->busService->id,
        ]);

        $this->assertDatabaseCount('bookings', 1);

        $booking = Booking::first();
        $this->assertEquals(3200.00, $booking->total_price); // 1600 * 2
        $this->assertEquals('unpaid', $booking->payment_status);
        $this->assertEquals('confirmed', $booking->status);
        $this->assertStringStartsWith('TKT-', $booking->booking_code);

        $response->assertRedirect(route('payment.checkout', $booking->id));
    }

    /** 6. Test User Dashboard displays booked tickets */
    public function test_user_can_view_my_bookings_dashboard(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'booking_code'   => 'TKT-TEST-001',
            'transport_type' => 'bus',
            'passenger_name' => 'Efaz Traveler',
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'from_city'      => 'Dhaka',
            'to_city'        => "Cox's Bazar",
            'seats'          => 1,
            'unit_price'     => 1600.00,
            'total_price'    => 1600.00,
            'status'         => 'confirmed',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->traveler)->get('/my-bookings');
        $response->assertStatus(200);
        $response->assertSee('TKT-TEST-001');
        $response->assertSee('Efaz Traveler');
    }

    /** 7. Test User can view printable e-Ticket */
    public function test_user_can_view_e_ticket(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'booking_code'   => 'TKT-PRINT-002',
            'transport_type' => 'bus',
            'passenger_name' => 'Efaz Traveler',
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'from_city'      => 'Dhaka',
            'to_city'        => "Cox's Bazar",
            'seats'          => 2,
            'unit_price'     => 1600.00,
            'total_price'    => 3200.00,
            'status'         => 'confirmed',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->traveler)->get(route('booking.ticket', $booking->id));
        $response->assertStatus(200);
        $response->assertSee('TKT-PRINT-002');
        $response->assertSee('VERIFIED PAID');
    }

    /** 8. Test Ticket Cancellation & Refund Workflow */
    public function test_user_can_cancel_ticket_and_request_refund(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'package_id'     => $this->busService->id,
            'booking_code'   => 'TKT-CANCEL-003',
            'transport_type' => 'bus',
            'passenger_name' => 'Efaz Traveler',
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'seats'          => 1,
            'unit_price'     => 1600.00,
            'total_price'    => 1600.00,
            'status'         => 'confirmed',
            'payment_status' => 'paid',
            'refund_status'  => 'none',
        ]);

        $response = $this->actingAs($this->traveler)->post(route('booking.cancel', $booking->id), [
            'reason' => 'Emergency university exam schedule.',
        ]);

        $booking->refresh();
        $this->assertEquals('cancelled', $booking->status);
        $this->assertEquals('requested', $booking->refund_status);
        $this->assertEquals('Emergency university exam schedule.', $booking->cancellation_reason);
    }

    /** 9. Test Admin can approve refund */
    public function test_admin_can_approve_refund(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'booking_code'   => 'TKT-REFUND-004',
            'transport_type' => 'bus',
            'passenger_name' => 'Efaz Traveler',
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'seats'          => 1,
            'unit_price'     => 1600.00,
            'total_price'    => 1600.00,
            'status'         => 'cancelled',
            'payment_status' => 'paid',
            'refund_status'  => 'requested',
        ]);

        $response = $this->actingAs($this->admin)->post(route('bookings.refund', $booking->id), [
            'action' => 'approve',
        ]);

        $booking->refresh();
        $this->assertEquals('refunded', $booking->refund_status);
        $this->assertEquals('refunded', $booking->payment_status);
    }

    /** 10. Test Payment Callback updates booking and creates payment */
    public function test_payment_success_callback_verifies_ticket(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'booking_code'   => 'TKT-PAY-005',
            'transport_type' => 'bus',
            'passenger_name' => 'Efaz Traveler',
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'seats'          => 1,
            'unit_price'     => 1600.00,
            'total_price'    => 1600.00,
            'status'         => 'confirmed',
            'payment_status' => 'unpaid',
        ]);

        // SSLCommerz POST callback (received as unauthenticated cross-site POST)
        $response = $this->post('/success', [
            'tran_id' => 'TRX_TEST_SUCCESS_1',
            'amount'  => 1600.00,
            'value_a' => $booking->id,
            'value_b' => $booking->user_id,
        ]);

        $booking->refresh();
        $this->assertEquals('paid', $booking->payment_status);

        $this->assertDatabaseHas('payments', [
            'tran_id' => 'TRX_TEST_SUCCESS_1',
            'status'  => 'Success',
            'amount'  => 1600.00,
        ]);

        // CRITICAL CHECK: Ensure user is authenticated into session and not logged out
        $this->assertAuthenticatedAs($this->traveler);
        $response->assertRedirect(route('booking.ticket', $booking->id));

        // Follow redirect and ensure ticket view renders HTTP 200 without redirecting to login
        $followResponse = $this->get(route('booking.ticket', $booking->id));
        $followResponse->assertOk();
        $followResponse->assertSee($booking->booking_code);
    }

    /** 11. Test Payment Cancel keeps user authenticated and returns to checkout */
    public function test_payment_cancel_keeps_user_authenticated(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'booking_code'   => 'TKT-PAY-CANCEL',
            'transport_type' => 'bus',
            'passenger_name' => 'Efaz Traveler',
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'seats'          => 1,
            'unit_price'     => 1600.00,
            'total_price'    => 1600.00,
            'status'         => 'confirmed',
            'payment_status' => 'unpaid',
        ]);

        $response = $this->post('/cancel', [
            'tran_id' => 'TRX_TEST_CANCEL_1',
            'amount'  => 1600.00,
            'value_a' => $booking->id,
            'value_b' => $booking->user_id,
        ]);

        $this->assertAuthenticatedAs($this->traveler);
        $response->assertRedirect(route('payment.checkout', $booking->id));
    }

    /** 12. Test Explore Alias Search & Sorting */
    public function test_explore_alias_search_and_sorting(): void
    {
        // Search by alias "Chittagong" should match "Chattogram"
        $response = $this->get('/explore?search=Chittagong');
        $response->assertOk();
        $response->assertSee('Chattogram');

        // Test sorting by price asc
        $sortAsc = $this->get('/explore?sort=price_asc');
        $sortAsc->assertOk();

        // Test pagination link preserves query params
        $sortDesc = $this->get('/explore?type=bus&sort=price_desc&page=1');
        $sortDesc->assertOk();
    }

    /** 13. Test Cancellation with omitted reason falls back gracefully */
    public function test_user_can_cancel_without_explicit_reason(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'package_id'     => $this->busService->id,
            'booking_code'   => 'TKT-CANCEL-OPT',
            'transport_type' => 'bus',
            'passenger_name' => 'Efaz Traveler',
            'firstname'      => 'Efaz',
            'email'          => 'user@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'seats'          => 1,
            'unit_price'     => 1600.00,
            'total_price'    => 1600.00,
            'status'         => 'confirmed',
            'payment_status' => 'paid',
            'refund_status'  => 'none',
        ]);

        $response = $this->actingAs($this->traveler)->post(route('booking.cancel', $booking->id), []);
        $response->assertSessionHas('success');

        $booking->refresh();
        $this->assertEquals('cancelled', $booking->status);
        $this->assertEquals('requested', $booking->refund_status);
        $this->assertEquals('Cancelled by passenger', $booking->cancellation_reason);
    }

    /** 14. Test Seat Selection & Promo Code Discount Engine */
    public function test_booking_with_selected_seats_and_promo_discount(): void
    {
        $response = $this->actingAs($this->traveler)->post(route('booking.store'), [
            'firstname'      => 'Rakib',
            'lastname'       => 'Hasan',
            'email'          => 'rakib@travel.com',
            'phone'          => '01711223344',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'transport_type' => 'bus',
            'package_id'     => $this->busService->id, // price 1600
            'seats'          => 2,
            'selected_seats' => 'A1, A2',
            'promo_code'     => 'STUDENT2026', // 20% discount
            'room_type'      => 'AC Business Class',
        ]);

        $booking = Booking::where('email', 'rakib@travel.com')->latest()->first();
        $this->assertNotNull($booking);
        $this->assertEquals('A1, A2', $booking->selected_seats);
        $this->assertEquals('STUDENT2026', $booking->promo_code);
        $this->assertEquals(640.00, (float)$booking->discount_amount); // 20% of 3200
        $this->assertEquals(2560.00, (float)$booking->total_price); // 3200 - 640
        $response->assertRedirect(route('payment.checkout', $booking->id));
        $response->assertSessionHas('success');
    }

    /** 15. Test Public Ticket Verification Portal & QR Code Lookup */
    public function test_public_ticket_verification(): void
    {
        $booking = Booking::create([
            'user_id'        => $this->traveler->id,
            'booking_code'   => 'TKT-VERIFY-999',
            'transport_type' => 'bus',
            'passenger_name' => 'Thalha Traveler',
            'firstname'      => 'Thalha',
            'email'          => 'thalha@travel.com',
            'phone'          => '01812345678',
            'journey_date'   => Carbon::tomorrow()->toDateString(),
            'from_city'      => 'Dhaka',
            'to_city'        => 'Sylhet',
            'seats'          => 2,
            'selected_seats' => 'B1, B2',
            'unit_price'     => 1200.00,
            'total_price'    => 2400.00,
            'status'         => 'confirmed',
            'payment_status' => 'paid',
        ]);

        // Blank portal
        $responseBlank = $this->get(route('booking.verify'));
        $responseBlank->assertOk();
        $responseBlank->assertSee('Official Ticket Verification Portal');

        // Valid Ticket Query
        $responseValid = $this->get(route('booking.verify', 'TKT-VERIFY-999'));
        $responseValid->assertOk();
        $responseValid->assertSee('AUTHENTIC', false);
        $responseValid->assertSee('VALID BOARDING PASS', false);
        $responseValid->assertSee('Thalha Traveler');
        $responseValid->assertSee('B1, B2');

        // Invalid Ticket Query
        $responseInvalid = $this->get(route('booking.verify', ['code' => 'TKT-NON-EXISTENT']));
        $responseInvalid->assertOk();
        $responseInvalid->assertSee('No Ticket Record Found');
    }

    /** 16. Test Traveler Profile and Password Management */
    public function test_user_profile_management_and_password_update(): void
    {
        // 1. View Profile
        $response = $this->actingAs($this->traveler)->get(route('profile'));
        $response->assertOk();
        $response->assertSee('Account & Traveler Settings', false);
        $response->assertSee($this->traveler->name);

        // 2. Update Profile Details
        $updateResponse = $this->actingAs($this->traveler)->put(route('profile.update'), [
            'name'              => 'Efaz Updated Profile',
            'phone'             => '01799887766',
            'address'           => 'Banani, Dhaka',
            'emergency_contact' => '01811223344',
        ]);
        $updateResponse->assertSessionHas('success');

        $this->traveler->refresh();
        $this->assertEquals('Efaz Updated Profile', $this->traveler->name);
        $this->assertEquals('01799887766', $this->traveler->phone);
        $this->assertEquals('Banani, Dhaka', $this->traveler->address);
        $this->assertEquals('01811223344', $this->traveler->emergency_contact);

        // 3. Password Update with wrong current password should fail
        $badPasswordResponse = $this->actingAs($this->traveler)->put(route('profile.password'), [
            'current_password'      => 'wrongpassword',
            'password'              => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ]);
        $badPasswordResponse->assertSessionHasErrors('current_password');

        // 4. Password Update with weak password (missing special char & uppercase) should fail
        $weakPasswordResponse = $this->actingAs($this->traveler)->put(route('profile.password'), [
            'current_password'      => 'password123',
            'password'              => 'weakpass123',
            'password_confirmation' => 'weakpass123',
        ]);
        $weakPasswordResponse->assertSessionHasErrors('password');

        // 5. Password Update with correct current password and valid strong password
        $goodPasswordResponse = $this->actingAs($this->traveler)->put(route('profile.password'), [
            'current_password'      => 'password123',
            'password'              => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ]);
        $goodPasswordResponse->assertSessionHas('success');
    }

    /** 17. Test User Registration Password Validation */
    public function test_user_registration_enforces_strong_password_rules(): void
    {
        // Weak password (no uppercase, no special char)
        $responseWeak = $this->post(route('register.submit'), [
            'name'                  => 'New User',
            'email'                 => 'newuser@example.com',
            'password'              => 'simple123',
            'password_confirmation' => 'simple123',
            'terms'                 => '1',
        ]);
        $responseWeak->assertSessionHasErrors('password');

        // Short password (less than 8 characters)
        $responseShort = $this->post(route('register.submit'), [
            'name'                  => 'New User 2',
            'email'                 => 'newuser2@example.com',
            'password'              => 'Ab1!xyz',
            'password_confirmation' => 'Ab1!xyz',
            'terms'                 => '1',
        ]);
        $responseShort->assertSessionHasErrors('password');

        // Strong compliant password
        $responseSuccess = $this->post(route('register.submit'), [
            'name'                  => 'New User 3',
            'email'                 => 'newuser3@example.com',
            'password'              => 'StrongP@ss2026',
            'password_confirmation' => 'StrongP@ss2026',
            'terms'                 => '1',
        ]);
        $responseSuccess->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => 'newuser3@example.com']);
    }

    /** 18. Test Dynamic Live Flight Status API Endpoint */
    public function test_live_flight_status_api_endpoint(): void
    {
        // 1. Fetch all live flight statuses
        $response = $this->get('/api/flight-status');
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'timestamp',
            'total',
            'data' => [
                '*' => [
                    'id', 'flight_number', 'airline', 'origin', 'destination', 'status', 'price'
                ]
            ]
        ]);

        // 2. Search specific flight code (e.g. BG-401)
        $searchResponse = $this->get('/api/flight-status?query=BG-401');
        $searchResponse->assertOk();
        $searchResponse->assertJsonFragment(['flight_number' => 'BG-401']);
    }
}
