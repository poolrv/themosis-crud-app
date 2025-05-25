@extends('layouts.admin')

@section('content')
<!-- Alert Section para errores generales -->
    @if($errors->any())
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 py-3 px-4" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle me-3 fs-5 mt-1"></i>
                        <div>
                            <strong>¡Hay errores en el formulario!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow border-0 rounded-3 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white py-4 px-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-user-plus text-white fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Información Personal</h5>
                            <small class="opacity-75">Todos los campos marcados con (*) son obligatorios</small>
                        </div>
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('personas.store') }}" class="persona-form" novalidate>
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        name="nombre" 
                                        type="text" 
                                        id="nombre" 
                                        value="{{ old('nombre') }}" 
                                        class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                                        placeholder="Ingresa el nombre"
                                        required 
                                    />
                                    @error('nombre')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Solo letras y espacios permitidos
                                    </div>
                                </div>
                            </div>

                            <!-- Apellido -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellido" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-user-tag me-2 text-primary"></i>
                                        Apellido <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        name="apellido" 
                                        type="text" 
                                        id="apellido" 
                                        value="{{ old('apellido') }}" 
                                        class="form-control form-control-lg @error('apellido') is-invalid @enderror" 
                                        placeholder="Ingresa el apellido"
                                        required 
                                    />
                                    @error('apellido')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Solo letras y espacios permitidos
                                    </div>
                                </div>
                            </div>

                            <!-- RUT -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rut" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        RUT <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-hashtag text-muted"></i>
                                        </span>
                                        <input 
                                            name="rut" 
                                            type="text" 
                                            id="rut" 
                                            value="{{ old('rut') }}" 
                                            class="form-control @error('rut') is-invalid @enderror" 
                                            placeholder="12345678-9"
                                            required 
                                        />
                                        <div id="rut-status" class="input-group-text bg-light">
                                            <i class="fas fa-question-circle text-muted"></i>
                                        </div>
                                        @error('rut')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="fas fa-exclamation-circle me-2"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Formato: 12345678-9 (sin puntos, con guión)
                                    </div>
                                </div>
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_nacimiento" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-calendar me-2 text-primary"></i>
                                        Fecha de Nacimiento <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-calendar-alt text-muted"></i>
                                        </span>
                                        <input 
                                            name="fecha_nacimiento" 
                                            type="date" 
                                            id="fecha_nacimiento" 
                                            value="{{ old('fecha_nacimiento') }}" 
                                            class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                            required 
                                        />
                                        @error('fecha_nacimiento')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="fas fa-exclamation-circle me-2"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Selecciona la fecha de nacimiento
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Separador -->
                        <hr class="my-5 border-2">

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        <small>Todos los datos son seguros y confidenciales</small>
                                    </div>
                                    
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('personas.index') }}" class="btn btn-light btn-lg px-4 py-2 border">
                                            <i class="fas fa-times me-2"></i>
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-2 shadow-sm">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Persona
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card border-0 bg-light h-100">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="fas fa-shield-alt text-white fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Datos Seguros</h6>
                    <small class="text-muted">Toda la información es encriptada y protegida</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-light h-100">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="fas fa-check-double text-white fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Validación Automática</h6>
                    <small class="text-muted">El RUT se valida automáticamente mientras escribes</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-light h-100">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-info bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="fas fa-clock text-white fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Guardado Rápido</h6>
                    <small class="text-muted">Los datos se procesan instantáneamente</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Avatares con diferentes tamaños */
.avatar-sm {
    width: 35px;
    height: 35px;
}

.avatar-md {
    width: 45px;
    height: 45px;
}

.avatar-lg {
    width: 55px;
    height: 55px;
}

.avatar-xl {
    width: 80px;
    height: 80px;
}

/* Form improvements */
.form-control {
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
    transform: translateY(-1px);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.1);
}

.form-control.is-valid {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.1);
}

/* Input group improvements */
.input-group-text {
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    background-color: #f8f9fa;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 0.75rem 0.75rem 0;
}

.input-group .input-group-text:first-child {
    border-right: none;
    border-radius: 0.75rem 0 0 0.75rem;
}

.input-group .input-group-text:last-child {
    border-left: none;
    border-radius: 0 0.75rem 0.75rem 0;
}

