@extends('cursoDocente.index')



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

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-6">Carga Docente</h2>

    <!-- Barra de búsqueda -->
    <div class="mb-4">
        <input id="searchInput" type="text" placeholder="Buscar por docente, curso o grado..." 
               class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
    </div>

    <!-- Tabla de registros -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Docente</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Curso</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Grado</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Año</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Estado</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                @foreach ($cargasDocentes as $carga)
                <tr class="border-b">
                    <td class="px-6 py-3">{{ $carga->acdo_id }}</td>
                    <td class="px-6 py-3">
                        {{ $carga->docente->per_apellidos }}, {{ $carga->docente->per_nombres }}
                    </td>
                    <td class="px-6 py-3">{{ $carga->curso->acu_nombre }}</td>
                    <td class="px-6 py-3">{{ $carga->grado->nombre }}</td>
                    <td class="px-6 py-3">{{ $carga->acdo_anio }}</td>
                    <td class="px-6 py-3">{{ $carga->acdo_estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                    <td class="px-6 py-3">
                        {{-- {{ route('curso-docente.edit', $carga->acdo_id) }} --}}
                        <a href="{{ route('cursodocente.eliminando', $carga->acdo_id) }}" 
                           class="text-blue-500 hover:underline">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Filtrar resultados en la tabla
    document.getElementById('searchInput').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dataTable tr');

        rows.forEach(row => {
            const docente = row.children[1].textContent.toLowerCase();
            const curso = row.children[2].textContent.toLowerCase();
            const grado = row.children[3].textContent.toLowerCase();

            if (docente.includes(filter) || curso.includes(filter) || grado.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<script>
    function deleteCookie(name) {
    // Eliminar la cookie 'success' con los parámetros correctos
    document.cookie = name + '=; Max-Age=0; path=/; domain=' + window.location.hostname + ';';
}

// Función para ocultar el mensaje y eliminar la cookie
setTimeout(() => {
    const alert = document.getElementById('alert');
    if (alert) {
        // Ocultar el mensaje
        alert.style.display = 'none';
        
        // Eliminar la cookie 'success' después de ocultar el mensaje
        deleteCookie('success');
    }
}, 2000);
</script>

@endsection


