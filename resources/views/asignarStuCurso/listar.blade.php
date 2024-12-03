@extends('asignarStuCurso.index')

@section('subcontent')

<div class="container mx-auto my-4">
    <!-- Search bar -->
    <div class="mb-4 flex justify-between items-center">
        <input type="text" id="search" class="p-2 border rounded" placeholder="Buscar...">
    </div>

    <!-- Tabla de estudiantes cursos -->
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 border-b text-left">DNI Estudiante</th>
                <th class="px-4 py-2 border-b text-left">Nombre Estudiante</th>
                <th class="px-4 py-2 border-b text-left">Curso</th>
                <th class="px-4 py-2 border-b text-left">Docente</th>
                <th class="px-4 py-2 border-b text-left">Bimestre</th>
                <th class="px-4 py-2 border-b text-left">Año</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Aquí se llenarán los datos de la tabla -->
            @foreach($estudiantesCursos as $estudianteCurso)
            <tr>
                <td class="px-4 py-2 border-b">{{ $estudianteCurso->alu_dni }}</td>
                <td class="px-4 py-2 border-b">{{ $estudianteCurso->alu_nombres }} {{ $estudianteCurso->alu_apellidos }}</td>
                <td class="px-4 py-2 border-b">{{ $estudianteCurso->acu_nombre }}</td>
                <td class="px-4 py-2 border-b">{{ $estudianteCurso->docente_nombre }}</td>
                <td class="px-4 py-2 border-b">{{ $estudianteCurso->bim_sigla }}</td>
                <td class="px-4 py-2 border-b">{{ $estudianteCurso->acdo_anio }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Enlaces de Paginación -->
    <div class="mt-4">
        {{ $estudiantesCursos->links() }}
    </div>
</div>

<script>
    // Filtro de búsqueda en la tabla
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#table-body tr');
        rows.forEach(row => {
            let cells = row.querySelectorAll('td');
            let match = Array.from(cells).some(cell => {
                return cell.textContent.toLowerCase().includes(filter);
            });
            row.style.display = match ? '' : 'none';
        });
    });
</script>

@endsection
