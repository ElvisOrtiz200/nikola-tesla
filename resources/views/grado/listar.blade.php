@extends('grado.index')

@section('subcontent')


<div class="container mx-auto p-4">
    <div class="container mx-auto p-4">
        <!-- Búsqueda -->
        <div class="mb-4">
            <form action="{{ route('grado.listar') }}" method="GET">
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Buscar grado..." value="{{ request('search') }}" class="w-full px-4 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Buscar</button>
                </div>
            </form>
        </div>
    
        <!-- Tabla de grados -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Nombre del Grado</th>
                        <th class="px-4 py-2 text-left">Nivel</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grados as $grado)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $grado->id_grado }}</td>
                            <td class="px-4 py-2">{{ $grado->nombre }}</td>
                            <td class="px-4 py-2">{{ $grado->nivel->nombre ?? 'No asignado' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-500">No se encontraron grados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        <!-- Paginación -->
        <div class="mt-4">
            {{ $grados->links() }}
        </div>
    </div>

@endsection