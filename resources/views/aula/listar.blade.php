@extends('aula.index')

@section('subcontent')

<div class="container mx-auto p-4">
    <!-- Búsqueda -->
    <div class="mb-4">
        <form action="{{ route('aula.listar') }}" method="GET">
            <div class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Buscar aula o grado..." value="{{ request('search') }}" class="w-full px-4 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Buscar</button>
            </div>
        </form>
    </div>

    <!-- Tabla de aulas -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Nombre del Aula</th>
                    <th class="px-4 py-2 text-left">Capacidad</th>
                    <th class="px-4 py-2 text-left">Grado</th>
                    <th class="px-4 py-2 text-left">Nivel</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aulas as $aula)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $aula->id_aula }}</td>
                        <td class="px-4 py-2">{{ $aula->nombre }}</td>
                        <td class="px-4 py-2">{{ $aula->capacidad }}</td>
                        <td class="px-4 py-2">{{ $aula->grado->nombre ?? 'No asignado' }}</td>
                        <td class="px-4 py-2">{{ $aula->grado->nivel->nombre ?? 'No asignado' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No se encontraron aulas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $aulas->links() }}
    </div>
</div>
@endsection