@extends('asignarStuCurso.index')

@section('subcontent')

<div class="container mx-auto my-4">
    <!-- Search bar -->

    <form action="{{ route('estudiante-curso.destroy', ['alu_dni' => $estudiante->alu_dni]) }}" method="post" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('DELETE')
        <input type="hidden" name="alu_dni" value="{{ $estudiante->alu_dni }}">
    
        <!-- Mostrar nombres y apellidos -->
        <div class="mb-4">
            <label for="alu_nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
            <input
                type="text"
                id="alu_nombres"
                name="alu_nombres"
                value="{{ $estudiante->alu_nombres }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                readonly
            >
        </div>
        
        <div class="mb-4">
            <label for="alu_apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
            <input
                type="text"
                id="alu_apellidos"
                name="alu_apellidos"
                value="{{ $estudiante->alu_apellidos }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                readonly
            >
        </div>
    
        <!-- Campo editable para la sigla del bimestre -->
      
    
        <!-- Campo para seleccionar grado y nivel -->
        <div class="mb-4" >
            <label for="grado" class="block text-sm font-medium text-gray-700">Grado y Nivel</label>
            <select
                id="grado"
                name="grado"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            >
                @foreach($grados as $grado)
                    <option value="{{ $grado->id_grado }}" {{ $grado->id_grado == $estudiante->id_grado ? 'selected' : '' }}>
                        {{ $grado->grado_nombre }} - {{ $grado->nivel_nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <!-- Botón para guardar -->
        <div class="flex justify-end">
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
            >
                Guardar
            </button>
        </div>
    </form>
    
    
    
    <!-- Tabla de estudiantes con grado y nivel -->
    
    
  
    
    
    
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
