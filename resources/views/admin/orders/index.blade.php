@extends('layouts.admin')

@section('page-title', 'Manage Orders')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h5 class="fw-bold mb-0">All Orders</h5>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex gap-2">
            <select name="status" class="form-select form-select-sm rounded-pill px-3" style="width: auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control rounded-start-pill ps-3" placeholder="Search orders..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary rounded-end-pill px-3"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3 text-muted text-uppercase small fw-bold border-0">Order ID</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Date</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Customer</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Total</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Status</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Driver</th>
                    <th class="pe-4 py-3 border-0 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="ps-4 py-3"><span class="fw-bold text-primary font-mono">{{ $order->order_number }}</span></td>
                    <td class="py-3 text-muted small">
                        {{ $order->created_at->format('M d, Y') }}<br>
                        {{ $order->created_at->format('H:i') }}
                    </td>
                    <td class="py-3">
                        <div class="fw-medium">{{ $order->user->name ?? 'Unknown' }}</div>
                        <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $order->delivery_city }}</div>
                    </td>
                    <td class="py-3 fw-bold font-mono text-dark">KES {{ number_format($order->total_amount) }}</td>
                    <td class="py-3">
                        <span class="badge badge-{{ $order->order_status }} text-capitalize px-3 py-2 rounded-pill">
                            {{ str_replace('_', ' ', $order->order_status) }}
                        </span>
                        @if($order->payment_status == 'paid')
                            <i class="bi bi-check-circle-fill text-success ms-1" title="Paid via {{ $order->payment_method }}"></i>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($order->delivery && $order->delivery->driver)
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 10px;">
                                    {{ substr($order->delivery->driver->name, 0, 1) }}
                                </div>
                                <span class="small fw-medium">{{ $order->delivery->driver->name }}</span>
                            </div>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#assignDriverModal{{ $order->id }}">
                                Assign Driver
                            </button>
                            
                            <!-- Assign Driver Modal -->
                            <div class="modal fade" id="assignDriverModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">Assign Driver to {{ $order->order_number }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.orders.assign', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-muted small text-uppercase">Select Driver</label>
                                                    <select name="driver_id" class="form-select" required>
                                                        <option value="">-- Choose a Driver --</option>
                                                        @foreach($drivers as $driver)
                                                            <option value="{{ $driver->id }}">{{ $driver->name }} ({{ $driver->driverProfile->vehicle_type ?? 'Vehicle' }} - {{ $driver->driverProfile->vehicle_plate ?? 'N/A' }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">Assign Order</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="pe-4 py-3 text-end">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3">Manage</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 mb-3 d-block text-black-50"></i>
                        No orders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white p-4 border-top">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
