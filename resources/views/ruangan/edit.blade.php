@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-3 mb-md-4 gap-2">
        <div>
            <h2 class="mb-1 fs-4 fs-md-3">
                <i class="fas fa-edit text-warning"></i> Edit Ruangan
            </h2>
            <p class="text-muted mb-0 small">Ubah informasi ruangan</p>
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
        <div class="card-header bg-warning bg-gradient text-dark">
            <h5 class="mb-0 fs-6 fw-bold">
                <i class="fas fa-door-open"></i> Formulir Edit Ruangan
            </h5>
        </div>
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('ruangan.update', $ruangan->id_ruangan) }}" method="POST" id="formRuangan">
                @csrf
                @method('PUT')

                <!-- Current Info Display -->
                <div class="alert alert-info border-0 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>Data Saat Ini:</strong>
                            <div class="mt-1">
                                <span class="badge bg-primary">{{ $ruangan->nama_ruangan }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nama Ruangan -->
                <div class="mb-4">
                    <label for="nama" class="form-label fw-semibold">
                        Nama Ruangan <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-door-closed text-warning"></i>
                        </span>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $ruangan->nama_ruangan) }}" 
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
                    <button type="submit" class="btn btn-warning text-dark order-1 order-sm-2">
                        <i class="fas fa-save"></i> Update Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card mt-3 border-warning shadow-sm">
        <div class="card-body p-3">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-triangle text-warning me-3 mt-1 fs-5"></i>
                <div>
                    <h6 class="mb-2 fw-bold">Perhatian</h6>
                    <ul class="small mb-0 ps-3">
                        <li>Perubahan nama ruangan akan mempengaruhi semua data barang yang terkait</li>
                        <li>Pastikan nama yang diubah sudah sesuai dengan kebutuhan</li>
                        <li>Gunakan nama yang konsisten dan mudah dikenali</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Additional Info: Items Count -->
        @if(isset($ruangan->items) && $ruangan->items->count() > 0)
        <div class="card-footer bg-light border-top">
            <small class="text-muted">
                <i class="fas fa-box"></i> 
                <strong>{{ $ruangan->items->count() }}</strong> barang terkait dengan ruangan ini
            </small>
        </div>
        @endif
    </div>

    <!-- History Card (Optional) -->
    <div class="card mt-3 border-0 shadow-sm bg-light">
        <div class="card-body p-3">
            <div class="row g-2 small text-muted">
                <div class="col-12 col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-plus me-2"></i>
                        <div>
                            <div class="fw-semibold">Dibuat</div>
                            <div>{{ $ruangan->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-check me-2"></i>
                        <div>
                            <div class="fw-semibold">Terakhir Diubah</div>
                            <div>{{ $ruangan->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
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
    border-bottom: 2px solid rgba(0,0,0,0.1);
}

/* Form Styling */
.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
}

.input-group-text {
    border: 1px solid #dee2e6;
    transition: all 0.3s;
}

.form-control:focus + .input-group-text,
.input-group:focus-within .input-group-text {
    border-color: #ffc107;
    background-color: #fff3cd !important;
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

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    border: none;
    font-weight: 600;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #ffb300 0%, #ffa000 100%);
}

/* Alert Styling */
.alert {
    border-radius: 0.5rem;
    border: none;
}

.alert-danger {
    border-left: 4px solid #dc3545;
    background-color: #f8d7da;
    color: #721c24;
}

.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
}

/* Border Warnings */
.border-warning {
    border-left: 4px solid #ffc107 !important;
}

/* Badge in Alert */
.alert .badge {
    font-size: 0.9rem;
    padding: 0.4rem 0.6rem;
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

    .badge {
        font-size: 0.8rem !important;
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

.card:nth-child(2) {
    animation-delay: 0.1s;
}

.card:nth-child(3) {
    animation-delay: 0.2s;
}

.card:nth-child(4) {
    animation-delay: 0.3s;
}

/* Focus Visible for Accessibility */
button:focus-visible,
a:focus-visible,
input:focus-visible {
    outline: 2px solid #ffc107;
    outline-offset: 2px;
}

/* Card Footer */
.card-footer {
    background-color: #f8f9fa;
    padding: 0.75rem 1rem;
}

/* Gradient Text */
.bg-gradient {
    background-image: linear-gradient(180deg, rgba(255,255,255,.15), rgba(255,255,255,0));
}
</style>

<script>
// Form Enhancement
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRuangan');
    const submitBtn = form.querySelector('button[type="submit"]');
    const namaInput = document.getElementById('nama');
    const originalValue = namaInput.value;
    
    // Auto-capitalize first letter
    namaInput.addEventListener('input', function(e) {
        let value = e.target.value;
        e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
    });
    
    // Detect changes
    namaInput.addEventListener('input', function() {
        if (this.value !== originalValue) {
            submitBtn.classList.add('pulse');
        } else {
            submitBtn.classList.remove('pulse');
        }
    });
    
    // Form submit handling
    form.addEventListener('submit', function(e) {
        // Check if value changed
        if (namaInput.value === originalValue) {
            e.preventDefault();
            alert('Tidak ada perubahan data yang dilakukan!');
            return false;
        }
        
        // Confirm update
        if (!confirm('Apakah Anda yakin ingin mengubah nama ruangan?\n\nPerubahan ini akan mempengaruhi semua data terkait.')) {
            e.preventDefault();
            return false;
        }
        
        // Disable button to prevent double submit
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        
        // If validation fails, re-enable button
        if (!form.checkValidity()) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Update Ruangan';
        }
    });
    
    // Keyboard shortcut: Ctrl+S to save
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            form.requestSubmit();
        }
    });
});

// Add pulse animation class
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .pulse {
        animation: pulse 0.5s ease-in-out;
    }
`;
document.head.appendChild(style);
</script>
@endsection