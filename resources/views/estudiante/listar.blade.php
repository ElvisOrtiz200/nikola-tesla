 
@extends('estudiante.index')


@section('subcontent')<div class="container">
  <h1 class="text-xl font-bold">Lista de Estudiantes</h1>

  <!-- Barra de búsqueda -->
  <form method="GET" action="{{ route('estudiante.lista') }}" class="mt-4 flex justify-between">
      <input 
          type="text" 
          name="search" 
          value="{{ request()->search }}" 
          class="px-4 py-2 w-1/2 text-gray-700 bg-gray-100 border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300"
          placeholder="Buscar por DNI, Apellidos o Nombres..."
      >
      <button 
          type="submit" 
          class="ml-4 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300"
      >
          Buscar
      </button>
  </form>

  <!-- Tabla de Estudiantes -->
  <table class="min-w-full mt-4 table-auto border-collapse">
      <thead>
          <tr>
              <th class="border px-4 py-2">DNI Estudiante</th>
              <th class="border px-4 py-2">Apellidos y Nombres</th>
              <th class="border px-4 py-2">DNI Apoderado</th>
              <th class="border px-4 py-2">Apellidos y Nombres Apoderado</th>
              <th class="border px-4 py-2">Dirección Estudiante</th>
              <th class="border px-4 py-2">Teléfono Estudiante</th>
          </tr>
      </thead>
      <tbody>
          @foreach($estudiantes as $estudiante)
          <tr>
              <td class="border px-4 py-2">{{ $estudiante->alu_dni }}</td>
              <td class="border px-4 py-2">{{ $estudiante->alu_apellidos }} {{ $estudiante->alu_nombres }}</td>
              <td class="border px-4 py-2">{{ $estudiante->apoderado ? $estudiante->apoderado->apo_dni : 'N/A' }}</td>
              <td class="border px-4 py-2">{{ $estudiante->apoderado ? $estudiante->apoderado->apo_apellidos . ' ' . $estudiante->apoderado->apo_nombres : 'N/A' }}</td>
              <td class="border px-4 py-2">{{ $estudiante->alu_direccion }}</td>
              <td class="border px-4 py-2">{{ $estudiante->alu_telefono }}</td>
          </tr>
          @endforeach
      </tbody>
  </table>

  <!-- Paginación -->
  <div class="mt-4">
      {{ $estudiantes->links() }}
  </div>
</div>
@endsection