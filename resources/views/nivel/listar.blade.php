
@extends('nivel.index')

@section('subcontent')

<div class="container mx-auto px-4 sm:px-8 max-w-3xl">
    <div class="py-8">
        <div class="flex flex-col justify-between sm:flex-row sm:items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight text-gray-700 dark:text-gray-200">Lista de Niveles</h2>
            <!-- Searchbar -->
            <form method="GET" action="{{ route('nivel.listar') }}" class="mt-4 sm:mt-0">
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar niveles..."
                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:outline-none sm:w-64">
            </form>
        </div>

        <!-- Tabla -->
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 bg-white dark:bg-gray-800 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                            ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                            Nombre</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($niveles as $nivel)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ $nivel->id_nivel }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                {{ $nivel->nombre }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                No se encontraron niveles.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $niveles->appends(['search' => $search])->links('pagination::tailwind') }}
        </div>
    </div>
</div>



@endsection