@extends('usuario.index')


@section('subcontent')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Listado de Usuarios</h1>
    
    {{-- Buscador --}}
    <form method="GET" action="{{ route('usuario.listar') }}" class="mb-4">
        <input type="text" name="search" value="{{ $search }}" 
               class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" 
               placeholder="Buscar usuario...">
    </form>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Usuario</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Correo</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Rol</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Tipo</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($usuarios as $usuario)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $usuario->usu_login }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $usuario->correo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $usuario->rol ? $usuario->rol->nombre_rol : 'Sin rol' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        @if ($usuario->per_id)
                            Personal
                        @elseif ($usuario->alu_dni)
                            Estudiante
                        @else
                            No asignado
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $usuario->usu_estado == 'A' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $usuario->usu_estado == 'A' ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay usuarios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $usuarios->appends(['search' => $search])->links('pagination::tailwind') }}
    </div>
</div>


<script>
    // Filtrar tabla al escribir en el buscador
    document.getElementById('search').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#userTable tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
</script>

@endsection
