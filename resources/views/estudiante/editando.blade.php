@extends('estudiante.index')

@section('subcontent')

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar</h2>

    <form id="roledit" action="{{ route('estudiante.update', $estudiante->alu_dni) }}" method="POST" onsubmit="return validarFormulario()">
        @csrf
    @method('PUT') 
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <!-- DNI Estudiante -->
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="alu_dni">DNI Estudiante</label>
            <select 
                id="alu_dni" 
                name="alu_dni" 
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md 
                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
            >
                <option value="">Seleccione un estudiante</option>
                @foreach ($estudiantes as $est)
                    <option value="{{ $est->alu_dni }}" 
                        {{ $estudiante->alu_dni == $est->alu_dni ? 'selected' : '' }}>
                        {{ $est->alu_dni }} - {{ $est->alu_apellidos }} {{ $est->alu_nombres }}
                    </option>
                @endforeach
            </select>
        </div>
        

        <!-- Apellidos -->
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="alu_apellidos">Apellidos</label>
            <input 
                id="alu_apellidos" 
                name="alu_apellidos" 
                value="{{ $estudiante->alu_apellidos }}" 
                type="text" 
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md 
                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorApellidos" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Nombres -->
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="alu_nombres">Nombres</label>
            <input 
                id="alu_nombres" 
                name="alu_nombres" 
                value="{{ $estudiante->alu_nombres }}" 
                type="text" 
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md 
                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorNombres" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Apoderado -->
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="apo_dni">Apoderado</label>
            <select 
                id="apo_dni" 
                name="apo_dni" 
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md 
                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
            >
                <option value="">Seleccione un apoderado</option>
                @foreach ($apoderados as $apoderado)
                    <option value="{{ $apoderado->apo_dni }}" 
                        {{ $estudiante->apo_dni == $apoderado->apo_dni ? 'selected' : '' }}>
                        {{ $apoderado->apo_dni }} - {{ $apoderado->apo_apellidos }} {{ $apoderado->apo_nombres }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Dirección -->
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="alu_direccion">Dirección</label>
            <input 
                id="alu_direccion" 
                name="alu_direccion" 
                value="{{ $estudiante->alu_direccion }}" 
                type="text" 
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md 
                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorDireccion" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <!-- Teléfono -->
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="alu_telefono">Teléfono</label>
            <input 
                id="alu_telefono" 
                name="alu_telefono" 
                value="{{ $estudiante->alu_telefono }}" 
                type="text" 
                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md 
                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorTelefono" class="text-red-500 text-sm hidden mt-1"></div>
        </div>

        <script>
            function validarFormulario() {
     var valid = true;
 
     // Limpiar mensajes de error anteriores
     var errorDivs = document.querySelectorAll('.text-red-500');
     errorDivs.forEach(function (div) {
         div.classList.add('hidden');
     });
 
     // Validación de DNI (solo números, longitud de 8 dígitos)
     var aluDni = document.getElementById('alu_dni').value;
     if (!aluDni || aluDni.length !== 8 || isNaN(aluDni)) {
         document.getElementById('errorDni').textContent = "El DNI debe ser un número de 8 dígitos.";
         document.getElementById('errorDni').classList.remove('hidden');
         valid = false;
     }
 
     // Validación de Apellidos (solo letras y espacios)
     var aluApellidos = document.getElementById('alu_apellidos').value;
     var regexTexto = /^[A-Za-záéíóúÁÉÍÓÚÑñ\s]+$/;
     if (!aluApellidos || !regexTexto.test(aluApellidos)) {
         document.getElementById('errorApellidos').textContent = "Los apellidos solo pueden contener letras y espacios.";
         document.getElementById('errorApellidos').classList.remove('hidden');
         valid = false;
     }
 
     // Validación de Nombres (solo letras y espacios)
     var aluNombres = document.getElementById('alu_nombres').value;
     if (!aluNombres || !regexTexto.test(aluNombres)) {
         document.getElementById('errorNombres').textContent = "Los nombres solo pueden contener letras y espacios.";
         document.getElementById('errorNombres').classList.remove('hidden');
         valid = false;
     }
 
     // Validación de Dirección (campo obligatorio)
     var aluDireccion = document.getElementById('alu_direccion').value;
     if (!aluDireccion) {
         document.getElementById('errorDireccion').textContent = "La dirección es obligatoria.";
         document.getElementById('errorDireccion').classList.remove('hidden');
         valid = false;
     }
 
     // Validación de Teléfono (solo números, longitud de 9 dígitos)
     var aluTelefono = document.getElementById('alu_telefono').value;
     if (!aluTelefono || aluTelefono.length !== 9 || isNaN(aluTelefono)) {
         document.getElementById('errorTelefono').textContent = "El teléfono debe ser un número de 9 dígitos.";
         document.getElementById('errorTelefono').classList.remove('hidden');
         valid = false;
     }
 
     return valid;
 }
 
         </script>

        <div class="flex justify-end mt-6">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <a href="{{route('estudiante.show')}}" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" >Regresar</a>
            

                <a id="registerButton" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600 cursor-pointer" >Actualizar</a>
            </div>
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

        document.getElementById('rolCrear').submit();
    });

    cancelButton.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
    });

</script>
@endsection