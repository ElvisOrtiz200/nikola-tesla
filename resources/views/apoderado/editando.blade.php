@extends('apoderado.index')

@section('subcontent')

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar</h2>

    <form id="roledit" action="{{ route('apoderado.update', $apoderado->apo_dni) }}" method="POST">
        @csrf
    @method('PUT') 
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <input id="apo_dni" name="apo_dni" value="{{ $apoderado->apo_dni }}" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring" readonly>
            </div>
        
            <div>
                <input id="apo_apellidos" name="apo_apellidos" value="{{ $apoderado->apo_apellidos }}" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            </div>


            <div>
                <input id="apo_nombres" name="apo_nombres" value="{{ $apoderado->apo_nombres }}" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            </div>

            <div>
                <input id="apo_direccion" name="apo_direccion" value="{{ $apoderado->apo_direccion }}" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            </div>

            <div>
                <input id="apo_telefono" name="apo_telefono" value="{{ $apoderado->apo_telefono }}" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            </div>
        </div>
        

        <div class="flex justify-end mt-6">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <a href="{{route('apoderado.show')}}" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" >Regresar</a>
            

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