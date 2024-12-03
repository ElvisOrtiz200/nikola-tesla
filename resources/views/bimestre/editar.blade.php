@extends('bimestre.index')


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
        <div class="flex flex-col">
            <!-- Search Bar -->
            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('bimestre.show') }}" class="w-full max-w-md">
                    <input type="text" name="search" placeholder="Buscar bimestre..."
                           value="{{ request('search') }}"
                           class="block w-full px-4 py-2 border border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </form>
            </div>
        
            <!-- Tabla -->
            <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-white border-b">
                                <tr>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">#</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Sigla</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Descripción</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Año</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Fecha Inicio</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Fecha Fin</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($bimestres->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center text-gray-500">No hay coincidencias</td>
                                    </tr>
                                @else
                                    @foreach ($bimestres as $bimestre)
                                        <tr class="bg-white border-b">
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $bimestre->bim_sigla }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $bimestre->bim_descripcion }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $bimestre->anio }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $bimestre->fecha_inicio }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $bimestre->fecha_fin }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('bimestre.editando', $bimestre->bim_sigla) }}"
                                                   class="relative h-10 max-h-[40px] w-10 max-w-[40px] 
                                                          flex items-center justify-center 
                                                          rounded-lg text-center font-sans text-xs font-medium 
                                                          uppercase text-slate-900 
                                                          bg-white shadow-md transition-all 
                                                          hover:bg-slate-200 active:bg-slate-300 
                                                          disabled:pointer-events-none disabled:opacity-50">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
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
        
                        <!-- Paginación -->
                        <div class="mt-4">
                            {{ $bimestres->links() }}
                        </div>
                    </div>
                </div>
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