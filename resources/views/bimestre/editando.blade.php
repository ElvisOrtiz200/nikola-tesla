@extends('bimestre.index')

@section('subcontent')

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar</h2>

    <form id="roledit" action="{{ route('bimestre.update', $bimestre->bim_sigla) }}" method="POST" onsubmit="return validarFormulario()">
        @csrf
    @method('PUT') 
    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <!-- Sigla -->
        <div>
            <label class="text-gray-700 dark:text-gray-200">Sigla</label>
            <input id="bim_sigla" name="bim_sigla" value="{{ $bimestre->bim_sigla }}" type="text" 
                   class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
        </div>

        <!-- Descripción -->
        <div>
            <label class="text-gray-700 dark:text-gray-200">Descripción</label>
            <input id="bim_descripcion" name="bim_descripcion" value="{{ $bimestre->bim_descripcion }}" type="text" 
                   class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            <div id="errorDescripcion" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Año -->
        <div>
            <label class="text-gray-700 dark:text-gray-200">Año</label>
            <input id="anio" name="anio" value="{{ $bimestre->anio }}" type="text" 
                   class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            <div id="errorAnio" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Fecha de Inicio -->
        <div>
            <label class="text-gray-700 dark:text-gray-200">Fecha de Inicio</label>
            <input id="fecha_inicio" name="fecha_inicio" value="{{ $bimestre->fecha_inicio }}" type="date" 
                   class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            <div id="errorFechaInicio" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Fecha de Fin -->
        <div>
            <label class="text-gray-700 dark:text-gray-200">Fecha de Fin</label>
            <input id="fecha_fin" name="fecha_fin" value="{{ $bimestre->fecha_fin }}" type="date" 
                   class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            <div id="errorFechaFin" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <div class="my-4">
            <label for="estadoBIMESTRE" class="block text-lg font-semibold mb-2">Estado del Bimestre</label>
            <div class="relative">
                <select 
                    name="estadoBIMESTRE" 
                    id="estadoBIMESTRE" 
                    class="block w-full p-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring focus:ring-blue-200 text-lg font-medium bg-gray-50">
                    <option value="1" 
                        class="bg-green-100 text-green-700 font-bold"
                        {{ $bimestre->estadoBIMESTRE == 1 ? 'selected' : '' }}>
                        🟢 ACTIVO
                    </option>
                    <option value="0" 
                        class="bg-red-100 text-red-700 font-bold"
                        {{ $bimestre->estadoBIMESTRE == 0 ? 'selected' : '' }}>
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

            // Limpiar mensajes de error anteriores
            document.querySelectorAll('.text-red-500').forEach(div => div.classList.add('hidden'));

            // Validación de Descripción (máximo 15 caracteres)
            const descripcion = document.getElementById('bim_descripcion').value.trim();
            if (!descripcion || descripcion.length > 15) {
                document.getElementById('errorDescripcion').textContent = "La descripción debe tener máximo 15 caracteres.";
                document.getElementById('errorDescripcion').classList.remove('hidden');
                valid = false;
            }

            // Validación de Año (exactamente 4 dígitos)
            const anio = document.getElementById('anio').value.trim();
            if (!anio || anio.length !== 4 || isNaN(anio)) {
                document.getElementById('errorAnio').textContent = "El año debe ser un número de 4 dígitos.";
                document.getElementById('errorAnio').classList.remove('hidden');
                valid = false;
            }

            // Validación de Fechas
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            if (!fechaInicio) {
                document.getElementById('errorFechaInicio').textContent = "La fecha de inicio es obligatoria.";
                document.getElementById('errorFechaInicio').classList.remove('hidden');
                valid = false;
            }
            if (!fechaFin) {
                document.getElementById('errorFechaFin').textContent = "La fecha de fin es obligatoria.";
                document.getElementById('errorFechaFin').classList.remove('hidden');
                valid = false;
            }
            if (fechaInicio && fechaFin && new Date(fechaInicio) > new Date(fechaFin)) {
                document.getElementById('errorFechaFin').textContent = "La fecha de fin no puede ser anterior a la fecha de inicio.";
                document.getElementById('errorFechaFin').classList.remove('hidden');
                valid = false;
            }

            return valid;
        }
    </script>
        <div class="flex justify-end mt-6">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <a href="{{route('bimestre.show')}}" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" >Regresar</a>
            

                <a id="registerButton" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600 cursor-pointer" >Actualizar</a>
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
    
    
     // Lógica cuando se confirma el edit
     confirmButton.addEventListener('click', () => {
        // Aquí puedes proceder con el registro, por ejemplo, enviando el formulario
        document.getElementById('roledit').submit();
    });

    // Mostrar el modal cuando se hace clic en "Registrar"
    registerButton.addEventListener('click', () => {
        confirmModal.classList.remove('hidden');
    });

    // Ocultar el modal cuando se hace clic en "Cancelar"
    cancelButton.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
    });

</script>
@endsection