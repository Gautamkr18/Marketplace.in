@extends('layouts.app')
@section('title', 'POST YOUR AD | Marketplace')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="text-center mb-4">
            <h2 class="fw-extrabold text-dark" style="font-weight: 800;">POST YOUR AD</h2>
            <p class="text-muted">Reach thousands of buyers in your city instantly on Marketplace</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background:#fff;">
            <div class="card-header bg-navy text-white p-4" style="background: var(--mp-navy);">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-cloud-arrow-up fs-2 text-warning"></i>
                    <div>
                        <h5 class="fw-bold mb-0 text-white">Ad Details</h5>
                        <small class="text-white-50">Provide accurate details to sell faster</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Listing Type -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Include Listing Type *</label>
                        <div class="d-flex gap-3">
                            <div class="form-check flex-grow-1 p-0">
                                <input type="radio" class="btn-check" name="type" id="typeProduct" value="product" {{ old('type', 'product')=='product' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-dark w-100 py-3 fw-bold rounded-3 d-flex align-items-center justify-content-center gap-2" for="typeProduct">
                                    <i class="fa-solid fa-box-open fs-5"></i> Physical Product
                                </label>
                            </div>
                            <div class="form-check flex-grow-1 p-0">
                                <input type="radio" class="btn-check" name="type" id="typeService" value="service" {{ old('type')=='service' ? 'checked' : '' }}>
                                <label class="btn btn-outline-dark w-100 py-3 fw-bold rounded-3 d-flex align-items-center justify-content-center gap-2" for="typeService">
                                    <i class="fa-solid fa-handshake fs-5"></i> Local Service
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Category & Subcategory -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase small text-muted">Category *</label>
                            <select name="category_id" id="category_id" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase small text-muted">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select form-select-lg rounded-3">
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ad Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Ad Title *</label>
                        <input type="text" name="name" class="form-control form-control-lg rounded-3" 
                               placeholder="e.g. iPhone 15 Pro Max 256GB Under Warranty or Honda City 2021" 
                               value="{{ old('name') }}" required>
                        <div class="form-text">Mention key features (brand, model, condition, age).</div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Description *</label>
                        <textarea name="detail" rows="5" class="form-control rounded-3" 
                                  placeholder="Describe what you are selling, condition, reason for selling, accessories included..." 
                                  required>{{ old('detail') }}</textarea>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Set Price (₹) *</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="1" min="0" name="price" class="form-control rounded-end-3 fw-bold text-success" 
                                   placeholder="0.00" value="{{ old('price') }}" required>
                        </div>
                    </div>

                    <!-- Image Upload Zone -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Upload Photo</label>
                        <div class="p-4 border-2 border-dashed rounded-3 text-center bg-light" id="dropZone" style="border-style: dashed !important; border-color: #cbd5e1;">
                            <i class="fa-solid fa-images fs-1 text-teal mb-2" style="color: var(--mp-teal);"></i>
                            <div class="fw-bold text-dark">Click to upload or drag & drop listing photo</div>
                            <small class="text-muted d-block mb-3">PNG, JPG, WEBP up to 4MB</small>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" onchange="previewImage(this)">
                            <div id="imagePreviewContainer" class="mt-3 d-none">
                                <img id="imagePreview" src="" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <!-- Location details -->
                    <h6 class="fw-bold text-uppercase text-dark mt-4 mb-3 border-top pt-3">Location Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Country *</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', 'India') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">State *</label>
                            <input type="text" name="state" class="form-control" placeholder="e.g. Maharashtra" value="{{ old('state', 'Maharashtra') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">City *</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Mumbai" value="{{ old('city', 'Mumbai') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Area / Neighborhood</label>
                            <input type="text" name="area" class="form-control" placeholder="e.g. Bandra West" value="{{ old('area') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-dark shadow-sm rounded-3">
                        <i class="fa-solid fa-check-circle me-2"></i> POST AD NOW
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

        if (!categoryId) {
            subSelect.innerHTML = '<option value="">Select Subcategory</option>';
            return;
        }

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

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
