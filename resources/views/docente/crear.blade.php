@extends('docente.index')

  

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


<section class="max-w-4xl p-6 mx-auto bg-white rounded-md drop-shadow-2xl dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Registrar docente</h2>

    <form id="rolCrear" action="{{route('docente.store')}}" method="POST" onsubmit="return validarFormulario()">

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

            <!-- DNI del personal -->
            <div class="relative group">
                <label class="text-gray-700 dark:text-gray-200" for="per_id">DNI del personal</label>
                <select id="search-input" name="per_id" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Seleccione un DNI</option>
                    @foreach($rrhh as $personal)
                        <option value="{{ $personal->per_id }}">{{ $personal->per_dni }} - {{ $personal->per_apellidos }}</option>
                    @endforeach
                </select>
                <div id="search-input" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
            
        
            <!-- Especialidad -->
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="doc_especialidad">Especialidad</label>
                <input id="doc_especialidad" name="doc_especialidad" type="text" 
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="error-doc_especialidad" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
        
            <!-- Nivel Educativo -->
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="doc_nivel_educativo">Nivel Educativo</label>
                <input id="doc_nivel_educativo" name="doc_nivel_educativo" type="text" 
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="error-doc_nivel_educativo" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
        
            <!-- Fecha de Nacimiento -->
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="datepicker-individiual">Fecha de Nacimiento</label>
                <input id="datepicker-individiual" name="doc_fecha_nac" type="text" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder="YYYY-MM-DD">
                <div id="error-datepicker-individiual" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
        
        </div>
        

        <script>
            function validarFormulario() {
                let valid = true;
        
                // Limpiar mensajes de error anteriores
                const errorDivs = document.querySelectorAll('.text-red-500');
                errorDivs.forEach(div => div.classList.add('hidden'));
        
                // Validación del DNI del personal (Debe seleccionarse un valor)
                const perId = document.getElementById('search-input').value;
                if (!perId || perId.trim() === "") {
                    mostrarError('El DNI del personal es obligatorio.', 'search-input');
                    valid = false;
                }
        
                // Validación de Especialidad (campo obligatorio)
                const docEspecialidad = document.getElementById('doc_especialidad').value;
                if (!docEspecialidad || docEspecialidad.trim() === "") {
                    mostrarError('La especialidad es obligatoria.', 'doc_especialidad');
                    valid = false;
                }
        
                // Validación de Nivel Educativo (campo obligatorio)
                const docNivelEducativo = document.getElementById('doc_nivel_educativo').value;
                if (!docNivelEducativo || docNivelEducativo.trim() === "") {
                    mostrarError('El nivel educativo es obligatorio.', 'doc_nivel_educativo');
                    valid = false;
                }
        
                // Validación de Fecha de Nacimiento (campo obligatorio y formato válido)
                const docFechaNac = document.getElementById('datepicker-individiual').value;
                const fechaRegex = /^\d{4}-\d{2}-\d{2}$/; // Formato YYYY-MM-DD
                if (!docFechaNac || !fechaRegex.test(docFechaNac)) {
                    mostrarError('La fecha de nacimiento es obligatoria y debe estar en formato válido (YYYY-MM-DD).', 'datepicker-individiual');
                    valid = false;
                }
        
                return valid;
            }
        
            // Función para mostrar errores dinámicamente
            function mostrarError(mensaje, campoId) {
                let errorDiv = document.getElementById(`error-${campoId}`);
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.id = `error-${campoId}`;
                    errorDiv.classList.add('text-red-500', 'text-sm', 'mt-1');
                    const campo = document.getElementById(campoId);
                    campo.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = mensaje;
                errorDiv.classList.remove('hidden');
            }
        </script>
        
        <div class="flex justify-end mt-6">
            <button id="registerButton" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" type="button">Registrar</button>
        </div>
        
    </form>
</section>

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
                            <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white" id="modal-title">Confirmar Registro</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                ¿Estás seguro de que deseas registrar esta información?
                            </p>
                        </div>
                    </div>
    
                    <!-- Botones del Modal -->
                    <div class="mt-5 sm:flex sm:items-center sm:justify-between">
                        <button  id="cancelButton" class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:mt-0 sm:w-auto sm:mx-2 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                            Cancelar
                        </button>
    
                        <button id="confirmButton"  class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md sm:w-auto sm:mt-0 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                            Confirmar Registro
                        </button>
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
        alert.style.display = 'none';
        deleteCookie('success'); // Borrar cookie de éxito
        deleteCookie('error');   // Borrar cookie de error
    }
}, 3000);
</script>
<script>
    // JavaScript to toggle the dropdown
        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownItems = document.querySelectorAll('.dropdown-items');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const searchInput = document.getElementById('search-input');
        const valor = document.getElementById('valor');
        let isOpen = false; // Set to true to open the dropdown by default
        dropdownItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que el enlace navegue

            const dniValue = this.getAttribute('data-dni'); // Obtiene el DNI del atributo data-dni
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

    </script>
  
  
  
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

        document.getElementById('rolCrear').submit();
    });

    cancelButton.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
    });

</script>
<script>
    $(document).ready(function() {
        // Inicializa Select2 con la barra de búsqueda habilitada
        $('#per_id').select2({
            placeholder: "Seleccione el DNI",
            allowClear: true,
            width: '100%'  // Asegura que el ancho del select2 se ajuste al contenedor
        });
    });
</script>

@endsection
