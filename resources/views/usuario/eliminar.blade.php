@extends('usuario.index')


@section('subcontent')
<form action="{{ route('usuario.show') }}" method="GET" id="searchForm">
  <div class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-gray-300 focus-within:!ring-2 ring-inset focus-within:!ring-teal-500 rounded-md">
      <svg class="mr-2 h-5 w-5 stroke-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
      </svg>
      <input
          class="block w-full appearance-none bg-transparent text-base text-gray-700 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6"
          placeholder="Buscar por nombre de usuario"
          name="search"
          oninput="this.form.submit()"
          aria-label="Search components"
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
<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-white border-b">
              <tr>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  #
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  # Personal
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Nombre de usuario
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Contraseña
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Estado usuario
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Correo
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Eliminar
                </th>
               
              </tr>
            </thead>
            <tbody>
              @if($usuario->isEmpty())
            <tr>
                <td colspan="3" class="text-center text-gray-500">No hay coincidencias</td>
            </tr>
        @else
        @foreach ($usuario as $user)
        <tr class="bg-white border-b">
          <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            {{ $user->usu_id }}
          </td>
          <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            {{ $user->per_id }}
          </td>
          <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            {{ $user->usu_login }}
          </td>
          <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
           ######
          </td>
          <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            {{ $user->usu_estado }}
          </td>
          <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            {{ $user->correo }}
          </td>
          <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            {{-- {{ route('usuario.editando', $usuario->idrol) }} --}}
            <a href="{{ route('usuario.eliminando', $user->usu_id) }}" 
              class="relative h-10 max-h-[40px] w-10 max-w-[40px] 
                           flex items-center justify-center 
                           rounded-lg text-center font-sans text-xs font-medium 
                           uppercase text-slate-900 
                           bg-white shadow-md transition-all 
                           hover:bg-slate-200 active:bg-slate-300 
                           disabled:pointer-events-none disabled:opacity-50">
                     <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="currentColor" aria-hidden="true" class="w-4 h-4">
                            <path d="M 21 2 C 19.354545 2 18 3.3545455 18 5 L 18 7 L 10.154297 7 A 1.0001 1.0001 0 0 0 9.984375 6.9863281 A 1.0001 1.0001 0 0 0 9.8398438 7 L 8 7 A 1.0001 1.0001 0 1 0 8 9 L 9 9 L 9 45 C 9 46.645455 10.354545 48 12 48 L 38 48 C 39.645455 48 41 46.645455 41 45 L 41 9 L 42 9 A 1.0001 1.0001 0 1 0 42 7 L 40.167969 7 A 1.0001 1.0001 0 0 0 39.841797 7 L 32 7 L 32 5 C 32 3.3545455 30.645455 2 29 2 L 21 2 z M 21 4 L 29 4 C 29.554545 4 30 4.4454545 30 5 L 30 7 L 20 7 L 20 5 C 20 4.4454545 20.445455 4 21 4 z M 11 9 L 18.832031 9 A 1.0001 1.0001 0 0 0 19.158203 9 L 30.832031 9 A 1.0001 1.0001 0 0 0 31.158203 9 L 39 9 L 39 45 C 39 45.554545 38.554545 46 38 46 L 12 46 C 11.445455 46 11 45.554545 11 45 L 11 9 z M 18.984375 13.986328 A 1.0001 1.0001 0 0 0 18 15 L 18 40 A 1.0001 1.0001 0 1 0 20 40 L 20 15 A 1.0001 1.0001 0 0 0 18.984375 13.986328 z M 24.984375 13.986328 A 1.0001 1.0001 0 0 0 24 15 L 24 40 A 1.0001 1.0001 0 1 0 26 40 L 26 15 A 1.0001 1.0001 0 0 0 24.984375 13.986328 z M 30.984375 13.986328 A 1.0001 1.0001 0 0 0 30 15 L 30 40 A 1.0001 1.0001 0 1 0 32 40 L 32 15 A 1.0001 1.0001 0 0 0 30.984375 13.986328 z"></path>
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
            {{ $usuario->links() }}
             <!-- Esto genera los enlaces de paginación -->
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
        // Ocultar el mensaje
        alert.style.display = 'none';
        
        // Eliminar la cookie 'success' después de ocultar el mensaje
        deleteCookie('success');
    }
}, 2000);
</script>
@endsection