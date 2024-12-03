@extends('recursoHumano.index')

@section('subcontent')


<div class="container mx-auto px-4 sm:px-8 max-w-3xl">
    <h1 class="text-2xl font-bold mb-4">Listado de Personal</h1>

    <!-- Barra de búsqueda -->
    <form method="GET" action="{{ route('recursoshh.listar') }}" class="mb-4">
        <input 
            type="text" 
            name="search" 
            value="{{ old('search', $search) }}" 
            placeholder="Buscar por DNI o apellidos..." 
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
        >
    </form>

    <!-- Tabla responsive -->
    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-md border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Cargo</th>
                    <th class="border border-gray-300 px-4 py-2">Apellidos</th>
                    <th class="border border-gray-300 px-4 py-2">Nombres</th>
                    <th class="border border-gray-300 px-4 py-2">DNI</th>
                    <th class="border border-gray-300 px-4 py-2">Teléfono</th>
                    <th class="border border-gray-300 px-4 py-2">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personales as $personal)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $personal->per_cargo }}</td>

                        <td class="border border-gray-300 px-4 py-2">{{ $personal->per_apellidos }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $personal->per_nombres }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $personal->per_dni }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $personal->per_telefono }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $personal->per_estado == 'A' ? 'Activo' : 'Inactivo' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">
                            No se encontraron registros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $personales->links() }}
    </div>
</div>

@endsection