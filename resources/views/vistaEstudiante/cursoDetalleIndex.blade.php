@extends('vistaEstudiante.cursosxestudiante')



@section('subcontent')

@if (request()->cookie('success'))
<div id="alert" class="fixed top-4 right-4 z-50 flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800" style="display: flex;">
    <div class="flex items-center justify-center w-12 bg-emerald-500">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
        </svg>
    </div>
    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-semibold text-emerald-500 dark:text-emerald-400">Exito!</span>
            <p class="text-sm text-gray-600 dark:text-gray-200">{{ request()->cookie('success') }}</p>
        </div>
    </div>
</div>
@endif

 

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md drop-shadow-2xl dark:bg-gray-800">
    <!-- Título del curso -->
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white mb-4">Mi curso: {{$curso->acu_nombre}}</h2>

    <!-- Sección de Anuncios -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Anuncios</h3>
        <div class="mt-6 overflow-x-auto">
            @if($curso->anuncios->isEmpty()) <!-- Verificamos si no hay anuncios -->
                <p class="text-center text-gray-500">No hay anuncios por el momento.</p>
            @else
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="p-4 text-left">Título</th>
                        <th class="p-4 text-left">Descripción</th>

                            <th class="p-4 text-left">Fecha</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($curso->anuncios as $anuncio)
                            @if ($anuncio->estado == 'A') <!-- Solo mostramos anuncios activos -->
                                <tr>
                                    <td class="p-4">{{ $anuncio->titulo }}</td>
                                <td class="p-4">{{ $anuncio->descripcion }}</td>

                                    <td class="p-4">{{ $anuncio->fecha_publicacion }}</td>
                                  
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    

    <!-- Sección de Recursos Académicos -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Recursos Académicos</h3>
         <!-- Tabla de recursos -->
         <div class="mt-6 overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="p-4 text-left">Ícono</th>
                        <th class="p-4 text-left">Nombre del Recurso</th>
                        <th class="p-4 text-left">Descripción</th>
                        <th class="p-4 text-left">Fecha</th>
                        <th class="p-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recursos as $recurso)
                        <tr>
                            <td class="p-4">
                                <!-- Ícono dinámico según la extensión -->
                                @php
                                    $ext = pathinfo($recurso->nombre_archivo, PATHINFO_EXTENSION);
                                @endphp
                                @if ($ext == 'pdf')
                                    <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                @elseif (in_array($ext, ['doc', 'docx']))
                                    <i class="fas fa-file-word text-blue-500 text-xl"></i>
                                @elseif (in_array($ext, ['xls', 'xlsx']))
                                    <i class="fas fa-file-excel text-green-500 text-xl"></i>
                                @elseif (in_array($ext, ['ppt', 'pptx']))
                                    <i class="fas fa-file-powerpoint text-orange-500 text-xl"></i>
                                @else
                                    <i class="fas fa-file text-gray-500 text-xl"></i>
                                @endif
                            </td>
                            <td class="p-4">{{ $recurso->titulo }}</td>
                            <td class="p-4">{{ $recurso->descripcion }}</td>
                            <td class="p-4">{{ $recurso->fecha_subida }}</td>
                            <td class="p-4 flex space-x-2">
                                <!-- Botón de Descargar -->
                                <a href="{{ asset('storage/' . $recurso->ruta_archivo) }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Descargar
                                </a>
                                <!-- Botón de Editar -->
                                {{-- <button onclick="openEditModal({{ $recurso->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Editar
                                </button> --}}
                                <!-- Botón de Eliminar -->
                                {{-- <form action="{{ route('recursos.destroy', $recurso->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recurso?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                        Eliminar
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No hay recursos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sección de Actividades -->
    {{-- <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Actividades</h3>
        <p class="text-gray-600 dark:text-gray-300">Contenido de actividades aquí...</p>
    </div> --}}

    <!-- Sección de Notas -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Notas</h3>
        <div>
            @forelse($notas as $nota)
                <div class="flex justify-between items-center mb-3">
                    <!-- Comentario de la nota -->
                    <span class="text-gray-600 dark:text-gray-300">
                        {{ $nota->comentarios }}
                    </span>
    
                    <!-- Mostrar la nota con estilos condicionales -->
                    <span 
                        class="px-3 py-1 rounded-full text-white font-medium 
                        @if(is_null($nota->nota)) 
                            bg-gray-500
                        @elseif($nota->nota < 11) 
                            bg-red-500
                        @elseif($nota->nota >= 11 && $nota->nota <= 15) 
                            bg-amber-500
                        @elseif($nota->nota > 15) 
                            bg-green-500
                        @endif">
                        {{ is_null($nota->nota) ? 'Sin calificar' : $nota->nota }}
                    </span>
                </div>
            @empty
                <!-- Mensaje si no hay notas -->
                <p class="text-gray-600 dark:text-gray-300">No hay notas registradas.</p>
            @endforelse
        </div>
    </div>
    

    <!-- Sección de Asistencia -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Asistencia</h3>
        <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-md">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Reporte de Asistencias</h2>
        
            @foreach($asistencias as $fecha => $asistenciasPorFecha)
            <div class="mb-6">
                <!-- Mostrar la fecha -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-semibold text-gray-700">{{ \Carbon\Carbon::parse($fecha)->format('d-m-Y') }}</span>
                    <button class="text-indigo-600 hover:text-indigo-800 font-medium" onclick="toggleDetalle('{{ $fecha }}')">Ver Detalle</button>
                </div>
        
                <!-- Contenedor para los detalles -->
                <div id="detalle_{{ $fecha }}" class="hidden">
                    <table class="min-w-full bg-gray-50 border border-gray-200 rounded-md">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Estudiante</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Asistencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistenciasPorFecha as $asistencia)
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ $asistencia->estudiante->alu_apellidos }}, {{ $asistencia->estudiante->alu_nombres }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800">
                                        @if($asistencia->asistencia == 'F')
                                            <span class="text-red-500">Falta</span>
                                        @else
                                            <span class="text-green-500">Presente</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</section>


<div id="confirmModal" class="fixed inset-0  items-center justify-center bg-black bg-opacity-50 hidden">
    
    <div x-data="{ isOpen: false }" class="relative flex justify-center">
       
        <div x-show="isOpen" 
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave="transition duration-150 ease-in"
            x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
        >
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
                <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl rtl:text-right dark:bg-gray-900 sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                    <div>
                        <div class="flex items-center justify-center">
                            <!-- Icono de confirmación -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
    
                        <div class="mt-2 text-center">
                            <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white" id="modal-title">Confirmar Registro</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                ¿Estás seguro de que deseas registrar esta información?
                            </p>
                        </div>
                    </div>
    
                    <!-- Botones del Modal -->
                    <div class="mt-5 sm:flex sm:items-center sm:justify-between">
                        <button  id="cancelButton" class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:mt-0 sm:w-auto sm:mx-2 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                            Cancelar
                        </button>
    
                        <button id="confirmButton"  class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md sm:w-auto sm:mt-0 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                            Confirmar Registro
                        </button>
                    </div>
                </div>
            </div>
        </div>
    

    </div>
    
</div>
<script>
    function deleteCookie(name) {
    // Eliminar la cookie 'success' con los parámetros correctos
    document.cookie = name + '=; Max-Age=0; path=/; domain=' + window.location.hostname + ';';
}

// Función para ocultar el mensaje y eliminar la cookie
setTimeout(() => {
    const alert = document.getElementById('alert');
    if (alert) {
        // Ocultar el mensaje
        alert.style.display = 'none';
        
        // Eliminar la cookie 'success' después de ocultar el mensaje
        deleteCookie('success');
    }
}, 2000);
</script>

<script>
    const registerButton = document.getElementById('registerButton');
    const confirmModal = document.getElementById('confirmModal');
    const cancelButton = document.getElementById('cancelButton');
    const confirmButton = document.getElementById('confirmButton');
    
    
     // Lógica cuando se confirma el registro
     confirmButton.addEventListener('click', () => {
        // Aquí puedes proceder con el registro, por ejemplo, enviando el formulario
        document.getElementById('rolCrear').submit();
    });

    // Mostrar el modal cuando se hace clic en "Registrar"
    registerButton.addEventListener('click', () => {
        confirmModal.classList.remove('hidden');
    });

    // Ocultar el modal cuando se hace clic en "Cancelar"
    cancelButton.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
    });

</script>

<script>
    // Función para mostrar y ocultar los detalles por fecha
    function toggleDetalle(fecha) {
        const detalle = document.getElementById('detalle_' + fecha);
        if (detalle.classList.contains('hidden')) {
            detalle.classList.remove('hidden');
        } else {
            detalle.classList.add('hidden');
        }
    }
</script>
@endsection
