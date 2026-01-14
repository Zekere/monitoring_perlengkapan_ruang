@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-3 mb-md-4 gap-2">
        <div>
            <h2 class="mb-1 fs-4 fs-md-3">
                <i class="fas fa-plus-circle text-primary"></i> Tambah Ruangan
            </h2>
            <p class="text-muted mb-0 small">Masukkan data ruangan baru</p>
        </div>
        <a href="{{ route('ruangan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-circle me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>Terdapat kesalahan!</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Form Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary bg-gradient text-white">
            <h5 class="mb-0 fs-6">
                <i class="fas fa-door-open"></i> Formulir Ruangan
            </h5>
        </div>
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('ruangan.store') }}" method="POST" id="formRuangan">
                @csrf

                <!-- Nama Ruangan -->
                <div class="mb-4">
                    <label for="nama" class="form-label fw-semibold">
                        Nama Ruangan <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-door-closed text-primary"></i>
                        </span>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama') }}" 
                               placeholder="Contoh: Ruang Kelas 1A, Lab Komputer, dll"
                               required
                               autofocus>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Masukkan nama ruangan yang jelas dan spesifik
                    </small>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                    <a href="{{ route('ruangan.index') }}" class="btn btn-outline-secondary order-2 order-sm-1">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary order-1 order-sm-2">
                        <i class="fas fa-save"></i> Tambah Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card mt-3 border-info shadow-sm">
        <div class="card-body p-3">
            <div class="d-flex align-items-start">
                <i class="fas fa-lightbulb text-warning me-3 mt-1 fs-5"></i>
                <div>
                    <h6 class="mb-2 fw-bold">Tips Pengisian</h6>
                    <ul class="small mb-0 ps-3">
                        <li>Gunakan nama yang mudah dikenali dan dipahami</li>
                        <li>Hindari penggunaan singkatan yang tidak umum</li>
                        <li>Cantumkan nomor atau kode jika diperlukan (contoh: Lab 1, Kelas 3B)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Enhancements */
.card {
    border-radius: 0.75rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card-header {
    border-bottom: 2px solid rgba(255,255,255,0.2);
}

/* Form Styling */
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.input-group-text {
    border: 1px solid #dee2e6;
    transition: all 0.3s;
}

.form-control:focus + .input-group-text,
.input-group:focus-within .input-group-text {
    border-color: #0d6efd;
    background-color: #e7f1ff !important;
}

/* Button Styling */
.btn {
    font-weight: 500;
    padding: 0.5rem 1.25rem;
    transition: all 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
}

/* Alert Styling */
.alert {
    border-radius: 0.5rem;
    border: none;
    border-left: 4px solid;
}

.alert-danger {
    border-left-color: #dc3545;
    background-color: #f8d7da;
    color: #721c24;
}

/* Info Card */
.border-info {
    border-left: 4px solid #0dcaf0 !important;
}

/* Mobile Optimizations */
@media (max-width: 576px) {
    .fs-4 {
        font-size: 1.15rem !important;
    }
    
    .fs-6 {
        font-size: 0.95rem !important;
    }
    
    h6 {
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .btn {
        width: 100%;
        padding: 0.6rem 1rem;
    }
    
    .input-group-text {
        padding: 0.5rem;
    }
    
    .form-control {
        font-size: 0.95rem;
    }
    
    small {
        font-size: 0.8rem;
    }
    
    .alert ul {
        font-size: 0.85rem;
    }
}

/* Tablet Optimizations */
@media (min-width: 577px) and (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
}

/* Touch-friendly */
@media (max-width: 768px) {
    .form-control,
    .btn {
        min-height: 44px;
    }
    
    .input-group-text {
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

/* Loading State */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

/* Form Validation */
.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
}

/* Hover Effects */
@media (hover: hover) {
    .card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
    }
}

/* Icon Styling */
.fas, .far {
    transition: all 0.3s;
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeIn 0.5s ease;
}

/* Focus Visible for Accessibility */
button:focus-visible,
a:focus-visible,
input:focus-visible {
    outline: 2px solid #0d6efd;
    outline-offset: 2px;
}
</style>

<script>
// Form Enhancement
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRuangan');
    const submitBtn = form.querySelector('button[type="submit"]');
    const namaInput = document.getElementById('nama');
    
    // Auto-capitalize first letter
    namaInput.addEventListener('input', function(e) {
        // Capitalize first letter of each word
        let value = e.target.value;
        e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
    });
    
    // Form submit handling
    form.addEventListener('submit', function(e) {
        // Disable button to prevent double submit
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        
        // If validation fails, re-enable button
        if (!form.checkValidity()) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Tambah Ruangan';
        }
    });
    
    // Character counter (optional)
    namaInput.addEventListener('input', function() {
        const maxLength = 100;
        const currentLength = this.value.length;
        
        if (currentLength > maxLength * 0.8) {
            console.log(`${currentLength}/${maxLength} karakter`);
        }
    });
});
</script>
@endsection