/* Label improvements */
.form-label {
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
}

/* Button improvements */
.btn {
    font-weight: 500;
    transition: all 0.3s ease;
    border-width: 2px;
    border-radius: 0.75rem;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}

/* Card improvements */
.card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.08);
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

/* Gradientes */
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
}

/* Form text improvements */
.form-text {
    font-size: 0.85rem;
    margin-top: 0.5rem;
    color: #6c757d;
}

/* Invalid feedback improvements */
.invalid-feedback {
    font-size: 0.9rem;
    font-weight: 500;
}

/* RUT status indicator */
#rut-status {
    min-width: 45px;
    justify-content: center;
}

#rut-status.valid {
    background-color: #d4edda !important;
    border-color: #28a745 !important;
    color: #155724;
}

#rut-status.invalid {
    background-color: #f8d7da !important;
    border-color: #dc3545 !important;
    color: #721c24;
}

/* Responsive improvements */
@media (max-width: 767.98px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    .btn-lg {
        padding: 0.6rem 1.5rem;
        font-size: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
}

@media (min-width: 768px) {
    .container-fluid {
        padding-left: 2rem;
        padding-right: 2rem;
    }
}

/* Animation for form validation */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.form-control.is-invalid {
    animation: shake 0.5s ease-in-out;
}

/* Loading state for submit button */
.btn.loading {
    position: relative;
    color: transparent;
}

.btn.loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos
    const rutInput = document.getElementById('rut');
    const rutStatus = document.getElementById('rut-status');
    const form = document.querySelector('.persona-form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Validación RUT en tiempo real
    rutInput.addEventListener('input', function() {
        let rut = this.value.replace(/[^0-9kK]/g, '');
        
        // Formatear RUT
        if (rut.length > 1) {
            rut = rut.slice(0, -1) + '-' + rut.slice(-1);
        }
        
        this.value = rut;
        
        // Validar RUT
        if (rut.length >= 3) {
            if (validarRut(rut)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                rutStatus.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
                rutStatus.className = 'input-group-text bg-light valid';
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                rutStatus.innerHTML = '<i class="fas fa-times-circle text-danger"></i>';
                rutStatus.className = 'input-group-text bg-light invalid';
            }
        } else {
            this.classList.remove('is-valid', 'is-invalid');
            rutStatus.innerHTML = '<i class="fas fa-question-circle text-muted"></i>';
            rutStatus.className = 'input-group-text bg-light';
        }
    });
    
    // Función para validar RUT
    function validarRut(rut) {
        rut = rut.replace(/[^k0-9]/i, '');
        let dv = rut.substr(-1);
        let numero = rut.substr(0, rut.length-1);
        let i = 2;
        let suma = 0;
        
        for (let j = numero.length - 1; j >= 0; j--) {
            if (i == 8) i = 2;
            suma += numero.charAt(j) * i;
            i++;
        }
        
        let dvr = 11 - (suma % 11);
        if (dvr == 11) dvr = 0;
        if (dvr == 10) dvr = "K";
        
        return dv.toLowerCase() == dvr.toString().toLowerCase();
    }
    
    // Validación de nombres (solo letras y espacios)
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');
    
    [nombreInput, apellidoInput].forEach(input => {
        input.addEventListener('input', function() {
            const valor = this.value;
            const soloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;
            
            if (valor && !soloLetras.test(valor)) {
                this.value = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            }
            
            // Validación visual
            if (this.value.length >= 2) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else if (this.value.length > 0) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });
    });
    
    // Validación de fecha
    const fechaInput = document.getElementById('fecha_nacimiento');
    fechaInput.addEventListener('change', function() {
        const fecha = new Date(this.value);
        const hoy = new Date();
        const edad = hoy.getFullYear() - fecha.getFullYear();
        
        if (fecha > hoy) {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        } else if (edad > 120) {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
    
    // Loading state en submit
    form.addEventListener('submit', function(e) {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        
        // Si hay errores de validación, remover loading
        setTimeout(() => {
            if (form.querySelector('.is-invalid')) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        }, 100);
    });
    
    // Animaciones suaves para los inputs
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
    
    // Auto-focus en el primer campo
    nombreInput.focus();
});
</script>
@endsection