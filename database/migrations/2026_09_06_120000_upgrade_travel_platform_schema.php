<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Upgrade Packages Table
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'type')) {
                $table->string('type')->default('tour')->after('title'); // 'bus', 'train', 'tour'
            }
            if (!Schema::hasColumn('packages', 'from_location')) {
                $table->string('from_location')->nullable()->after('type');
            }
            if (!Schema::hasColumn('packages', 'to_location')) {
                $table->string('to_location')->nullable()->after('from_location');
            }
            if (!Schema::hasColumn('packages', 'departure_time')) {
                $table->string('departure_time')->nullable()->after('to_location');
            }
            if (!Schema::hasColumn('packages', 'available_seats')) {
                $table->integer('available_seats')->default(40)->after('price');
            }
        });

        // 2. Upgrade Bookings Table
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'package_id')) {
                $table->foreignId('package_id')->nullable()->after('user_id')->constrained('packages')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'booking_code')) {
                $table->string('booking_code')->nullable()->unique()->after('package_id');
            }
            if (!Schema::hasColumn('bookings', 'transport_type')) {
                $table->string('transport_type')->default('tour')->after('booking_code');
            }
            if (!Schema::hasColumn('bookings', 'passenger_name')) {
                $table->string('passenger_name')->nullable()->after('transport_type');
            }
            if (!Schema::hasColumn('bookings', 'journey_date')) {
                $table->date('journey_date')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('bookings', 'return_date')) {
                $table->date('return_date')->nullable()->after('journey_date');
            }
            if (!Schema::hasColumn('bookings', 'from_city')) {
                $table->string('from_city')->nullable()->after('return_date');
            }
            if (!Schema::hasColumn('bookings', 'to_city')) {
                $table->string('to_city')->nullable()->after('from_city');
            }
            if (!Schema::hasColumn('bookings', 'seats')) {
                $table->integer('seats')->default(1)->after('to_city');
            }
            if (!Schema::hasColumn('bookings', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->default(0)->after('seats');
            }
            if (!Schema::hasColumn('bookings', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0)->after('unit_price');
            }
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->string('status')->default('pending')->after('total_price'); // 'pending', 'confirmed', 'completed', 'cancelled'
            }
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('status'); // 'unpaid', 'paid', 'refunded'
            }
            if (!Schema::hasColumn('bookings', 'refund_status')) {
                $table->string('refund_status')->default('none')->after('payment_status'); // 'none', 'requested', 'approved', 'refunded', 'rejected'
            }
            if (!Schema::hasColumn('bookings', 'cancellation_reason')) {
                $table->text('cancellation_reason')->nullable()->after('refund_status');
            }
            if (!Schema::hasColumn('bookings', 'special_notes')) {
                $table->text('special_notes')->nullable()->after('cancellation_reason');
            }
        });

        // 3. Upgrade Payments Table
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'booking_id')) {
                $table->foreignId('booking_id')->nullable()->after('id')->constrained('bookings')->nullOnDelete();
            }
            if (!Schema::hasColumn('payments', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('booking_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->string('payment_method')->default('SSLCommerz')->after('amount');
            }
            if (!Schema::hasColumn('payments', 'raw_data')) {
                $table->longText('raw_data')->nullable()->after('status');
            }
        });

        // 4. Upgrade Contact Messages Table
        Schema::table('contact_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_messages', 'subject')) {
                $table->string('subject')->nullable()->after('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['subject']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['booking_id', 'user_id', 'payment_method', 'raw_data']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['package_id']);
            $table->dropColumn([
                'user_id', 'package_id', 'booking_code', 'transport_type',
                'passenger_name', 'journey_date', 'return_date', 'from_city',
                'to_city', 'seats', 'unit_price', 'total_price', 'status',
                'payment_status', 'refund_status', 'cancellation_reason', 'special_notes'
            ]);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['type', 'from_location', 'to_location', 'departure_time', 'available_seats']);
        });
    }
};
