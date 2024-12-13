@extends('bimestre.index')



@section('subcontent')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-4">Lista de Bimestres</h2>

    <!-- Barra de búsqueda -->
    <form method="GET" action="{{ route('bimestres.listar') }}" class="mb-4">
        <div class="flex items-center">
            <input 
                type="text" 
                name="search" 
                placeholder="Buscar por sigla, descripción o año"
                value="{{ $search }}" 
                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200"
            />
            <button 
                type="submit" 
                class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Buscar
            </button>
        </div>
    </form>

    <!-- Tabla de bimestres -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Sigla</th>
                    <th class="border border-gray-300 px-4 py-2">Descripción</th>
                    <th class="border border-gray-300 px-4 py-2">Año</th>
                    <th class="border border-gray-300 px-4 py-2">Fecha Inicio</th>
                    <th class="border border-gray-300 px-4 py-2">Fecha Fin</th>
                    <th class="border border-gray-300 px-4 py-2">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bimestres as $bimestre)
                <tr class="{{ $bimestre->estadoBIMESTRE ? 'bg-green-100' : '' }}">
                    <td class="border border-gray-300 px-4 py-2">{{ $bimestre->bim_sigla }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $bimestre->bim_descripcion }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $bimestre->anio }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $bimestre->fecha_inicio }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $bimestre->fecha_fin }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <span 
                            class="{{ $bimestre->estadoBIMESTRE ? 'text-green-600 font-bold' : 'text-red-600' }}">
                            {{ $bimestre->estadoBIMESTRE ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No se encontraron resultados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $bimestres->links() }}
    </div>
</div>

@endsection
