@extends('vistasDocente.cursoxDocentes')

@section('subcontent')
@php
    $data = [

        'acdo_id_value' => $acdo_id_value,
    ];

    // Verificar si alguna variable tiene valor nulo o vacío
    $hasEmptyData = collect($data)->contains(function ($value) {
        return is_null($value) || 
               (is_object($value) && method_exists($value, 'isEmpty') && $value->isEmpty()) || 
               (is_array($value) && empty($value)) || 
               ($value === 'vacio'); // Para detectar valores asignados como 'vacio'
    });
@endphp

@if($hasEmptyData)
        <!-- Mostrar un mensaje de advertencia si hay datos vacíos -->
        <div class="p-4 mb-4 bg-yellow-100 text-yellow-800 rounded">
            <strong>Error:</strong> El curso al que a sido asignado, no cuenta con estudiantes registrado. Por favor espere a la asignacion de estudiantes o pongase en contacto con soporte.
        </div>
@else


{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
{{-- ANUNCIOSmodal --}}
    
    <div class="flex justify-between items-center">
        <button onclick="openModal({{ $curso->acu_id }})" class="text-gray-600 hover:text-gray-800">
            <h3 class="text-2xl font-semibold text-gray-800">Registrar Anuncio</h3>
        </button>
    </div>
    
    {{-- MODAL PARA LA SECCIÓN DE ANUNCIOS --}}
    <div id="modalRegistrarAnuncio" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <!-- Encabezado del Modal -->
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-semibold text-gray-800">Registrar Anuncio</h3>
                <button onclick="closeModal1()" class="text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Formulario para registrar un anuncio -->
            <form action="{{ route('docentesAnuncios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_curso" id="id_curso" value="{{ $curso->acu_id }}">
    
                <!-- Título del anuncio -->
                <div class="mt-4">
                    <label for="titulo" class="block text-gray-700 font-medium">Título</label>
                    <input type="text" name="titulo" id="titulo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese el título" required>
                </div>
    
                <!-- Descripción del anuncio -->
                <div class="mt-4">
                    <label for="descripcion" class="block text-gray-700 font-medium">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese la descripción" required></textarea>
                </div>
    
                <!-- Botones de acción -->
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Registrar</button>
                </div>
            </form>
        </div>
    </div>
    


{{-- MODAL PARA EDITAR UNA ANUNCIO DENTRO DE SECTION ANUNCIOS --}}

<div id="modalEditarAnuncio" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <!-- Encabezado del Modal -->
        <div class="flex justify-between items-center">
            <h3 class="text-2xl font-semibold text-gray-800">Editar Anuncio</h3>
            <button onclick="closeModalEdicionAnuncio()" class="text-gray-600 hover:text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Formulario para editar un anuncio 
          const url = "{{ route('docentesAnuncios.update', ':id') }}".replace(':id', anuncioId);
        document.getElementById('editAnuncioForm').action = url;
        -->
        <form id="editAnuncioForm" action="{{ route('docentesAnuncios.update', ':id') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_anuncio" id="id_anuncioo">

            <!-- Título del anuncio -->
            <div class="mt-4">
                <label for="titulo" class="block text-gray-700 font-medium">Título</label>
                <input type="text" name="titulo" id="tituloAnuncioo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese el título" required>
            </div>

            <!-- Descripción del anuncio -->
            <div class="mt-4">
                <label for="descripcion" class="block text-gray-700 font-medium">Descripción</label>
                <textarea name="descripcion" id="descripcionn" rows="4" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese la descripción" required></textarea>
            </div>

            <!-- Botones de acción -->
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" onclick="closeModalAnuncioEditar()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Actualizar</button>
            </div>
        </form>
    </div>
</div>



{{-- RecursoModal --}}
{{-- RecursoModal --}}
{{-- RecursoModal --}}
{{-- RecursoModal --}}
{{-- RecursoModal --}}
{{-- RecursoModal --}}
{{-- RecursoModal --}}


<div id="modalEditarRecurso" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <!-- Encabezado del Modal -->
        <div class="flex justify-between items-center">
            <h3 class="text-2xl font-semibold text-gray-800">Editar Recurso Académico</h3>
            <button onclick="closeModalEdicionRecurso()" class="text-gray-600 hover:text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Formulario para editar un recurso -->
        {{-- {{ route('docentesRecursos.update', ':id') }} --}}
        <form id="editRecursoForm" action="{{ route('docentesRecursos.update', ':id') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_recurso" id="id_recurso">

            <!-- Título del recurso -->
            <div class="mt-4">
                <label for="titulo" class="block text-gray-700 font-medium">Título</label>
                <input type="text" name="titulo" id="tituloRecurso" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese el título" required>
            </div>

            <!-- Descripción del recurso -->
            <div class="mt-4">
                <label for="descripcion" class="block text-gray-700 font-medium">Descripción</label>
                <textarea name="descripcion" id="descripcionRecurso" rows="4" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese la descripción"></textarea>
            </div>

            <!-- Enlace del recurso -->
            <div class="mt-4">
                <label for="ruta_archivo" class="block text-gray-700 font-medium">Enlace del Recurso</label>
                <input type="text" name="ruta_archivo" id="ruta_archivoRecurso" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese el enlace del recurso" required>
            </div>

            <!-- Botones de acción -->
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" onclick="closeModalEdicionRecurso()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Actualizar</button>
            </div>
        </form>
    </div>
</div>

















{{-- MODAL PARA NOTAS --}}
<div class="modal hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-50" id="crearNotaModal">
    <div class="bg-white w-3/4 mx-auto mt-20 rounded shadow p-6">
        <h2 class="text-2xl font-semibold mb-4">Crear Nota</h2>
        <form action="{{route('docentesNotas.store')}}" id="crearNotaForm" method="POST">
            @foreach($estudiantes as $estudiante)
            <input type="hidden" name="acdo_id[]" value="{{ $estudiante->acdo_id }}"> <!-- ID del curso -->
        @endforeach
        

            <!-- Título -->
            <div class="mb-4">
                <label for="titulo" class="block font-medium text-gray-700">Título de la Nota</label>
                <input type="text" id="titulo" name="comentarios" class="w-full border rounded px-4 py-2" required>
            </div>

            <!-- Lista de estudiantes -->
            <div class="mb-4">
                <h3 class="font-medium text-gray-700 bold">Seleccionar Estudiantes</h3>
                <!-- Checkbox para seleccionar todos -->
                <label class="flex items-center bold">
                    <input type="checkbox" id="select_all" class="mr-2">
                    Seleccionar Todos
                </label>
            
                <div class="mt-2 grid grid-cols-2 gap-4">
                    @foreach($estudiantes as $estudiante)
                        <label class="flex items-center">
                            <input type="checkbox" name="alu_dnis[]" value="{{ $estudiante->alu_dni }}" class="mr-2 student-checkbox">
                            {{ $estudiante->alu_nombres }} {{ $estudiante->alu_apellidos }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Botón de Crear -->
            <div class="text-right">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Crear Nota
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PARA CALIFICAR ESTUDIANTES --}}
<!-- Modal para calificar estudiantes -->
<div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="calificarModal">
    <div class="bg-black opacity-50 absolute inset-0"></div>
    <div class="bg-white rounded-lg shadow-lg w-96 p-6 z-10">
        <div class="flex justify-between items-center">
            <button type="button" class="text-gray-500" onclick="closeModal()">&times;</button>
        </div>

        <!-- Mostrar el comentario aquí -->
        <h3 class="text-lg font-bold mb-4" id="modalComentarios">Comentario de la calificación</h3>

        <!-- Aquí puedes agregar la lista de estudiantes y campos para calificar -->
        <form action="{{ route('guardar.calificaciones') }}" method="POST">
            @csrf
            <input type="hidden" name="id_curso" id="id_curso" value="{{ $curso->acu_id }}">

            <div class="mt-4">
                <div class="space-y-4">
                    @foreach($estudiantes as $estudiante)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div class="flex items-center space-x-3">
                                <span class="font-medium text-gray-800">{{ $estudiante->alu_apellidos }}, {{ $estudiante->alu_nombres }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="number" 
                                       class="px-3 py-2 border border-gray-300 rounded-md w-20 text-center"
                                       id="nota_{{ $estudiante->alu_dni }}" 
                                       name="notas[{{ $estudiante->alu_dni }}]" 
                                       min="0" 
                                       max="20" 
                                       step="0.01" 
                                       placeholder="0.00">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600" onclick="closeModal()">Cerrar</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Guardar Calificaciones</button>
            </div>
        </form>
    </div>
</div>




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





 {{-- AQUI INICIA LA VISTA CON CADA FORM --}}
 {{-- AQUI INICIA LA VISTA CON CADA FORM --}}
 {{-- AQUI INICIA LA VISTA CON CADA FORM --}}
 {{-- AQUI INICIA LA VISTA CON CADA FORM --}}
 {{-- AQUI INICIA LA VISTA CON CADA FORM --}}
 {{-- AQUI INICIA LA VISTA CON CADA FORM --}}
 {{-- AQUI INICIA LA VISTA CON CADA FORM --}}

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md drop-shadow-2xl dark:bg-gray-800">
{{-- anuncio --}}
{{-- anuncio --}}
{{-- anuncio --}}
{{-- anuncio --}}
{{-- anuncio --}}
{{-- anuncio --}}
{{-- anuncio --}}

    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white mb-4">Mi curso: {{$curso->acu_nombre}}</h2>
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Anuncios</h3>
        <button onclick="openModal1({{ $curso->acu_id }})" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Registrar Anuncio</button>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="p-4 text-left">Título</th>
                        <th class="p-4 text-left">Descripción</th>

                        <th class="p-4 text-left">Fecha</th>
                        <th class="p-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($curso->anuncios as $anuncio)
                        @if ($anuncio->estado == 'A') <!-- Solo mostramos anuncios activos -->
                            <tr>
                                <td class="p-4">{{ $anuncio->titulo }}</td>
                                <td class="p-4">{{ $anuncio->descripcion }}</td>

                                <td class="p-4">{{ $anuncio->fecha_publicacion}}</td>
                                <td class="p-4">
                                   <button onclick="openEditModal({{ $anuncio->id_anuncio }})" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Editar Anuncio</button>
                                    {{-- <button  class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Eliminar</button> --}}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}
{{-- recursoAcademico --}}


    <!-- Sección de Recursos Académicos -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Recursos Académicos</h3>
        <!-- Formulario para subir un archivo -->
        <form action="{{route('docentesRecursos.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" id="titulo" name="titulo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
        
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
        
            <div class="mb-4">
                <label for="ruta_archivo" class="block text-sm font-medium text-gray-700">Enlace del Recurso</label>
                <input type="text" id="ruta_archivo" name="ruta_archivo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ingresa el enlace de Google Drive u otro servicio" required>
                <small class="text-gray-500">Ingresa un enlace válido (por ejemplo, un enlace de Google Drive, Dropbox, etc.).</small>
            </div>
            
        
            <input type="hidden" name="id_curso" id="id_curso" value="{{ $curso->acu_id }}">
        
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Subir Archivos</button>
        </form>
        

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
                                <!-- Ícono de enlace, representando el recurso -->
                                <i class="fas fa-link text-blue-500 text-xl"></i>
                            </td>
                            <td class="p-4">{{ $recurso->titulo }}</td>
                            <td class="p-4">{{ $recurso->descripcion }}</td>
                            <td class="p-4">{{ $recurso->fecha_subida }}</td>
                            <td class="p-4 flex space-x-2">
                                <!-- Copiar enlace -->
                                <button onclick="copyToClipboard('{{ $recurso->ruta_archivo }}')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                    <i class="fas fa-link"></i> Copiar Enlace
                                </button>
                                <button 
                                onclick="openModalEdicionRecurso('{{ $recurso->id }}', '{{ $recurso->titulo }}', '{{ $recurso->descripcion }}', '{{ $recurso->ruta_archivo }}')"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                            >
                                <i class="fas fa-edit"></i> Editar
                            </button>
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
        
        <script>
            // Función para copiar el enlace al portapapeles
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    alert("Enlace copiado al portapapeles!");
                }).catch(function(err) {
                    console.error("Error al copiar el enlace: ", err);
                });
            }

            
            
