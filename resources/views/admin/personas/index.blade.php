@extends('layouts.admin')

@section('content')
    <!-- Alert Section con mejor espaciado -->
    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 py-3 px-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fs-5"></i>
                        <div>
                            <strong>¡Éxito!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content Card con mejor espaciado -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0 rounded-3 overflow-hidden">
                <!-- Card Header mejorado -->
                <div class="card-header bg-gradient-primary text-white py-4 px-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="fas fa-table me-2"></i>
                                Lista de Personas Registradas
                            </h5>
                            <small class="opacity-75">Gestiona y visualiza toda la información</small>
                        </div>
                        <span class="badge bg-white text-primary px-3 py-2 fs-6">
                            {{ $personas->count() }} {{ $personas->count() == 1 ? 'registro' : 'registros' }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($personas->count() > 0)
                        <!-- Desktop Table con mejor espaciado -->
                        <div class="table-responsive d-none d-lg-block">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 fw-bold py-4 px-4 text-uppercase text-muted fs-7">
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            Nombre Completo
                                        </th>
                                        <th class="border-0 fw-bold py-4 px-4 text-uppercase text-muted fs-7">
                                            <i class="fas fa-id-card me-2 text-primary"></i>
                                            RUT
                                        </th>
                                        <th class="border-0 fw-bold py-4 px-4 text-uppercase text-muted fs-7">
                                            <i class="fas fa-calendar me-2 text-primary"></i>
                                            Fecha Nacimiento
                                        </th>
                                        <th class="border-0 fw-bold py-4 px-4 text-uppercase text-muted fs-7 text-center">
                                            <i class="fas fa-cogs me-2 text-primary"></i>
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($personas as $persona)
                                        <tr class="border-bottom">
                                            <td class="py-4 px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-lg bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm">
                                                        <i class="fas fa-user text-white fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 fw-bold text-dark">{{ $persona->nombre }} {{ $persona->apellido }}</h6>
                                                        <small class="text-muted">Persona registrada</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="badge bg-light text-dark px-3 py-2 fs-6 border">
                                                    {{ $persona->rut_formateado }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                                    <span class="text-dark fw-medium">{{ $persona->fecha_nacimiento->format('d/m/Y') }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('personas.edit', $persona->id) }}" 
                                                       class="btn btn-outline-primary btn-sm px-3 py-2 rounded-pill" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Editar información">
                                                        <i class="fas fa-edit me-1"></i>
                                                        Editar
                                                    </a>
                                                    
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-sm px-3 py-2 rounded-pill btn-delete" 
                                                            data-persona-id="{{ $persona->id }}"
                                                            data-persona-nombre="{{ $persona->nombre }}"
                                                            data-persona-apellido="{{ $persona->apellido }}"
                                                            data-persona-rut="{{ $persona->rut_formateado }}"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal"
                                                            title="Eliminar persona">
                                                        <i class="fas fa-trash me-1"></i>
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tablet View -->
                        <div class="d-none d-md-block d-lg-none p-4">
                            @foreach($personas as $persona)
                                <div class="card border mb-4 shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-lg bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-1 fw-bold">{{ $persona->nombre }} {{ $persona->apellido }}</h5>
                                                    <span class="badge bg-light text-dark">{{ $persona->rut_formateado }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('personas.edit', $persona->id) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger btn-sm btn-delete" 
                                                        data-persona-id="{{ $persona->id }}"
                                                        data-persona-nombre="{{ $persona->nombre }}"
                                                        data-persona-apellido="{{ $persona->apellido }}"
                                                        data-persona-rut="{{ $persona->rut_formateado }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1">Fecha de Nacimiento</small>
                                                <span class="fw-medium">{{ $persona->fecha_nacimiento->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Mobile Cards -->
                        <div class="d-md-none p-3">
                            @foreach($personas as $persona)
                                <div class="card border mb-3 shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $persona->nombre }} {{ $persona->apellido }}</h6>
                                                    <small class="text-muted">{{ $persona->rut_formateado }}</small>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                                    <li>
                                                        <a class="dropdown-item py-2" href="{{ route('personas.edit', $persona->id) }}">
                                                            <i class="fas fa-edit me-2 text-primary"></i>Editar
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button class="dropdown-item text-danger py-2 btn-delete" 
                                                                data-persona-id="{{ $persona->id }}"
                                                                data-persona-nombre="{{ $persona->nombre }}"
                                                                data-persona-apellido="{{ $persona->apellido }}"
                                                                data-persona-rut="{{ $persona->rut_formateado }}"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteModal">
                                                            <i class="fas fa-trash me-2"></i>Eliminar
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="border-top pt-3">
                                            <small class="text-muted d-block mb-1">Fecha de Nacimiento</small>
                                            <span class="fw-medium">{{ $persona->fecha_nacimiento->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State mejorado -->
                        <div class="text-center py-5 px-4">
                            <div class="mb-4">
                                <div class="avatar-xl bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4">
                                    <i class="fas fa-users fa-2x text-muted"></i>
                                </div>
                            </div>
                            <h4 class="text-muted mb-3 fw-bold">No hay personas registradas</h4>
                            <p class="text-muted mb-4 fs-6">Comienza agregando tu primera persona al sistema para empezar a gestionar la información</p>
                            <a href="{{ route('personas.create') }}" class="btn btn-primary btn-lg px-4 py-3">
                                <i class="fas fa-plus me-2"></i>
                                Agregar Primera Persona
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal ÚNICO fuera del foreach -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2 fs-4"></i>
                        Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-4 text-muted">¿Estás seguro de que deseas eliminar a esta persona?</p>
                    <div class="alert alert-light border p-4 rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-md bg-danger bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold" id="modal-persona-nombre"><!-- Se llenará con JS --></h6>
                                <small class="text-muted" id="modal-persona-rut"><!-- Se llenará con JS --></small>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning border-warning bg-warning bg-opacity-10 p-3 rounded-3">
                        <small class="text-warning-emphasis">
                            <i class="fas fa-info-circle me-1"></i>
                            Esta acción no se puede deshacer.
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </button>
                    <form method="POST" action="" id="delete-form" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 py-2">
                            <i class="fas fa-trash me-2"></i>
                            Eliminar Definitivamente
                        </button>
                    </form>
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

/* Mejoras en la tabla */
.table th {
    font-weight: 700;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    background-color: #f8f9fa !important;
}

.table td {
    font-size: 0.9rem;
    vertical-align: middle;
}

/* Botones mejorados */
.btn {
    font-weight: 500;
    transition: all 0.3s ease;
    border-width: 1.5px;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-sm {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
}

/* Cards mejoradas */
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

/* Hover effects */
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.03);
    transform: scale(1.001);
    transition: all 0.2s ease;
}

/* Modal backdrop más suave */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.4) !important;
    backdrop-filter: blur(2px);
}

.modal-backdrop.show {
    opacity: 1 !important;
}

/* Modal improvements */
.modal-dialog {
    max-height: 90vh;
    margin: 2rem auto;
    display: flex;
    align-items: center;
}

.modal-content {
    border-radius: 1rem;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    max-height: 85vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.modal-header {
    padding: 1.5rem 1.5rem 1rem;
    border-bottom: 1px solid #e9ecef;
    flex-shrink: 0;
}

.modal-body {
    padding: 1rem 1.5rem;
    overflow-y: auto;
    flex-grow: 1;
    max-height: calc(85vh - 140px);
}

.modal-footer {
    padding: 1rem 1.5rem 1.5rem;
    border-top: 1px solid #e9ecef;
    flex-shrink: 0;
    background-color: #f8f9fa;
}

/* Asegurar que el modal esté por encima */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
}

/* Centrar modal verticalmente siempre */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -20px);
}

.modal.show .modal-dialog {
    transform: none;
}

/* Responsive modal */
@media (max-width: 767.98px) {
    .modal-dialog {
        margin: 1rem;
        max-height: 95vh;
    }
    
    .modal-content {
        max-height: 90vh;
        border-radius: 0.75rem;
    }
    
    .modal-body {
        max-height: calc(90vh - 120px);
    }
    
    .modal-header {
        padding: 1rem 1rem 0.5rem;
    }
    
    .modal-footer {
        padding: 0.5rem 1rem 1rem;
    }
}

@media (max-width: 575.98px) {
    .modal-dialog {
        margin: 0.5rem;
        max-height: 98vh;
    }
    
    .modal-content {
        max-height: 95vh;
    }
    
    .modal-body {
        max-height: calc(95vh - 100px);
        padding: 0.75rem 1rem;
    }
}

/* Scrollbar personalizada para el modal body */
.modal-body::-webkit-scrollbar {
    width: 6px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive spacing */
@media (max-width: 767.98px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .modal-dialog {
        margin: 1rem;
    }
    
    .modal-content {
        border-radius: 0.75rem;
    }
}

@media (min-width: 768px) {
    .container-fluid {
        padding-left: 2rem;
        padding-right: 2rem;
    }
}

/* Font sizes */
.fs-7 {
    font-size: 0.875rem;
}

/* Alert improvements */
.alert {
    border-radius: 0.75rem;
    border: none;
}

/* Badge improvements */
.badge {
    font-weight: 500;
    border-radius: 0.5rem;
}

/* Prevenir scroll del body cuando el modal está abierto */
body.modal-open {
    padding-right: 0 !important;
}

/* Animación suave para el modal */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Manejar clicks en botones de eliminar
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Obtener datos de la persona desde los data attributes
            const personaId = this.getAttribute('data-persona-id');
            const personaNombre = this.getAttribute('data-persona-nombre');
            const personaApellido = this.getAttribute('data-persona-apellido');
            const personaRut = this.getAttribute('data-persona-rut');
            
            // Actualizar el contenido del modal
            document.getElementById('modal-persona-nombre').textContent = personaNombre + ' ' + personaApellido;
            document.getElementById('modal-persona-rut').textContent = 'RUT: ' + personaRut;
            
            // Actualizar la acción del formulario con la URL correcta
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = "{{ route('personas.destroy', '') }}/" + personaId;
            
            // Cerrar tooltips
            const tooltips = document.querySelectorAll('.tooltip');
            tooltips.forEach(tooltip => tooltip.remove());
        });
    });
    
    // Mejorar el manejo de modales
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', function() {
            // Cerrar tooltips
            const tooltips = document.querySelectorAll('.tooltip');
            tooltips.forEach(tooltip => tooltip.remove());
        });
        
        modal.addEventListener('shown.bs.modal', function() {
            // Enfocar el modal para accesibilidad
            this.focus();
        });
        
        modal.addEventListener('hidden.bs.modal', function() {
            // Limpiar clases y estilos
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    }
    
    // Add smooth animations para cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Manejar tecla ESC para cerrar modales
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                const modal = bootstrap.Modal.getInstance(openModal);
                if (modal) {
                    modal.hide();
                }
            }
        }
    });
    
    // Prevenir doble envío del formulario
    const deleteForm = document.getElementById('delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Eliminando...';
        });
    }
});
</script>
@endsection