@extends('layouts.app')
@section('title', 'Edit Ad: '.$listing->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="text-center mb-4">
            <h2 class="fw-extrabold text-dark" style="font-weight: 800;">EDIT AD</h2>
            <p class="text-muted">Update listing information or photos for {{ $listing->name }}</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background:#fff;">
            <div class="card-header bg-navy text-white p-4" style="background: var(--mp-navy);">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-pen-to-square fs-2 text-warning"></i>
                    <div>
                        <h5 class="fw-bold mb-0 text-white">Modify Details</h5>
                        <small class="text-white-50">Ad ID: #MP-{{ $listing->id * 8421 }}</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Type -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Item Type</label>
                        <select name="type" class="form-select form-select-lg rounded-3" required>
                            <option value="product" {{ $listing->type=='product'?'selected':'' }}>Product</option>
                            <option value="service" {{ $listing->type=='service'?'selected':'' }}>Service</option>
                        </select>
                    </div>

                    <!-- Category & Subcategory -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase small text-muted">Category *</label>
                            <select name="category_id" id="category_id" class="form-select form-select-lg rounded-3" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $listing->category_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase small text-muted">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select form-select-lg rounded-3">
                                @foreach($categories->firstWhere('id', $listing->category_id)?->subcategories ?? [] as $sub)
                                    <option value="{{ $sub->id }}" {{ $listing->subcategory_id==$sub->id?'selected':'' }}>{{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Ad Title *</label>
                        <input type="text" name="name" class="form-control form-control-lg rounded-3" value="{{ old('name', $listing->name) }}" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Description *</label>
                        <textarea name="detail" rows="5" class="form-control rounded-3" required>{{ old('detail', $listing->detail) }}</textarea>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Price (₹) *</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="1" min="0" name="price" class="form-control rounded-end-3 fw-bold text-success" value="{{ old('price', $listing->price) }}" required>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Photo</label>
                        @if($listing->image_url)
                            <div class="mb-2">
                                <img src="{{ $listing->image_url }}" class="img-thumbnail rounded-3" style="max-height:140px">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <!-- Location details -->
                    <h6 class="fw-bold text-uppercase text-dark mt-4 mb-3 border-top pt-3">Location Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Country *</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $listing->country) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">State *</label>
                            <input type="text" name="state" class="form-control" value="{{ old('state', $listing->state) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">City *</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $listing->city) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Area</label>
                            <input type="text" name="area" class="form-control" value="{{ old('area', $listing->area) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-dark shadow-sm rounded-3">
                        <i class="fa-solid fa-save me-2"></i> UPDATE AD
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('category_id').addEventListener('change', function () {
        const categoryId = this.value;
        const subSelect = document.getElementById('subcategory_id');
        subSelect.innerHTML = '<option value="">Loading...</option>';
        if (!categoryId) { subSelect.innerHTML = '<option value="">Select Subcategory</option>'; return; }

        fetch(`/ajax/categories/${categoryId}/subcategories`)
            .then(res => res.json())
            .then(data => {
                subSelect.innerHTML = '<option value="">Select Subcategory</option>';
                data.forEach(sub => {
                    const opt = document.createElement('option');
                    opt.value = sub.id;
                    opt.textContent = sub.name;
                    subSelect.appendChild(opt);
                });
            });
    });
</script>
@endsection
