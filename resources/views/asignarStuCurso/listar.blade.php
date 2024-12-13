@extends('asignarStuCurso.index')

@section('subcontent')

<div class="container mx-auto my-4">
    <!-- Search bar -->


    <div class="mb-4">
        <form action="{{ route('estudiante-curso.listar') }}" method="GET" class="flex space-x-2">
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}" 
                placeholder="Buscar por DNI, nombre o apellido" 
                class="border rounded px-4 py-2 w-1/2"
            >
            <button 
                type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded">
                Buscar
            </button>
        </form>
    </div>
    
    <!-- Tabla de estudiantes con grado y nivel -->
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 border-b text-left">DNI Estudiante</th>
                <th class="px-4 py-2 border-b text-left">Nombre Estudiante</th>
                <th class="px-4 py-2 border-b text-left">Apellido Estudiante</th>
                <th class="px-4 py-2 border-b text-left">Grado</th>
                <th class="px-4 py-2 border-b text-left">Nivel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantesGrados as $estudiante)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $estudiante->alu_dni }}</td>
                    <td class="px-4 py-2 border-b">{{ $estudiante->alu_nombres }}</td>
                    <td class="px-4 py-2 border-b">{{ $estudiante->alu_apellidos }}</td>
                    <td class="px-4 py-2 border-b">{{ $estudiante->grado_nombre }}</td>
                    <td class="px-4 py-2 border-b">{{ $estudiante->nivel_nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Enlaces de Paginación -->
    <div class="mt-4">
        {{ $estudiantesGrados->links() }}
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
