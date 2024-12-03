@extends('docente.index')

@section('subcontent')
<div class="container mx-auto px-4">
    <!-- Título -->
    <h1 class="text-2xl font-semibold text-gray-700 mb-4">Listado de Docentes</h1>

    <!-- Barra de búsqueda -->
    <form method="GET" action="{{ route('docente.listar') }}" class="mb-4">
        <div class="flex items-center">
            <input
                type="text"
                name="search"
                value="{{ request()->query('search') }}"
                placeholder="Buscar por DNI, nombre o especialidad"
                class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none"
            />
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Buscar
            </button>
        </div>
    </form>

    <!-- Tabla -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full bg-white border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border border-gray-300 text-left text-gray-600 font-medium">ID</th>
                    <th class="py-2 px-4 border border-gray-300 text-left text-gray-600 font-medium">DNI</th>
                    <th class="py-2 px-4 border border-gray-300 text-left text-gray-600 font-medium">Nombre</th>
                    <th class="py-2 px-4 border border-gray-300 text-left text-gray-600 font-medium">Especialidad</th>
                    <th class="py-2 px-4 border border-gray-300 text-left text-gray-600 font-medium">Nivel Educativo</th>
                    <th class="py-2 px-4 border border-gray-300 text-left text-gray-600 font-medium">Fecha de Nacimiento</th>
                    <th class="py-2 px-4 border border-gray-300 text-left text-gray-600 font-medium">Estado</th>
     
                </tr>
            </thead>
            <tbody>
                @forelse($docentes as $docente)
                    <tr>
                        <td class="py-2 px-4 border">{{ $docente->doc_id }}</td>
                        <td class="py-2 px-4 border">{{ $docente->recursoshh->per_dni ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border">{{ $docente->recursoshh->per_nombres}} {{$docente->recursoshh->per_apellidos}}</td>
                        <td class="py-2 px-4 border">{{ $docente->doc_especialidad }}</td>
                        <td class="py-2 px-4 border">{{ $docente->doc_nivel_educativo }}</td>
                        <td class="py-2 px-4 border">{{ $docente->doc_fecha_nac }}</td>
                        <td class="py-2 px-4 border">{{ $docente->doc_estado === 'A' ? 'Activo' : 'Inactivo' }}</td>
                       
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 text-center text-gray-500">No se encontraron resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $docentes->links() }}
    </div>
</div>



@endsection