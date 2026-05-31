@extends('layouts.admin')

@section('page-title', 'Categories')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    {{-- Add Category Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Add Category</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Category Name</label>
                        <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Bottled Water" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Description</label>
                        <textarea name="description" class="form-control rounded-3" rows="2" placeholder="Short description...">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control rounded-3" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                        <i class="bi bi-check-lg me-1"></i> Create Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Categories Table --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">All Categories ({{ $categories->count() }})</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 border-0">Name</th>
                            <th class="py-3 border-0 text-center">Products</th>
                            <th class="py-3 border-0 text-center">Order</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="pe-4 py-3 border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold">{{ $category->name }}</div>
                                <div class="small text-muted">{{ Str::limit($category->description, 40) }}</div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">{{ $category->products_count }}</span>
                            </td>
                            <td class="py-3 text-center font-mono">{{ $category->sort_order }}</td>
                            <td class="py-3">
                                <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }} rounded-pill px-2">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <button class="btn btn-sm btn-light text-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-pill px-3"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted">Name</label>
                                                <input type="text" name="name" class="form-control rounded-3" value="{{ $category->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted">Description</label>
                                                <textarea name="description" class="form-control rounded-3" rows="2">{{ $category->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted">Sort Order</label>
                                                <input type="number" name="sort_order" class="form-control rounded-3" value="{{ $category->sort_order }}" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted">Status</label>
                                                <select name="is_active" class="form-select rounded-3">
                                                    <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">No categories yet. Create your first one!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