// Función para abrir el modal de edición y cargar los datos del recurso
        function openModalEdicionRecurso(id, titulo, descripcion, ruta_archivo) {
            console.log("hola");

            const url2 = "{{ route('docentesRecursos.update', ':id') }}".replace(':id', id);
            document.getElementById('editRecursoForm').action = url2;
            document.getElementById('id_recurso').value = id;
            document.getElementById('tituloRecurso').value = titulo;
            document.getElementById('descripcionRecurso').value = descripcion;
            document.getElementById('ruta_archivoRecurso').value = ruta_archivo;

            document.getElementById('modalEditarRecurso').classList.remove('hidden');
        }

        // Función para cerrar el modal de edición
        function closeModalEdicionRecurso() {
            document.getElementById('modalEditarRecurso').classList.add('hidden');
        }

        </script>    
            
    </div>

   






    <!-- Sección de Notas (aún no implementada) -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Notas</h3>
        

        <button id="abrirModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Crear Nota
        </button>
        
        <div class="container mx-auto mt-6">
            <h2 class="text-2xl font-semibold mb-4">Listado de Notas</h2>
            <div class="bg-white shadow rounded p-4">
                @foreach($notas as $nota)
    <div class="mb-4">
        <h3 class="text-lg font-bold">{{ $nota->comentarios }}</h3>
        <p class="text-sm text-gray-600">Fecha: {{ $nota->fecha }}</p>

        <!-- Botón que al hacer click carga los estudiantes de ese comentario -->
        <button type="button" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-blue-600" 
                onclick="showEstudiantes('{{ $nota->comentarios }}')">
            Calificar Estudiantes
        </button>

        <!-- Detalles de estudiantes debajo del comentario -->
        <div class="mt-4" id="estudiantes_{{ $nota->comentarios }}"style="display: none;">
            @foreach($notes as $filteredNote)
                @if($filteredNote->comentarios == $nota->comentarios)
                    <form action="{{ route('guardar.calificaciones') }}" method="POST">
                        @csrf
                        <input type="hidden" name="alu_dni" value="{{ $filteredNote->alu_dni }}">
                        <input type="hidden" name="comentarios" value="{{ $filteredNote->comentarios }}">
                        
                        <div class="flex items-center justify-between border-b pb-3">
                            <div class="flex items-center space-x-3">
                                <span class="font-medium text-gray-800">
                                    {{ $filteredNote->apellidos }}  {{ $filteredNote->nombres }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="text" 
                                class="px-3 py-2 border border-gray-300 rounded-md w-20 text-center"
                                id="nota_{{ $filteredNote->alu_dni }}" 
                                name="nota" 
                                placeholder="AD-A-B-C"
                                value="{{ $filteredNote->nota ?? '' }}">
                          <!-- Muestra la nota existente si hay alguna -->
                            </div>
                            <div class="flex items-center space-x-3">
                                <button type="submit" 
                                        class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Guardar Nota
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            @endforeach
        </div>
    </div>
@endforeach

            </div>
        </div>
        
 




    </div>


    <div>
        <button 
            onclick="toggleFormularioxc()" 
            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded mb-4">
            Registrar Promedio
        </button>
    
        <div id="formulario-promedios" class="hidden">
            <h2>Registrar promedio</h2>
    
            <form action="{{route('storePromedios')}}" method="POST">
                @csrf
                <input type="hidden" name="acdo_id" value="{{ $estudiante->acdo_id }}">
                <input type="hidden" name="cursoid" value="{{ $curso->acu_id }}">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Estudiante</th>
                            <th class="border border-gray-300 px-4 py-2">Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $estudiante)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $estudiante->alu_nombres }} {{ $estudiante->alu_apellidos }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="text" name="notas[{{ $estudiante->alu_dni }}]" class="w-full border-gray-300 rounded" placeholder="Nota">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                        Registrar Promedios
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function toggleFormularioxc() {
            const formulario = document.getElementById('formulario-promedios');
            formulario.classList.toggle('hidden');
        }
    </script>
    




    <div>
        <div class="mb-4">
            @foreach($promedios2 as $bim_sigla => $detalles)
                <button 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-2"
                    onclick="mostrarBimestre('{{ $bim_sigla }}')">
                    {{ $detalles[0]->bim_descripcion }} ({{ $bim_sigla }})
                </button>
            @endforeach
        </div>
    
        <!-- Tablas dinámicas por bimestre -->
        @foreach($promedios2 as $bim_sigla => $detalles)
        <div id="tabla-{{ $bim_sigla }}" class="bimestre-tabla hidden">
            <h3 class="text-xl font-semibold mb-2">Bimestre: {{ $detalles[0]->bim_descripcion }} ({{ $bim_sigla }})</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">Estudiante</th>
                        <th class="border border-gray-300 px-4 py-2">Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detalles as $promedio)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $promedio->alu_nombres }} {{ $promedio->alu_apellidos }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $promedio->nota }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>

    <script>
       function mostrarBimestre(bimSigla) {
    // Obtener la tabla correspondiente
    const tabla = document.getElementById('tabla-' + bimSigla);

    // Verificar si la tabla está visible
    if (tabla.classList.contains('hidden')) {
        // Ocultar todas las tablas
        document.querySelectorAll('.bimestre-tabla').forEach(tabla => {
            tabla.classList.add('hidden');
        });

        // Mostrar la tabla correspondiente
        tabla.classList.remove('hidden');
    } else {
        // Ocultar la tabla si ya está visible
        tabla.classList.add('hidden');
    }
}
    </script>
    
    

    <!-- Sección de Asistencia (aún no implementada) -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Asistencia</h3>


     
        <div class="max-w-4xl mx-auto mt-10">
            <h1 class="text-2xl font-bold text-center mb-6">Registrar Asistencia</h1>
        
            <!-- Formulario -->
            <form action="{{ route('guardar.asistencias') }}" method="POST">
                @csrf
                <!-- Título del formulario -->
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Registrar Asistencia</h2>
            
                <!-- Input para la fecha -->
                <div class="mb-4">
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
             
                <!-- Recorriendo estudiantes -->
                <div class="space-y-4">
                    @foreach($estudiantes as $estudiante)
                        <div class="flex justify-between items-center p-4 bg-gray-50 border border-gray-200 rounded-md">
                            <div class="flex items-center space-x-3">
                                <span class="font-medium text-gray-800">{{ $estudiante->alu_apellidos }}, {{ $estudiante->alu_nombres }}</span>
                            </div>
                            <div class="flex space-x-3">
                                <!-- Input oculto para el alu_dni -->
                                <input type="hidden" name="asistencias[{{ $estudiante->alu_dni }}][alu_dni]" value="{{ $estudiante->alu_dni }}">
                                <!-- Input oculto para el acdo_id -->
                                <input type="hidden" name="asistencias[{{ $estudiante->alu_dni }}][acdo_id]" value="{{ $acdo_id_value }}">
                                <!-- Radio buttons para asistencia -->
                                <div class="flex items-center space-x-2">
                                    <label for="asistencia_{{ $estudiante->alu_dni }}" class="text-sm font-medium text-gray-700">Asistencia:</label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="asistencias[{{ $estudiante->alu_dni }}][asistencia]" value="F" class="form-radio text-green-500">
                                        <span class="ml-2">F</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="asistencias[{{ $estudiante->alu_dni }}][asistencia]" value="P" class="form-radio text-red-500">
                                        <span class="ml-2">P</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            
                <!-- Botón de enviar -->
                <div class="mt-6 flex justify-center">
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Guardar Asistencia
                    </button>
                </div>
            </form>
        </div>


        <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-md">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Reporte de Asistencias</h2>
        
            @foreach($asistencias as $fecha => $asistenciasPorFecha)
            <div class="mb-6">
                <!-- Mostrar la fecha -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($fecha)->format('d-m-Y') }}
                    </span>
                    <button class="text-indigo-600 hover:text-indigo-800 font-medium" onclick="toggleDetalle('{{ $fecha }}')">
                        Ver Detalle
                    </button>
                </div>
        
                <!-- Contenedor para los detalles -->
                <div id="detalle_{{ $fecha }}" class="hidden">
                    <table class="min-w-full bg-gray-50 border border-gray-200 rounded-md">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Estudiante</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Asistencia</th>
                                <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistenciasPorFecha as $asistencia)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    {{ $asistencia->estudiante->alu_apellidos }}, {{ $asistencia->estudiante->alu_nombres }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    @if($asistencia->asistencia == 'F')
                                        <span class="text-red-500">Falta</span>
                                    @else
                                        <span class="text-green-500">Presente</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button class="text-blue-600 hover:text-blue-800 font-medium"
                                            onclick="toggleEdit('{{ $fecha }}', '{{ $asistencia->alu_dni }}')">
                                        Editar
                                    </button>
                                </td>
                            </tr>
        
                            <!-- Formulario para editar asistencia -->
                            <tr id="edit_form_{{ $fecha }}_{{ $asistencia->alu_dni }}" class="hidden">
                                <td colspan="3" class="px-4 py-2">
                                    <form action="{{ route('editar.asistencia') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="fecha" value="{{ $fecha }}">
                                        <input type="hidden" name="alu_dni" value="{{ $asistencia->alu_dni }}">
                                        <input type="hidden" name="cursoid" value="{{ $curso->acu_id }}">
                                        
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center space-x-2">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="asistencia" value="P" 
                                                           class="form-radio text-green-500"
                                                           {{ $asistencia->asistencia == 'P' ? 'checked' : '' }}>
                                                    <span class="ml-2">Presente</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="asistencia" value="F" 
                                                           class="form-radio text-red-500"
                                                           {{ $asistencia->asistencia == 'F' ? 'checked' : '' }}>
                                                    <span class="ml-2">Falta</span>
                                                </label>
                                            </div>
                                            <button type="submit"
                                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                Guardar
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        
        <script>
            function toggleDetalle(fecha) {
                const detalle = document.getElementById('detalle_' + fecha);
                detalle.classList.toggle('hidden');
            }
        
            function toggleEdit(fecha, alu_dni) {
                const editForm = document.getElementById(`edit_form_${fecha}_${alu_dni}`);
                editForm.classList.toggle('hidden');
            }
        </script>
        

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
    // Función para abrir el modal
    function openModal1(cursoId) {
        document.getElementById('id_curso').value = cursoId; // Establece el id_curso en el input hidden
        document.getElementById('modalRegistrarAnuncio').classList.remove('hidden'); // Muestra el modal
        document.getElementById('titulo').value = ''; // Limpia los campos del modal
        document.getElementById('descripcion').value = '';
    }

    // Función para cerrar el modal
    function closeModal1() {
        document.getElementById('modalRegistrarAnuncio').classList.add('hidden'); // Oculta el modal
    }
</script>

<script>
    // Obtener los elementos del DOM
    const modal = document.getElementById('crearNotaModal');
    const abrirModalBtn = document.getElementById('abrirModal');
    const cerrarModalBtns = modal.querySelectorAll('.cerrarModal'); // Asumimos que tienes botones para cerrar

    // Abrir el modal
    abrirModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden'); // Mostrar el modal
    });

    // Cerrar el modal
    cerrarModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.add('hidden'); // Ocultar el modal
        });
    });

    // Cerrar al hacer clic fuera del modal
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>



