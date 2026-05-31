@extends('layouts.admin')

@section('page-title', 'Manage Products')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Product Catalog</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Add Product
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3 text-muted text-uppercase small fw-bold border-0">Image</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Product Name</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Category</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Price</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Stock</th>
                    <th class="py-3 text-muted text-uppercase small fw-bold border-0">Status</th>
                    <th class="pe-4 py-3 border-0 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="ps-4 py-3">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-primary" style="width: 50px; height: 50px;">
                                <i class="bi bi-droplet fs-4"></i>
                            </div>
                        @endif
                    </td>
                    <td class="py-3">
                        <div class="fw-bold text-dark">{{ $product->name }}</div>
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.65rem;">FEATURED</span>
                        @endif
                    </td>
                    <td class="py-3 text-muted">{{ $product->category->name }}</td>
                    <td class="py-3">
                        <div class="fw-bold font-mono">KES {{ number_format($product->effective_price) }}</div>
                        @if($product->sale_price)
                            <small class="text-muted text-decoration-line-through">KES {{ number_format($product->price) }}</small>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($product->stock > 10)
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ $product->stock }} in stock</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Low: {{ $product->stock }} left</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Out of Stock</span>
                        @endif
                    </td>
                    <td class="py-3">
                        <span class="badge badge-{{ $product->status == 'active' ? 'delivered' : 'cancelled' }} text-capitalize px-3 py-1 rounded-pill">
                            {{ str_replace('_', ' ', $product->status) }}
                        </span>
                    </td>
                    <td class="pe-4 py-3 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light text-primary rounded-circle" style="width: 32px; height: 32px;" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-light text-danger rounded-circle" style="width: 32px; height: 32px;" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-box fs-2 mb-3 d-block text-black-50"></i>
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white p-4 border-top">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
