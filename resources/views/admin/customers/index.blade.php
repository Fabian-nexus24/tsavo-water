@extends('layouts.admin')

@section('page-title', 'Manage Customers')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Customer Directory</h5>
        <form action="{{ route('admin.customers.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control rounded-pill px-4" placeholder="Search customers..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary rounded-pill ms-2"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3 border-0">Name</th>
                    <th class="py-3 border-0">Contact</th>
                    <th class="py-3 border-0 text-center">Orders</th>
                    <th class="py-3 border-0">Joined</th>
                    <th class="py-3 border-0">Status</th>
                    <th class="pe-4 py-3 border-0 text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td class="ps-4 py-3 fw-bold">{{ $customer->name }}</td>
                    <td class="py-3">
                        <div class="small">{{ $customer->email }}</div>
                        <div class="text-muted small"><i class="bi bi-telephone-fill me-1"></i>{{ $customer->phone ?? 'N/A' }}</div>
                    </td>
                    <td class="py-3 text-center fw-bold">{{ $customer->orders_count }}</td>
                    <td class="py-3 text-muted small">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td class="py-3">
                        <span class="badge bg-{{ $customer->status == 'active' ? 'success' : 'danger' }} rounded-pill px-2">
                            {{ ucfirst($customer->status) }}
                        </span>
                    </td>
                    <td class="pe-4 py-3 text-end">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5 text-muted">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="card-footer bg-white p-4 border-top">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
