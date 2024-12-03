@extends('curso.index')

@section('subcontent') 
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Lista de Cursos</h1>

    <!-- Barra de búsqueda -->
    <form action="{{ route('curso.listar') }}" method="GET" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Buscar por curso -->
            <div>
                <label for="searchCurso" class="block text-sm font-medium text-gray-700">Curso</label>
                <input
                    type="text"
                    name="searchCurso"
                    id="searchCurso"
                    placeholder="Buscar por nombre del curso"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ request()->query('searchCurso') }}"
                />
            </div>

            <!-- Buscar por grado -->
            <div>
                <label for="searchGrado" class="block text-sm font-medium text-gray-700">Grado</label>
                <input
                    type="text"
                    name="searchGrado"
                    id="searchGrado"
                    placeholder="Buscar por grado"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ request()->query('searchGrado') }}"
                />
            </div>

            <!-- Buscar por nivel -->
            <div>
                <label for="searchNivel" class="block text-sm font-medium text-gray-700">Nivel</label>
                <input
                    type="text"
                    name="searchNivel"
                    id="searchNivel"
                    placeholder="Buscar por nivel"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ request()->query('searchNivel') }}"
                />
            </div>
        </div>
        <div class="mt-4">
            <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Buscar
            </button>
        </div>
    </form>

    <!-- Tabla de cursos -->
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="px-6 py-2 border-b text-left">ID</th>
                <th class="px-6 py-2 border-b text-left">Nombre del Curso</th>
                <th class="px-6 py-2 border-b text-left">Estado</th>
                <th class="px-6 py-2 border-b text-left">Grado</th>
                <th class="px-6 py-2 border-b text-left">Nivel</th>
            </tr>
        </thead>
        <tbody>
            @if ($cursos->isEmpty())
            <tr>
                <td colspan="5" class="text-center text-gray-500 py-4">No se encontraron resultados.</td>
            </tr>
            @else
            @foreach ($cursos as $curso)
            <tr>
                <td class="px-6 py-2 border-b">{{ $curso->acu_id }}</td>
                <td class="px-6 py-2 border-b">{{ $curso->acu_nombre }}</td>
                <td class="px-6 py-2 border-b">{{ $curso->acu_estado === 'A' ? 'Activo' : 'Inactivo' }}</td>
                <td class="px-6 py-2 border-b">{{ $curso->grado->nombre }}</td>
                <td class="px-6 py-2 border-b">{{ $curso->grado->nivel->nombre }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $cursos->links() }}
    </div>
</div>
@endsection