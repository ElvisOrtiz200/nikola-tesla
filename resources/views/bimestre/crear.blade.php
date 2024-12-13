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
 

        <section class="max-w-4xl p-6 mx-auto bg-white rounded-md drop-shadow-2xl dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Registrar bimestre</h2>

            <form id="rolCrear" action="{{ route('bimestre.store') }}" method="POST" onsubmit="return validarFormulario()">
                @csrf

                <div class="grid grid-cols-1 gap-6 mt-4">
                    <!-- Campo Bim Sigla -->
                <!-- Campo Bim Sigla -->
        <div>
            <label for="bim_sigla" class="text-gray-700">Bimestre Sigla</label>
            <input id="bim_sigla" name="bim_sigla" type="text" value="{{ old('bim_sigla') }}"
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div id="error_bim_sigla" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Campo Bim Descripción -->
        <div>
            <label for="bim_descripcion" class="text-gray-700">Bimestre Descripción</label>
            <input id="bim_descripcion" name="bim_descripcion" type="text" value="{{ old('bim_descripcion') }}"
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div id="error_bim_descripcion" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Campo Año -->
        <div>
            <label for="anio" class="text-gray-700">Año</label>
            <input id="anio" name="anio" type="text" value="{{ old('anio') }}"
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div id="error_anio" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Campo Fecha Inicio -->
        <div>
            <label for="fecha_inicio" class="text-gray-700">Fecha Inicio</label>
            <input id="fecha_inicio" name="fecha_inicio" type="date" value="{{ old('fecha_inicio') }}"
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div id="error_fecha_inicio" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Campo Fecha Fin -->
        <div>
            <label for="fecha_fin" class="text-gray-700">Fecha Fin</label>
            <input id="fecha_fin" name="fecha_fin" type="date" value="{{ old('fecha_fin') }}"
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div id="error_fecha_fin" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <div class="my-4">
            <label for="estadoBIMESTRE" class="block text-lg font-semibold mb-2">Estado del Bimestre</label>
            <div class="relative">
                <select 
                    name="estadoBIMESTRE" 
                    id="estadoBIMESTRE" 
                    class="block w-full p-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring focus:ring-blue-200 text-lg font-medium bg-gray-50">
                    <option value="1" class="bg-green-100 text-green-700 font-bold">
                        🟢 ACTIVO
                    </option>
                    <option value="0" class="bg-red-100 text-red-700 font-bold">
                        🔴 INACTIVO
                    </option>
                </select>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                    </svg>
                </div>
            </div>
        </div>
        

        </div>
        
        <script>
            function validarFormulario() {
                let valid = true;
        
                // Limpiar mensajes de error previos
                const errorDivs = document.querySelectorAll('.text-red-500');
                errorDivs.forEach(div => div.classList.add('hidden'));
        
                // Validación de Bimestre Sigla (letras, longitud entre 1 y 3)
                const bimSigla = document.getElementById('bim_sigla').value.trim();
                
        
                // Validación de Bimestre Descripción (no vacío)
                const bimDescripcion = document.getElementById('bim_descripcion').value.trim();
                if (!bimDescripcion) {
                    mostrarError('bim_descripcion', 'La descripción no puede estar vacía.');
                    valid = false;
                } else if (bimDescripcion.length > 15) {
                    mostrarError('bim_descripcion', 'La descripción no debe exceder los 15 caracteres.');
                    valid = false;
                }

        
                // Validación de Año (número de 4 dígitos, debe ser válido)
                const anio = document.getElementById('anio').value.trim();
                if (!anio || !/^\d{4}$/.test(anio) || parseInt(anio) < 1900 || parseInt(anio) > new Date().getFullYear() + 1) {
                    mostrarError('anio', 'El año debe ser un número de 4 dígitos válido.');
                    valid = false;
                }
        
                // Validación de Fecha Inicio (no vacío y válida)
                const fechaInicio = document.getElementById('fecha_inicio').value;
                if (!fechaInicio || isNaN(new Date(fechaInicio).getTime())) {
                    mostrarError('fecha_inicio', 'La fecha de inicio es inválida.');
                    valid = false;
                }
        
                // Validación de Fecha Fin (no vacío, válida, y posterior a Fecha Inicio)
                const fechaFin = document.getElementById('fecha_fin').value;
                if (!fechaFin || isNaN(new Date(fechaFin).getTime())) {
                    mostrarError('fecha_fin', 'La fecha de fin es inválida.');
                    valid = false;
                } else if (fechaInicio && new Date(fechaFin) <= new Date(fechaInicio)) {
                    mostrarError('fecha_fin', 'La fecha de fin debe ser posterior a la fecha de inicio.');
                    valid = false;
                }
        
                return valid;
            }
        
            function mostrarError(campoId, mensaje) {
                const errorDiv = document.getElementById(`error_${campoId}`);
                if (errorDiv) {
                    errorDiv.textContent = mensaje;
                    errorDiv.classList.remove('hidden');
                }
            }
        </script>
        
        <!-- Botón de registrar -->
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
