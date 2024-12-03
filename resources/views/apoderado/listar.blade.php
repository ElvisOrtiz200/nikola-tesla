@extends('apoderado.index')

@section('subcontent')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Lista de Apoderados</h2>

    <!-- Search Bar -->
    <form action="{{ route('apoderado.listar') }}" method="GET" class="mb-4">
        <input type="text" name="search" value="{{ request()->search }}" placeholder="Buscar por DNI, Apellidos, Nombres..." class="px-4 py-2 border border-gray-300 rounded-lg w-full sm:w-1/3" />
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">DNI</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Apellidos</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nombres</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Dirección</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Teléfono</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apoderados as $apoderado)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $apoderado->apo_dni }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $apoderado->apo_apellidos }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $apoderado->apo_nombres }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $apoderado->apo_direccion }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $apoderado->apo_telefono }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $apoderados->links() }}
        </div>
    </div>
</div>
@endsection