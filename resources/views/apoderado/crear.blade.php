@extends('apoderado.index')

 

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
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Registrar usuario</h2>

    <form id="rolCrear" action="{{route('apoderado.store')}}" method="POST" onsubmit="return validarFormulario()">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="apo_dni">DNI</label>
                <input id="apo_dni" name="apo_dni" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorDni" class="text-red-500 text-sm hidden mt-1"></div>
            </div>
    
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="apo_apellidos">Apellidos</label>
                <input id="apo_apellidos" name="apo_apellidos" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorApellidos" class="text-red-500 text-sm hidden mt-1"></div>
            </div>
    
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="apo_nombres">Nombres</label>
                <input id="apo_nombres" name="apo_nombres" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorNombres" class="text-red-500 text-sm hidden mt-1"></div>
            </div>
    
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="apo_direccion">Dirección</label>
                <input id="apo_direccion" name="apo_direccion" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorDireccion" class="text-red-500 text-sm hidden mt-1"></div>
            </div>
    
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="apo_telefono">Teléfono</label>
                <input id="apo_telefono" name="apo_telefono" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorTelefono" class="text-red-500 text-sm hidden mt-1"></div>
            </div>
    
        </div>
        <script>
            function validarFormulario() {
                var valid = true;
                
                // Limpiar mensajes de error anteriores
                var errorDivs = document.querySelectorAll('.text-red-500');
                errorDivs.forEach(function(div) {
                    div.classList.add('hidden');
                });
                
                // Validación de DNI (solo números, longitud de 8 dígitos)
                var apoDni = document.getElementById('apo_dni').value;
                if (!apoDni || apoDni.length !== 8 || isNaN(apoDni)) {
                    document.getElementById('errorDni').textContent = "El DNI debe ser un número de 8 dígitos.";
                    document.getElementById('errorDni').classList.remove('hidden');
                    valid = false;
                }
    
                // Validación de Apellidos (solo letras y espacios)
                var apoApellidos = document.getElementById('apo_apellidos').value;
                var regexApellidos = /^[A-Za-záéíóúÁÉÍÓÚÑñ\s]+$/;
                if (!apoApellidos || !regexApellidos.test(apoApellidos)) {
                    document.getElementById('errorApellidos').textContent = "Los apellidos solo pueden contener letras y espacios.";
                    document.getElementById('errorApellidos').classList.remove('hidden');
                    valid = false;
                }
    
                // Validación de Nombres (solo letras y espacios)
                var apoNombres = document.getElementById('apo_nombres').value;
                if (!apoNombres || !regexApellidos.test(apoNombres)) {
                    document.getElementById('errorNombres').textContent = "Los nombres solo pueden contener letras y espacios.";
                    document.getElementById('errorNombres').classList.remove('hidden');
                    valid = false;
                }
    
                // Validación de Dirección (campo obligatorio)
                var apoDireccion = document.getElementById('apo_direccion').value;
                if (!apoDireccion) {
                    document.getElementById('errorDireccion').textContent = "La dirección es obligatoria.";
                    document.getElementById('errorDireccion').classList.remove('hidden');
                    valid = false;
                }
    
                // Validación de Teléfono (solo números, longitud de 9 dígitos)
                var apoTelefono = document.getElementById('apo_telefono').value;
                if (!apoTelefono || apoTelefono.length !== 9 || isNaN(apoTelefono)) {
                    document.getElementById('errorTelefono').textContent = "El teléfono debe ser un número de 9 dígitos.";
                    document.getElementById('errorTelefono').classList.remove('hidden');
                    valid = false;
                }
    
                return valid;
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
@endsection
