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

    <!-- Tabla de Recursos -->
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

    <!-- Script para copiar el enlace -->
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert("Enlace copiado al portapapeles!");
            }).catch(function(err) {
                console.error("Error al copiar el enlace: ", err);
            });
        }
    </script> 

    <!-- Sección de Notas -->
    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Notas</h3>
        <div>
            @forelse($notas as $nota)
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600 dark:text-gray-300">{{ $nota->comentarios }}</span>
                    <span class="px-3 py-1 rounded-full text-white font-medium
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
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-semibold text-gray-700">{{ \Carbon\Carbon::parse($fecha)->format('d-m-Y') }}</span>
                    <button class="text-indigo-600 hover:text-indigo-800 font-medium" onclick="toggleDetalle('{{ $fecha }}')">Ver Detalle</button>
                </div>
                <div id="detalle_{{ $fecha }}" class="hidden">
                    <table class="min-w-full bg-gray-50 border border-gray-200 rounded-md">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Asistencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistenciasPorFecha as $asistencia)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-sm">
                                    @if($asistencia->asistencia == 'P')
                                        <span class="text-green-500">Asistencia</span>
                                    @elseif($asistencia->asistencia == 'F')
                                        <span class="text-red-500">Falta</span>
                                    @else
                                        <span class="text-gray-500">Sin Registro</span>
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

</section>

<script>
    // Función para mostrar/ocultar el detalle de las asistencias
    function toggleDetalle(fecha) {
        const detalle = document.getElementById('detalle_' + fecha);
        detalle.classList.toggle('hidden');
    }
</script>

@endsection
