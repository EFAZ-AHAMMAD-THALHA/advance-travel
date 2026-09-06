@extends('layouts.admin')

@section('title', 'Customer Inquiries')

@section('content')

<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold m-0 text-dark">Customer Inquiries & Messages 📧</h5>
            <small class="text-muted">Messages submitted through the public contact form</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Sender Name</th>
                    <th class="py-3">Contact Info</th>
                    <th class="py-3">Message Details</th>
                    <th class="py-3">Date Received</th>
                    <th class="py-3 text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td class="fw-bold text-dark">{{ $contact->name }}</td>
                        <td>
                            <div>{{ $contact->email }}</div>
                            <small class="text-muted">{{ $contact->phone ?? 'No Phone' }}</small>
                        </td>
                        <td>
                            <div class="text-slate-700" style="max-width: 400px; white-space: normal;">
                                {{ $contact->message }}
                            </div>
                        </td>
                        <td>
                            <small class="text-muted fw-medium">
                                {{ $contact->created_at ? $contact->created_at->format('M d, Y H:i') : 'N/A' }}
                            </small>
                        </td>
                        <td class="text-end">
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this customer inquiry?')">
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
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class='bx bx-envelope fs-1 d-block mb-2 text-secondary opacity-50'></i>
                            No contact inquiries received yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $contacts->links() }}
    </div>
</div>

@endsection
