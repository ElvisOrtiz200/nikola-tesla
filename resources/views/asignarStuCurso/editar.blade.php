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
                <th class="px-4 py-2 border-b text-left">Acciones</th>
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
                    
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('estudiante-curso.editando', ['alu_dni' => $estudiante->alu_dni]) }}" 
                          class="relative h-10 max-h-[40px] w-10 max-w-[40px] 
                                 flex items-center justify-center 
                                 rounded-lg text-center font-sans text-xs font-medium 
                                 uppercase text-slate-900 
                                 bg-white shadow-md transition-all 
                                 hover:bg-slate-200 active:bg-slate-300 
                                 disabled:pointer-events-none disabled:opacity-50">
                           <span>
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-4 h-4">
                                   <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z"></path>
                               </svg>
                           </span>
                       </a>
                      </td>
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
