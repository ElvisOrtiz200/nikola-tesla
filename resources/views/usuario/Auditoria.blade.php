@extends('usuario.index')



@section('subcontent')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Listado de Auditoría</h2>

    <!-- Barra de búsqueda -->
    <form method="GET" action="{{ route('auditorialog.index') }}" class="mb-4">
        <div class="flex items-center">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring focus:ring-blue-300" 
                placeholder="Buscar por entidad, operación o usuario">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-md hover:bg-blue-600">
                Buscar
            </button>
        </div>
    </form>

    <!-- Tabla -->
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left">Usuario</th>
                <th class="border px-4 py-2 text-left">Operación</th>
                <th class="border px-4 py-2 text-left">Fecha</th>
                <th class="border px-4 py-2 text-left">Entidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($auditorias as $auditoria)
                <tr>
                    <td class="border px-4 py-2">{{ $auditoria->usuario }}</td>
                    <td class="border px-4 py-2">
                        @switch($auditoria->operacion)
                            @case('C') Crear @break
                            @case('R') Leer @break
                            @case('U') Actualizar @break
                            @case('D') Eliminar @break
                            @default {{ $auditoria->operacion }}
                        @endswitch
                    </td>
                    <td class="border px-4 py-2">{{ $auditoria->fecha }}</td>
                    <td class="border px-4 py-2">{{ $auditoria->entidad }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No se encontraron registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $auditorias->links('pagination::tailwind') }}
    </div>
</div>
@endsection