@extends('grado.index')

@section('subcontent')

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar</h2>

    <form id="roledit" action="{{ route('grado.update', $grados->id_grado) }}" method="POST" onsubmit="return validarFormulario()">
        @csrf
    @method('PUT') 
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="nombre">Nombre del grado</label>
                <input id="nombre" name="nombre" value="{{ $grados->nombre }}" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorNombre" class="mt-2 text-sm text-red-500 hidden"></div>
            </div>
           
            <div class="relative group"> <label class="text-gray-700 dark:text-gray-200">Nombre del nivel</label>
                <button type="button" id="dropdown-button" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                  <span class="mr-2">Nivel</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
                <div id="dropdown-menu" class="hidden absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1">
                  <!-- Search input -->
                  <input id="dni-input" type="text" class="block w-full px-4 py-2 text-gray-800 border rounded-md border-gray-300 focus:outline-none" 
         value="{{ $grados->nivel->nombre ?? '' }}" >
  
  <!-- Input oculto que guarda el per_id para enviarlo -->
  <input type="hidden" id="nivel-id-input" name="id_nivel" value="{{ $grados->nivel->id_nivel ?? '' }}">
                  
                  <!-- Dropdown content goes here -->
                  @foreach($niveles as $nivel)
            <a href="javascript:void(0);" class="dropdown-item block px-4 py-2 text-gray-700 hover:bg-gray-100 cursor-pointer rounded-md"
               data-id="{{ $nivel->id_nivel }}" data-nombre="{{ $nivel->nombre }}">
               {{ $nivel->nombre }}
            </a>
        @endforeach
                </div>
              </div>
            

              <script>
                function validarFormulario() {
                    var valid = true;
            
                    // Limpiar mensaje de error previo
                    var errorDiv = document.getElementById('errorNombre');
                    errorDiv.classList.add('hidden');
                    errorDiv.textContent = '';
            
                    // Validación del campo 'nombre' (solo letras y espacios)
                    var nombre = document.getElementById('nombre').value;
                    var regexNombre = /^[A-Za-záéíóúÁÉÍÓÚÑñ0-9\s]+$/;
                    if (!nombre || !regexNombre.test(nombre)) {
                        errorDiv.textContent = "El nombre solo puede contener letras y espacios.";
                        errorDiv.classList.remove('hidden');
                        valid = false;
                    }
            
                    return valid;
                }
            </script>
        </div>

        <div class="flex  mt-6 justify-center">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <a href="{{route('grado.show')}}" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" >Regresar</a>
            

                <button id="registerButton" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600 cursor-pointer" type="button" >Actualizar</button>
            </div>
            
        </div>
    </form>


    <div id="confirmModal" class="fixed inset-0  items-center justify-center bg-black bg-opacity-50 hidden">
    
        <div x-data="{ isOpen: false }" class="relative flex justify-center">
           
            <div x-show="isOpen" 
                x-transition:enter="transition duration-300 ease-out"
                x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave="transition duration-150 ease-in"
                x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
            >
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
                    <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl rtl:text-right dark:bg-gray-900 sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                        <div>
                            <div class="flex items-center justify-center">
                                <!-- Icono de confirmación -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
        
                            <div class="mt-2 text-center">
                                <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white" id="modal-title">Confirmar Actualización</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    ¿Estás seguro de que deseas editar esta información?
                                </p>
                            </div>
                        </div>
        
                        <!-- Botones del Modal -->
                        <div class="mt-5 sm:flex sm:items-center sm:justify-between">
                            <button  id="cancelButton" class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:mt-0 sm:w-auto sm:mx-2 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                                Cancelar
                            </button>
        
                            <button id="confirmButton"  class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md sm:w-auto sm:mt-0 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                                Confirmar Actualización
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        
    
        </div>
        
    </div>
</section>

<script>
    const registerButton = document.getElementById('registerButton');
    const confirmModal = document.getElementById('confirmModal');
    const cancelButton = document.getElementById('cancelButton');
    const confirmButton = document.getElementById('confirmButton');
    
    registerButton.addEventListener('click', function () {
    if (validarFormulario()) {     
        confirmModal.classList.remove('hidden');    
    }
    });

    confirmButton.addEventListener('click', () => {

        document.getElementById('roledit').submit();
    });

    cancelButton.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
    });

</script>
<script>
        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownItems = document.querySelectorAll('.dropdown-items');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const peridinput= document.getElementById('per-id-input');
        const searchInput = document.getElementById('dni-input');
        const valor = document.getElementById('valor');
        let isOpen = false; // Set to true to open the dropdown by default
        dropdownItems.forEach(item => {
        item.addEventListener('click', function(event) {
            const dniValue1 = this.getAttribute('data-id');
            event.preventDefault(); // Evita que el enlace navegue
            peridinput.value = dniValue1;
            const dniValue = this.getAttribute('data-dni');
             // Obtiene el DNI del atributo data-dni
            searchInput.value = dniValue; // Coloca el DNI en el input
            dropdownMenu.classList.add('hidden'); // Oculta el dropdown después de la selección
        });
    });
        // Function to toggle the dropdown state
        function toggleDropdown() {
          isOpen = !isOpen;
          dropdownMenu.classList.toggle('hidden', !isOpen);
        }
        



        
        // Set initial state
        toggleDropdown();
        
        dropdownButton.addEventListener('click', () => {
          toggleDropdown();
        });
        
        valor.addEventListener('click',()=>{
            const dniValue = this.getAttribute('data-dni'); // Obtiene el DNI del atributo data-dni
            searchInput.value = dniValue; // Colo
        });

        // Add event listener to filter items based on input
        searchInput.addEventListener('input', () => {
          const searchTerm = searchInput.value.toLowerCase();
          const items = dropdownMenu.querySelectorAll('a');
        
          items.forEach((item) => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
              item.style.display = 'block';
            } else {
              item.style.display = 'none';
            }
          });
        });

        dropdownItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que el enlace navegue

            const dniValue = this.getAttribute('data-dni'); // Obtiene el DNI del atributo data-dni
            searchInput.value = dniValue; // Coloca el DNI en el input
            dropdownMenu.classList.add('hidden'); // Oculta el dropdown después de la selección
        });
    });

    </>
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const dniInput = document.getElementById('dni-input');
    const nivelIdInput = document.getElementById('nivel-id-input');
    const dropdownItems = document.querySelectorAll('.dropdown-item');

    // Mostrar/Ocultar el menú de dropdown al hacer clic en el botón
    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    // Actualizar los inputs al seleccionar un elemento del dropdown
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const selectedName = this.getAttribute('data-nombre');
            const selectedId = this.getAttribute('data-id');

            // Actualizar el input visible con el nombre
            dniInput.value = selectedName;

            // Actualizar el input oculto con el id
            nivelIdInput.value = selectedId;

            // Ocultar el menú una vez seleccionado
            dropdownMenu.classList.add('hidden');
        });
    });
});
</script>
@endsection