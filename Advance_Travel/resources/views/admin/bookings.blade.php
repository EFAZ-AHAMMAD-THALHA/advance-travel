@extends('layouts.admin')

@section('title', 'Manage Travel Bookings')

@section('content')

<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold m-0 text-dark">Travel Reservations 📄</h5>
            <small class="text-muted">Review and manage customer tour bookings</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Guest Name</th>
                    <th class="py-3">Contact Details</th>
                    <th class="py-3">Package / Destination</th>
                    <th class="py-3">Check-in / Out</th>
                    <th class="py-3">Room Config</th>
                    <th class="py-3">Price</th>
                    <th class="py-3 text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td class="fw-bold text-dark">{{ $booking->firstname }} {{ $booking->lastname }}</td>
                        <td>
                            <div>{{ $booking->email }}</div>
                            <small class="text-muted">{{ $booking->phone }}</small>
                        </td>
                        <td>
                            <strong class="text-primary">{{ $booking->package_title ?? $booking->destination ?? 'Custom Tour' }}</strong>
                            @if($booking->package_location)
                                <div class="text-muted small">📍 {{ $booking->package_location }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="small fw-medium">
                                In: {{ $booking->check_in_date ?? 'N/A' }}<br>
                                Out: {{ $booking->check_out_date ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2.5 py-1.5 rounded-2">
                                {{ $booking->rooms }} Room(s) ({{ $booking->room_type }})
                            </span>
                        </td>
                        <td class="fw-bold text-success">
                            ৳{{ number_format($booking->package_price ?? 0, 2) }}
                        </td>
                        <td class="text-end">
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel/delete this booking?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                    <i class='bx bx-trash'></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class='bx bx-calendar-x fs-1 d-block mb-2 text-secondary opacity-50'></i>
                            No travel bookings found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>

@endsection
