@extends('layouts.admin')

@section('title', 'Manage Travel Bookings')

@section('content')

<div class="card-custom mb-4">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h5 class="fw-bold m-0 text-dark">Travel Reservations & Tickets 📄</h5>
            <small class="text-muted">Manage all customer bookings across bus, train, and tour packages</small>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <form action="{{ route('bookings.index') }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search Code, Name, Phone..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-6">
                <select name="type" class="form-select form-select-sm">
                    <option value="all">All Transports</option>
                    <option value="bus" {{ request('type') === 'bus' ? 'selected' : '' }}>🚌 Bus Tickets</option>
                    <option value="train" {{ request('type') === 'train' ? 'selected' : '' }}>🚆 Train Tickets</option>
                    <option value="tour" {{ request('type') === 'tour' ? 'selected' : '' }}>🏖️ Tour Packages</option>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="status" class="form-select form-select-sm">
                    <option value="all">All Statuses</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="payment_status" class="form-select form-select-sm">
                    <option value="all">All Payments</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 px-3 fw-bold w-100">
                    <i class='bx bx-filter'></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'type', 'status', 'payment_status']))
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-danger btn-sm rounded-3" title="Clear Filters">
                        <i class='bx bx-reset'></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Bookings Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Ticket Code</th>
                    <th class="py-3">Passenger</th>
                    <th class="py-3">Service & Route</th>
                    <th class="py-3">Travel Date</th>
                    <th class="py-3">Total Fare</th>
                    <th class="py-3">Status / Payment</th>
                    <th class="py-3">Refund Status</th>
                    <th class="py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <strong class="font-monospace text-primary">{{ $booking->booking_code }}</strong>
                            <span class="badge {{ $booking->transport_type === 'bus' ? 'bg-warning text-dark' : ($booking->transport_type === 'train' ? 'bg-danger text-white' : 'bg-primary') }} text-uppercase d-block mt-1" style="font-size: 0.68rem;">
                                {{ $booking->transport_type }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $booking->passenger_name }}</div>
                            <small class="text-muted">{{ $booking->phone }}</small>
                            <div class="text-muted small text-truncate" style="max-width: 140px;">{{ $booking->email }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $booking->from_city }} ➔ {{ $booking->to_city }}</div>
                            <small class="text-muted">{{ $booking->seats }} Seat(s) ({{ $booking->room_type }})</small>
                        </td>
                        <td>
                            <div class="fw-medium">
                                {{ \Carbon\Carbon::parse($booking->journey_date ?? $booking->check_in_date)->format('M d, Y') }}
                            </div>
                            @if($booking->return_date)
                                <small class="text-muted">Ret: {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</small>
                            @endif
                        </td>
                        <td class="fw-bold text-success">
                            ৳{{ number_format($booking->total_price, 2) }}
                        </td>
                        <td>
                            <!-- Status Badges -->
                            <div>
                                @if($booking->status === 'cancelled')
                                    <span class="badge bg-danger px-2 py-0.5 rounded-pill">Cancelled</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="badge bg-success px-2 py-0.5 rounded-pill">Confirmed</span>
                                @else
                                    <span class="badge bg-warning text-dark px-2 py-0.5 rounded-pill">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>

                            <div class="mt-1">
                                @if($booking->payment_status === 'paid')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-0.5">Paid</span>
                                @elseif($booking->payment_status === 'refunded')
                                    <span class="badge bg-secondary px-2 py-0.5">Refunded</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2 py-0.5">Unpaid</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($booking->refund_status === 'requested')
                                <div class="badge bg-danger px-2.5 py-1 mb-1 animate-pulse">
                                    Refund Claimed ⚠️
                                </div>
                                <div class="d-flex gap-1 mt-1">
                                    <form action="{{ route('bookings.refund', $booking->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-xs btn-success py-0 px-1.5 rounded" style="font-size: 0.72rem;" title="Approve Refund">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('bookings.refund', $booking->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-xs btn-danger py-0 px-1.5 rounded" style="font-size: 0.72rem;" title="Reject Refund">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @elseif($booking->refund_status === 'refunded')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1 rounded">Refunded ✅</span>
                            @elseif($booking->refund_status === 'rejected')
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1 rounded">Rejected ❌</span>
                            @else
                                <span class="text-muted small">None</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <!-- View E-Ticket -->
                                <a href="{{ route('booking.ticket', $booking->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-2 px-2" title="Inspect E-Ticket">
                                    <i class='bx bx-printer'></i>
                                </a>

                                <!-- Status Update Trigger Button -->
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-2 px-2"
                                        data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $booking->id }}" title="Change Status">
                                    <i class='bx bx-edit-alt'></i>
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this booking permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-2" title="Delete Booking">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Status Change Modal -->
                            <div class="modal fade text-start" id="editStatusModal{{ $booking->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content rounded-4 border-0">
                                        <div class="modal-header border-0 pb-0">
                                            <h6 class="modal-title fw-bold">Update #{{ $booking->booking_code }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body py-3">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Booking Status</label>
                                                    <select name="status" class="form-select form-select-sm">
                                                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label small fw-bold">Payment Status</label>
                                                    <select name="payment_status" class="form-select form-select-sm">
                                                        <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                        <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                        <option value="refunded" {{ $booking->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class='bx bx-calendar-x fs-1 d-block mb-2 text-secondary opacity-50'></i>
                            No travel bookings found matching your criteria.
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
