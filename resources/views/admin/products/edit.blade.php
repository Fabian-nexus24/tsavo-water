@extends('layouts.admin')

@section('page-title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-circle me-3"><i class="bi bi-arrow-left"></i></a>
            <h4 class="fw-bold mb-0">Edit Product: {{ $product->name }}</h4>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <h6 class="text-muted text-uppercase fw-bold small mb-3">Basic Info</h6>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <h6 class="text-muted text-uppercase fw-bold small mb-3">Pricing & Inventory</h6>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Regular Price (KES) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Cost Price (KES) <small class="text-muted fw-normal">(For profit calculation)</small></label>
                            <input type="number" step="0.01" name="cost_price" class="form-control @error('cost_price') is-invalid @enderror" value="{{ old('cost_price', $product->cost_price) }}">
                            @error('cost_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sale Price (KES)</label>
                            <input type="number" step="0.01" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $product->sale_price) }}">
                            @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <h6 class="text-muted text-uppercase fw-bold small mb-3">Settings & Media</h6>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Update Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @if($product->image)
                                <div class="mt-2 text-muted small"><i class="bi bi-info-circle me-1"></i> Current image will be replaced</div>
                            @endif
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured Product (shows on home page)</label>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4 border-light">
                    
                    <div class="text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-pill px-4 me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
