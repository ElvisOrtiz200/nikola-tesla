@extends('dashboard')
  
@section('content') 

<h1 class="text-3xl">Administración de apoderados</h1>

<div class="w-auto h-[500px] md:h-[75%] lg:h-[75%] rounded border-dashed border-2 border-gray-300 overflow-auto">
    <header class="bg-white">
        <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-teal-700 lg:px-8">
            
            
        </div>
            
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