<!-- JavaScript para seleccionar/deseleccionar todos -->
<script>
    // Obtener el checkbox de "Seleccionar Todos"
    const selectAllCheckbox = document.getElementById('select_all');

    // Obtener todos los checkbox de estudiantes
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');

    // Escuchar el cambio en el checkbox de "Seleccionar Todos"
    selectAllCheckbox.addEventListener('change', function() {
        // Establecer el estado de todos los checkbox de estudiantes según el estado de "Seleccionar Todos"
        studentCheckboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // Opcional: si se desmarcan todos los checkboxes, desmarcar "Seleccionar Todos"
    studentCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (document.querySelectorAll('.student-checkbox:checked').length === studentCheckboxes.length) {
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.checked = false;
            }
        });
    });
</script>

<script>
    // Función para abrir el modal
    function openModal() {
      document.getElementById('calificarModal').classList.remove('hidden'); // Muestra el modal
    }
  
    // Función para cerrar el modal
    function closeModal() {
      document.getElementById('calificarModal').classList.add('hidden'); // Oculta el modal
    }
  </script>


<script>// Función que abre el modal y muestra el comentario
    function openModal(comentarios) {
        // Mostrar el modal
        document.getElementById('calificarModal').classList.remove('hidden');
        
        // Mostrar el comentario en el modal
        document.getElementById('modalComentarios').innerText = comentarios;
    }
    
    // Función para cerrar el modal
    function closeModal() {
        document.getElementById('calificarModal').classList.add('hidden');
    }
    </script>

