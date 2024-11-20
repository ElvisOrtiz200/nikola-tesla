@extends('dashboard')
  
@section('content')

<h1 class="text-3xl">Administración de docentes</h1>

<div class="w-auto h-[500px] md:h-[75%] lg:h-[75%] rounded border-dashed border-2 border-gray-300 overflow-auto">
    <header class="bg-white">
        <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-teal-700 lg:px-8">
            <nav class="hidden lg:flex lg:space-x-8 lg:py-2" aria-label="Global">
                <!-- Añadimos un id único a cada botón -->
                <a href="{{route('docente.create')}}" id="btn-registrar" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 inline-flex items-center rounded-md py-2 px-3 text-sm font-medium" aria-current="page" onclick="handleButtonClick(this, 'btn-registrar')">Registrar</a>
                <a href="{{route('docente.show')}}" id="btn-editar" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 inline-flex items-center rounded-md py-2 px-3 text-sm font-medium" onclick="handleButtonClick(this, 'btn-editar')">Editar</a>
                <a href="{{route('docente.eliminar')}}" id="btn-projects" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 inline-flex items-center rounded-md py-2 px-3 text-sm font-medium" onclick="handleButtonClick(this, 'btn-projects')">Eliminar</a>
                <a href="" id="btn-calendar" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 inline-flex items-center rounded-md py-2 px-3 text-sm font-medium" onclick="handleButtonClick(this, 'btn-calendar')">Listar</a>
            </nav>
            <div class="relative flex h-0 justify-between">
            </div>
            </div>
          
            <!-- Mobile menu, show/hide based on menu state. -->
            <nav class="lg:hidden" aria-label="Global" id="mobile-menu">
              <div class="space-y-1 px-2 pb-3 pt-2">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a href="{{route('docente.create')}}" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 block rounded-md py-2 px-3 text-base font-medium" aria-current="page" onclick="handleButtonClick(this, 'btn-registrar')">Registrar</a>
                <a href="{{route('docente.show')}}" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 block rounded-md py-2 px-3 text-base font-medium" onclick="handleButtonClick(this, 'btn-editar')">Editar</a>
                <a href="{{route('docente.eliminar')}}" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 block rounded-md py-2 px-3 text-base font-medium" onclick="handleButtonClick(this, 'btn-projects')">Eliminar</a>
                <a href="" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 block rounded-md py-2 px-3 text-base font-medium" onclick="handleButtonClick(this, 'btn-calendar')">Listar</a>
              </div>
              <div class="border-t border-gray-700 pb-3 pt-4">
                <div class="flex items-center px-4">
                </div>
              </div>
            </nav>
          </header>
    <div class="px-5 py-5">
        <!-- Aquí colocamos el segundo yield para subcontenido -->
        @yield('subcontent')  
    </div>
</div>

<script>
  // Variable para guardar el botón activo
  let activeButton = null;

  // Función para manejar el clic del botón
  function handleButtonClick(button, buttonId) {
    // Guardamos el botón clicado en localStorage
    localStorage.setItem('activeButton', buttonId);

    // Si hay un botón activo, restauramos sus clases originales
    if (activeButton) {
      activeButton.classList.remove('bg-gray-900', 'text-white');
      activeButton.classList.add('text-cyan-500', 'bg-yellow-400', 'hover:bg-cyan-500', 'hover:text-yellow-400');
    }

    // Aplicamos las nuevas clases al botón clicado
    button.classList.remove('text-cyan-500', 'bg-yellow-400', 'hover:bg-cyan-500', 'hover:text-yellow-400');
    button.classList.add('bg-gray-900', 'text-white');

    // Guardamos el nuevo botón como activo
    activeButton = button;
  }

  // Al cargar la página, recuperamos el botón activo de localStorage
  window.onload = function() {
    const savedButtonId = localStorage.getItem('activeButton');

    if (savedButtonId) {
      // Buscamos el botón guardado en localStorage por su ID
      const savedButton = document.getElementById(savedButtonId);
      if (savedButton) {
        // Simulamos el clic para que reciba las clases correspondientes
        handleButtonClick(savedButton, savedButtonId);
      }
    }
  };
</script>

@endsection
