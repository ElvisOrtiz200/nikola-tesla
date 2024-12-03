@extends('cursoDocente.index')



@section('subcontent')



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


