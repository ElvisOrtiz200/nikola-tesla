@extends('usuario.index')



@section('subcontent')
<form action="{{route('usuario.show')}}" method="GET" id="searchForm">
  <div class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-gray-300 focus-within:!ring-2 ring-inset focus-within:!ring-teal-500 rounded-md">
      <svg class="mr-2 h-5 w-5 stroke-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
      </svg>
      <input
          class="block w-full appearance-none bg-transparent text-base text-gray-700 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6"
          placeholder="Buscar por nombre de usuario o correo"
          name="search"
          id="searchInput"
          aria-label="Search users"
          value="{{ request()->query('search') }}"
          style="caret-color: rgb(107, 114, 128)"
      />
  </div>
</form>

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
@if (request()->cookie('error'))
<div id="alert" class="fixed top-4 right-4 z-50 flex w-full max-w-sm overflow-hidden bg-red-500 rounded-lg shadow-md dark:bg-red-700" style="display: flex;">
    <div class="flex items-center justify-center w-12 bg-red-600">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
        </svg>
    </div>
    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-semibold text-white">¡Error!</span>
            <p class="text-sm text-white">{{ request()->cookie('error') }}</p>
        </div>
    </div>
</div>
@endif
<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-white border-b">
              <tr>
              
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Nombre de usuario
                </th>
               
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Estado usuario
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Correo
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Rol
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Editar
                </th>
              </tr>
            </thead>
            <tbody>
              @if($usuarios->isEmpty())
            <tr>
                <td colspan="3" class="text-center text-gray-500">No hay coincidencias</td>
            </tr>
        @else
              @foreach ($usuarios as $usuario)
              <tr class="bg-white border-b">
              
                
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $usuario->usu_login }}
                </td>
               
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $usuario->usu_estado }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $usuario->correo }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $usuario->rol->nombre_rol }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{-- {{ route('usuario.editando', $usuario->idrol) }} --}}
                  <a href="{{ route('usuario.editando', $usuario->usu_id) }}" 
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
              @endif
            </tbody>
          </table>
          <div class="mt-4">
            {{ $usuarios->links() }} <!-- Esto genera los enlaces de paginación -->
        </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function deleteCookie(name) {
    // Eliminar la cookie 'success' con los parámetros correctos
    document.cookie = name + '=; Max-Age=0; path=/; domain=' + window.location.hostname + ';';
}

// Función para ocultar el mensaje y eliminar la cookie
setTimeout(() => {
    const alert = document.getElementById('alert');
    if (alert) {
        alert.style.display = 'none';
        deleteCookie('success'); // Borrar cookie de éxito
        deleteCookie('error');   // Borrar cookie de error
    }
}, 3000);
</script>





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
