@extends('layouts.driver')

@section('page-title', 'My Deliveries')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Delivery History</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3 text-muted text-uppercase small fw-bold border-0">Order ID</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Customer</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Address</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Status</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Date</th>
                    <th class="pe-4 py-3 border-0 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $delivery)
                <tr>
                    <td class="ps-4 py-3"><span class="fw-bold text-primary font-mono">{{ $delivery->order->order_number }}</span></td>
                    <td class="py-3">
                        <div class="fw-medium">{{ $delivery->order->user->name ?? 'Unknown' }}</div>
                        <div class="small text-muted"><i class="bi bi-telephone-fill me-1"></i>{{ $delivery->order->user->phone ?? 'N/A' }}</div>
                    </td>
                    <td class="py-3">
                        <div class="fw-medium">{{ $delivery->order->delivery_city }}</div>
                        <div class="small text-muted">{{ Str::limit($delivery->order->delivery_address, 30) }}</div>
                    </td>
                    <td class="py-3">
                        <span class="badge badge-{{ $delivery->status == 'failed' ? 'danger' : ($delivery->status == 'delivered' ? 'success' : 'primary') }} text-capitalize px-3 py-2 rounded-pill">
                            {{ str_replace('_', ' ', $delivery->status) }}
                        </span>
                    </td>
                    <td class="py-3 text-muted small">
                        {{ $delivery->created_at->format('M d, Y') }}
                    </td>
                    <td class="pe-4 py-3 text-end">
                        <a href="{{ route('driver.deliveries.show', $delivery) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-truck fs-2 mb-3 d-block text-black-50"></i>
                        No delivery records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($deliveries->hasPages())
    <div class="card-footer bg-white p-4 border-top">
        {{ $deliveries->links() }}
    </div>
    @endif
</div>
@endsection