<script>
    function verNota(alu_dni) {
    // Puedes hacer una solicitud AJAX o mostrar un modal con la información
    alert("Ver nota para el estudiante con DNI: " + alu_dni);
}


function showEstudiantes(comentarios) {
    // Obtener el contenedor de los estudiantes para ese comentario
    var detalleEstudiantes = document.getElementById('estudiantes_' + comentarios);
    
    // Mostrar u ocultar los detalles de los estudiantes
    if (detalleEstudiantes.style.display === "none" || detalleEstudiantes.style.display === "") {
        detalleEstudiantes.style.display = "block"; // Mostrar el contenedor
    } else {
        detalleEstudiantes.style.display = "none"; // Ocultar el contenedor
    }
}

</script>


<script>
    document.getElementById('showFormButton').addEventListener('click', function () {
        document.getElementById('createForm').classList.remove('hidden');
        this.classList.add('hidden');
    });
</script>
<script>
    // Establecer la fecha actual en el campo de fecha
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
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
<script>
    // Función para abrir el modal de edición y cargar datos del anuncio
    function openEditModal(anuncioId) {
    // Imprimir el anuncioId y la URL generada
    console.log('Anuncio ID:', anuncioId);
    const url = "{{ route('docentesAnuncios.edit', ':id') }}".replace(':id', anuncioId);
    console.log('URL generada:', url);  // Verifica la URL generada
    const url2 = "{{ route('docentesAnuncios.update', ':id') }}".replace(':id', anuncioId);
    document.getElementById('editAnuncioForm').action = url2;
    // Realizar una solicitud AJAX para obtener los datos del anuncio
    fetch(url)  // Usar la URL generada
        .then(response => {
            // Verificar si la respuesta es exitosa
            if (!response.ok) {
                throw new Error('Error al obtener los datos: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);  // Verifica los datos recibidos

            // Rellenar los campos del formulario con los datos del anuncio
            document.getElementById('id_anuncioo').value = data.id_anuncio;
            document.getElementById('tituloAnuncioo').value = data.titulo;
            document.getElementById('descripcionn').value = data.descripcion;

            // Mostrar el modal
            document.getElementById('modalEditarAnuncio').classList.remove('hidden');
        })
        .catch(error => console.error('Error al cargar los datos:', error));
}
function closeModalAnuncioEditar() {
        document.getElementById('modalEditarAnuncio').classList.add('hidden');
    }
</script>


@endif
@endsection
