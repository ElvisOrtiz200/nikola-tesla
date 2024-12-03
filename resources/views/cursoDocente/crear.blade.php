@extends('cursoDocente.index')



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



<section class="max-w-4xl p-6 mx-auto bg-white rounded-md drop-shadow-2xl dark:bg-gray-800">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h2 class="text-xl font-bold text-gray-800 capitalize dark:text-white mb-6">
            Registrar docente a curso
        </h2>
        
        <form id="rolCrear" action="{{ route('curso-docente.store') }}" method="POST" onsubmit="return validarFormulario()" class="space-y-6">
            <div>
                <label for="example-select1" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Selecciona un grado
                </label>
                <select id="example-select1" name="id_grado" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <option value="">Selecciona un grado</option>
                    @foreach ($grado as $itemgrado)
                        <option value="{{ $itemgrado->id_grado }}">{{ $itemgrado->grado }} {{ $itemgrado->nivel }}</option>
                    @endforeach
                </select>
                <div id="errorGrado" class="text-red-500 text-sm hidden">Por favor, selecciona un grado.</div>
            </div>
        
            <div>
                <label for="example-select4" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Selecciona un curso
                </label>
                <select id="example-select4" name="acu_id" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <option value="">Selecciona un curso</option>
                </select>
                <div id="errorCurso" class="text-red-500 text-sm hidden">Por favor, selecciona un curso.</div>
            </div>
        
            <div>
                <label for="selectOption" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Seleccionar docente
                </label>
                <select id="selectOption" name="per_id" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    @foreach ($docentes as $itemdocentes)
                        <option value="{{ $itemdocentes->per_id }}">{{ $itemdocentes->apellidosDoc }} - {{ $itemdocentes->nombresDoc }}</option>
                    @endforeach
                </select>
                <div id="errorDocente" class="text-red-500 text-sm hidden">Por favor, selecciona un docente.</div>
            </div>
        
            <div id="date-range-picker" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="datepicker-range-start" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Fecha de inicio
                    </label>
                    <input id="datepicker-range-start" name="acdo_fecha_ini" type="text" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300" placeholder="Fecha de inicio">
                    <div id="errorFechaInicio" class="text-red-500 text-sm hidden">Por favor, selecciona una fecha de inicio.</div>
                </div>
                <div>
                    <label for="datepicker-range-end" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Fecha fin
                    </label>
                    <input id="datepicker-range-end" name="acdo_fecha_fin" type="text" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300" placeholder="Fecha fin">
                    <div id="errorFechaFin" class="text-red-500 text-sm hidden">Por favor, selecciona una fecha fin.</div>
                </div>
            </div>
        
            <div id="error-message" class="hidden p-4 text-red-600 bg-red-100 border border-red-300 rounded-lg">
                Por favor, completa todos los campos obligatorios.
            </div>
        
            <div class="flex justify-end">
                <button id="registerButton" type="button" class="px-6 py-2 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                    Registrar
                </button>
            </div>
        </form>
        
        <script>
            function validarFormulario() {
                let valid = true;
        
                // Reiniciar mensajes de error
                const errorMessages = document.querySelectorAll('.text-red-500');
                errorMessages.forEach((message) => {
                    message.classList.add('hidden');
                });
        
                // Validación de grado
                const grado = document.getElementById('example-select1').value;
                if (!grado) {
                    document.getElementById('errorGrado').classList.remove('hidden');
                    valid = false;
                }
        
                // Validación de curso
                const curso = document.getElementById('example-select4').value;
                if (!curso) {
                    document.getElementById('errorCurso').classList.remove('hidden');
                    valid = false;
                }
        
                // Validación de docente
                const docente = document.getElementById('selectOption').value;
                if (!docente) {
                    document.getElementById('errorDocente').classList.remove('hidden');
                    valid = false;
                }
        
                // Validación de fecha de inicio
                const fechaInicio = document.getElementById('datepicker-range-start').value;
                if (!fechaInicio) {
                    document.getElementById('errorFechaInicio').classList.remove('hidden');
                    valid = false;
                }
        
                // Validación de fecha fin
                const fechaFin = document.getElementById('datepicker-range-end').value;
                if (!fechaFin) {
                    document.getElementById('errorFechaFin').classList.remove('hidden');
                    valid = false;
                }
        
                return valid;
            }
        </script>
        
    </div>
    
   
    
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
        // Ocultar el mensaje
        alert.style.display = 'none';
        
        // Eliminar la cookie 'success' después de ocultar el mensaje
        deleteCookie('success');
    }
}, 2000);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentYear = new Date().getFullYear(); // Obtener el año actual
        document.getElementById('acdo_anio').value = currentYear; // Asignar el año al input
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
    $('#example-select1').change(function() {
        var gradoId = $(this).val();

        // Usando el nombre de la ruta
        var url = '{{ route("get.cursos", ":gradoId") }}';
        url = url.replace(':gradoId', gradoId); // Reemplaza el parámetro con el id del grado

        // Realiza la solicitud AJAX con la URL generada
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                // Aquí manejas la respuesta, por ejemplo, llenando el select de cursos
                var select = $('#example-select4');
                select.empty(); // Limpia las opciones actuales

                data.forEach(function(curso) {
                    select.append('<option value="' + curso.acu_id + '">' + curso.acu_nombre + '</option>');
                });
            },
            error: function() {
                alert('Error al cargar los cursos');
            }
        });
    });
});

</script>
@endsection
