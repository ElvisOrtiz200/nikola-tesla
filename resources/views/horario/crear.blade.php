@extends('horario.index')



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
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Registrar horario</h2>

    <form id="rolCrear" action="{{route('horario.store')}}" method="POST">
        @csrf
        <input type="hidden" name="horarios" id="horarios-json">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1">
            <select id="example-select1" name="id_grado" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 p-3 transition duration-200 ease-in-out">
                <option value="">Selecciona un grado</option>
                @foreach ($grado as $itemgrado)
                    <option value="{{$itemgrado->id_grado}}">{{$itemgrado->grado}} {{$itemgrado->nivel}}</option>
                @endforeach
            </select>
            
        </div>
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3 border p-2">
            
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1">
                <div class="w-full max-w-xs">
                    <label for="example-select2" class="block text-sm font-medium text-gray-700 mb-2">Selecciona un día de la semana:</label>
                    <select id="example-select2" name="idDiaSemana" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 p-3 transition duration-200 ease-in-out">
                        @foreach ($diaSemana as $itemdiaSemana)
                            <option value="{{$itemdiaSemana->idDiaSemana}}">{{$itemdiaSemana->nombreDia}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1">
                <div class="w-full max-w-xs">
                    <label for="example-select3" class="block text-sm font-medium text-gray-700 mb-2">Selecciona una hora:</label>
                    <select id="example-select3" name="idHora" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 p-3 transition duration-200 ease-in-out">
                        @foreach ($horas as $itemhora)
                            <option value="{{$itemhora->idHora}}">{{$itemhora->nombreHora}} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <select id="example-select4" name="idHora" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 p-3 transition duration-200 ease-in-out">
                <option value="">Selecciona un curso</option>
            </select>
            
        </div>

        <div class="flex justify-end mt-6">
            <button id="addButton" disabled class="px-4 py-2 leading-5 text-white bg-blue-600 rounded-md hover:bg-blue-500" type="button">Agregar</button>
        </div>

        <div id="scheduleGrid" class="grid grid-cols-1 sm:grid-cols-6 gap-2 mt-6 border-t border-gray-300 pt-4">
            <!-- Encabezados de días de la semana -->
            <div class="font-bold text-center hidden sm:block">Hora/Día</div>
            <div class="font-bold text-center">Lunes</div>
            <div class="font-bold text-center">Martes</div>
            <div class="font-bold text-center">Miercoles</div>
            <div class="font-bold text-center">Jueves</div>
            <div class="font-bold text-center">Viernes</div>
        
            <!-- Filas para cada hora de 7 a 18 -->
            <div class="font-bold text-center sm:col-span-1 sm:block">07:00 - 08:00</div>
            <div id="cell-Lunes-07:00-08:00 1" class="schedule-cell border p-2" data-day="Lunes" data-hour="07:00 - 08:00"></div>
            <div id="cell-Martes-07:00-08:00 2" class="schedule-cell border p-2" data-day="Martes" data-hour="07:00 - 08:00"></div>
            <div id="cell-Miercoles-07:00-08:00 3" class="schedule-cell border p-2" data-day="Miercoles" data-hour="07:00 - 08:00"></div>
            <div id="cell-Jueves-07:00-08:00 4" class="schedule-cell border p-2" data-day="Jueves" data-hour="07:00 - 08:00"></div>
            <div id="cell-Viernes-07:00-08:00 5" class="schedule-cell border p-2" data-day="Viernes" data-hour="07:00 - 08:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">08:00 - 09:00</div>
            <div id="cell-Lunes-08:00-09:00 6" class="schedule-cell border p-2" data-day="Lunes" data-hour="08:00 - 09:00"></div>
            <div id="cell-Martes-08:00-09:00 7" class="schedule-cell border p-2" data-day="Martes" data-hour="08:00 - 09:00"></div>
            <div id="cell-Miercoles-08:00-09:00 8" class="schedule-cell border p-2" data-day="Miercoles" data-hour="08:00 - 09:00"></div>
            <div id="cell-Jueves-08:00-09:00 9" class="schedule-cell border p-2" data-day="Jueves" data-hour="08:00 - 09:00"></div>
            <div id="cell-Viernes-08:00-09:00 10" class="schedule-cell border p-2" data-day="Viernes" data-hour="08:00 - 09:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">09:00 - 10:00</div>
            <div id="cell-Lunes-09:00-10:00 11" class="schedule-cell border p-2" data-day="Lunes" data-hour="09:00 - 10:00"></div>
            <div id="cell-Martes-09:00-10:00 12" class="schedule-cell border p-2" data-day="Martes" data-hour="09:00 - 10:00"></div>
            <div id="cell-Miercoles-09:00-10:00 13" class="schedule-cell border p-2" data-day="Miercoles" data-hour="09:00 - 10:00"></div>
            <div id="cell-Jueves-09:00-10:00 14" class="schedule-cell border p-2" data-day="Jueves" data-hour="09:00 - 10:00"></div>
            <div id="cell-Viernes-09:00-10:00 15" class="schedule-cell border p-2" data-day="Viernes" data-hour="09:00 - 10:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">10:00 - 11:00</div>
            <div id="cell-Lunes-10:00-11:00 16" class="schedule-cell border p-2" data-day="Lunes" data-hour="10:00 - 11:00"></div>
            <div id="cell-Martes-10:00-11:00 17" class="schedule-cell border p-2" data-day="Martes" data-hour="10:00 - 11:00"></div>
            <div id="cell-Miercoles-10:00-11:00 18" class="schedule-cell border p-2" data-day="Miercoles" data-hour="10:00 - 11:00"></div>
            <div id="cell-Jueves-10:00-11:00 19" class="schedule-cell border p-2" data-day="Jueves" data-hour="10:00 - 11:00"></div>
            <div id="cell-Viernes-10:00-11:00 20" class="schedule-cell border p-2" data-day="Viernes" data-hour="10:00 - 11:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">11:00 - 12:00</div>
            <div id="cell-Lunes-11:00-12:00 21" class="schedule-cell border p-2" data-day="Lunes" data-hour="11:00 - 12:00"></div>
            <div id="cell-Martes-11:00-12:00 22" class="schedule-cell border p-2" data-day="Martes" data-hour="11:00 - 12:00"></div>
            <div id="cell-Miercoles-11:00-12:00 23" class="schedule-cell border p-2" data-day="Miercoles" data-hour="11:00 - 12:00"></div>
            <div id="cell-Jueves-11:00-12:00 24" class="schedule-cell border p-2" data-day="Jueves" data-hour="11:00 - 12:00"></div>
            <div id="cell-Viernes-11:00-12:00 25" class="schedule-cell border p-2" data-day="Viernes" data-hour="11:00 - 12:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">12:00 - 13:00</div>
            <div id="cell-Lunes-12:00-13:00 26" class="schedule-cell border p-2" data-day="Lunes" data-hour="12:00 - 13:00"></div>
            <div id="cell-Martes-12:00-13:00 27" class="schedule-cell border p-2" data-day="Martes" data-hour="12:00 - 13:00"></div>
            <div id="cell-Miercoles-12:00-13:00 28" class="schedule-cell border p-2" data-day="Miercoles" data-hour="12:00 - 13:00"></div>
            <div id="cell-Jueves-12:00-13:00 29" class="schedule-cell border p-2" data-day="Jueves" data-hour="12:00 - 13:00"></div>
            <div id="cell-Viernes-12:00-13:00 30" class="schedule-cell border p-2" data-day="Viernes" data-hour="12:00 - 13:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">13:00 - 14:00</div>
            <div id="cell-Lunes-13:00-14:00 31" class="schedule-cell border p-2" data-day="Lunes" data-hour="13:00 - 14:00"></div>
            <div id="cell-Martes-13:00-14:00 32" class="schedule-cell border p-2" data-day="Martes" data-hour="13:00 - 14:00"></div>
            <div id="cell-Miercoles-13:00-14:00 33" class="schedule-cell border p-2" data-day="Miercoles" data-hour="13:00 - 14:00"></div>
            <div id="cell-Jueves-13:00-14:00 34" class="schedule-cell border p-2" data-day="Jueves" data-hour="13:00 - 14:00"></div>
            <div id="cell-Viernes-13:00-14:00 35" class="schedule-cell border p-2" data-day="Viernes" data-hour="13:00 - 14:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">14:00 - 15:00</div>
            <div id="cell-Lunes-14:00-15:00 36" class="schedule-cell border p-2" data-day="Lunes" data-hour="14:00 - 15:00"></div>
            <div id="cell-Martes-14:00-15:00 37" class="schedule-cell border p-2" data-day="Martes" data-hour="14:00 - 15:00"></div>
            <div id="cell-Miercoles-14:00-15:00 38" class="schedule-cell border p-2" data-day="Miercoles" data-hour="14:00 - 15:00"></div>
            <div id="cell-Jueves-14:00-15:00 39" class="schedule-cell border p-2" data-day="Jueves" data-hour="14:00 - 15:00"></div>
            <div id="cell-Viernes-14:00-15:00 40" class="schedule-cell border p-2" data-day="Viernes" data-hour="14:00 - 15:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">15:00 - 16:00</div>
            <div id="cell-Lunes-15:00-16:00 41" class="schedule-cell border p-2" data-day="Lunes" data-hour="15:00 - 16:00"></div>
            <div id="cell-Martes-15:00-16:00 42" class="schedule-cell border p-2" data-day="Martes" data-hour="15:00 - 16:00"></div>
            <div id="cell-Miercoles-15:00-16:00 43" class="schedule-cell border p-2" data-day="Miercoles" data-hour="15:00 - 16:00"></div>
            <div id="cell-Jueves-15:00-16:00 44" class="schedule-cell border p-2" data-day="Jueves" data-hour="15:00 - 16:00"></div>
            <div id="cell-Viernes-15:00-16:00 45" class="schedule-cell border p-2" data-day="Viernes" data-hour="15:00 - 16:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">16:00 - 17:00</div>
            <div id="cell-Lunes-16:00-17:00 46" class="schedule-cell border p-2" data-day="Lunes" data-hour="16:00 - 17:00"></div>
            <div id="cell-Martes-16:00-17:00 47" class="schedule-cell border p-2" data-day="Martes" data-hour="16:00 - 17:00"></div>
            <div id="cell-Miercoles-16:00-17:00 48" class="schedule-cell border p-2" data-day="Miercoles" data-hour="16:00 - 17:00"></div>
            <div id="cell-Jueves-16:00-17:00 49" class="schedule-cell border p-2" data-day="Jueves" data-hour="16:00 - 17:00"></div>
            <div id="cell-Viernes-16:00-17:00 50" class="schedule-cell border p-2" data-day="Viernes" data-hour="16:00 - 17:00"></div>
        
            <div class="font-bold text-center sm:col-span-1 sm:block">17:00 - 18:00</div>
            <div id="cell-Lunes-17:00-18:00 51" class="schedule-cell border p-2" data-day="Lunes" data-hour="17:00 - 18:00"></div>
            <div id="cell-Martes-17:00-18:00 52" class="schedule-cell border p-2" data-day="Martes" data-hour="17:00 - 18:00"></div>
            <div id="cell-Miercoles-17:00-18:00 53" class="schedule-cell border p-2" data-day="Miercoles" data-hour="17:00 - 18:00"></div>
            <div id="cell-Jueves-17:00-18:00 54" class="schedule-cell border p-2" data-day="Jueves" data-hour="17:00 - 18:00"></div>
            <div id="cell-Viernes-17:00-18:00 55" class="schedule-cell border p-2" data-day="Viernes" data-hour="17:00 - 18:00"></div>
        </div>
        
        <div class="flex justify-end mt-6">
            <button id="registerButton" disabled class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" type="button">Registrar</button>
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
        // Ocultar el mensaje
        alert.style.display = 'none';
        
        // Eliminar la cookie 'success' después de ocultar el mensaje
        deleteCookie('success'); // Borrar cookie de éxito
        deleteCookie('error');
    }
}, 2000);
</script>

<script>
    const registerButton = document.getElementById('registerButton');
    const confirmModal = document.getElementById('confirmModal');
    const cancelButton = document.getElementById('cancelButton');
    const confirmButton = document.getElementById('confirmButton');
    
    
     // Lógica cuando se confirma el registro
     confirmButton.addEventListener('click', () => {
        // Aquí puedes proceder con el registro, por ejemplo, enviando el formulario
        document.getElementById('rolCrear').submit();
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



<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addButton').addEventListener('click', function() {
            // Valores de día y hora, que en este caso deben estar exactamente igual que los generados
            var selectElement1 = document.getElementById('example-select2').value;
            console.log(selectElement1);
            let diaSeleccionado;
            switch (selectElement1) {
                case '1':
                diaSeleccionado = "Lunes";
                    break;
                case '2':
                diaSeleccionado = "Martes";
                    break;
                case '3':
                diaSeleccionado = "Miercoles";
                    break;
                case '4':
                diaSeleccionado = "Jueves";
                    break;
                case '5':
                diaSeleccionado = "Viernes";
                    break;
                case '6':
                diaSeleccionado = "Sabado";
                    break;
                case '7':
                diaSeleccionado = "Domingo";
                    break;
                default:
                    console.error("Día no valido");
                    break;
            }


            var selectElement = document.getElementById('example-select3').value;
            let horaSeleccionada;

            switch (selectElement) {
                case '1':
                    horaSeleccionada = "07:00 - 08:00";
                    break;
                case '2':
                    horaSeleccionada = "08:00 - 09:00";
                    break;
                case '3':
                    horaSeleccionada = "09:00 - 10:00";
                    break;
                case '4':
                    horaSeleccionada = "10:00 - 11:00";
                    break;
                case '5':
                    horaSeleccionada = "11:00 - 12:00";
                    break;
                case '6':
                    horaSeleccionada = "12:00 - 13:00";
                    break;
                case '7':
                    horaSeleccionada = "13:00 - 14:00";
                    break;
                case '8':
                    horaSeleccionada = "14:00 - 15:00";
                    break;
                case '9':
                    horaSeleccionada = "15:00 - 16:00";
                    break;
                case '10':
                    horaSeleccionada = "16:00 - 17:00";
                    break;
                case '11':
                    horaSeleccionada = "17:00 - 18:00";
                    break;
                case '12':
                    horaSeleccionada = "18:00 - 19:00";
                    break;
                default:
                    console.error("Hora no válida seleccionada");
                    break;
            }

            // Muestra el rango de horas seleccionado
            console.log(horaSeleccionada);

            
            // Seleccionar la celda específica usando variables
            const cell = document.querySelector(`.schedule-cell[data-day="${diaSeleccionado}"][data-hour="${horaSeleccionada}"]`);
            const selectCurso = document.getElementById('example-select4');
            const cursoSeleccionado = selectCurso.selectedOptions[0].text
            const selectCursoValor = document.getElementById('example-select4').value;
            
            // Verificar si la celda fue encontrada y actualizar su contenido
            if (cell) {
            cell.innerHTML = `${cursoSeleccionado} <span class="remove-course" style="color: red; cursor: pointer;">&times;</span>`;
            cell.classList.add('bg-green-200'); 
            cell.classList.add(`curso-${selectCursoValor}`);


            cell.querySelector('.remove-course').addEventListener('click', function(event) {
                event.stopPropagation();
                cell.innerHTML = ''; // Limpiar el contenido de la celda
                cell.classList.remove('bg-green-200', `curso-${selectCursoValor}`); // Eliminar ambas clases
                console.log("Curso eliminado de la celda.");
            });

            console.log("Celda encontrada y actualizada.");

            
        } else {
            console.error("La celda no fue encontrada. Revisa los valores de data-day y data-hour.");
        }
        });
    });
</script>

<script>
    document.getElementById('registerButton').addEventListener('click', function() {
    const horarios = [];
    const cells = document.querySelectorAll('.schedule-cell');

    cells.forEach(cell => {
        const cursoClass = Array.from(cell.classList).find(clase => clase.startsWith('curso-'));
        const curso = cursoClass ? cursoClass.split('-')[1] : null; 
        
        // Día de la semana (idDiaSemana) según el atributo `data-day` de la celda
        let idDiaSemana;
        switch (cell.getAttribute('data-day')) {
            case 'Lunes':
                idDiaSemana = 1;
                break;
            case 'Martes':
                idDiaSemana = 2;
                break;
            case 'Miercoles':
                idDiaSemana = 3;
                break;
            case 'Jueves':
                idDiaSemana = 4;
                break;
            case 'Viernes':
                idDiaSemana = 5;
                break;
            case 'Sabado':
                idDiaSemana = 6;
                break;
            case 'Domingo':
                idDiaSemana = 7;
                break;
            default:
                console.error("Día no válido");
                return;
        }

        // Hora (idHora) según el atributo `data-hour` de la celda
        let idHora;
        switch (cell.getAttribute('data-hour')) {
            case '07:00 - 08:00':
                idHora = 1;
                break;
            case '08:00 - 09:00':
                idHora = 2;
                break;
            case '09:00 - 10:00':
                idHora = 3;
                break;
            case '10:00 - 11:00':
                idHora = 4;
                break;
            case '11:00 - 12:00':
                idHora = 5;
                break;
            case '12:00 - 13:00':
                idHora = 6;
                break;
            case '13:00 - 14:00':
                idHora = 7;
                break;
            case '14:00 - 15:00':
                idHora = 8;
                break;
            case '15:00 - 16:00':
                idHora = 9;
                break;
            case '16:00 - 17:00':
                idHora = 10;
                break;
            case '17:00 - 18:00':
                idHora = 11;
                break;
            case '18:00 - 19:00':
                idHora = 12;
                break;
            default:
                console.error("Hora no válida seleccionada");
                return;
        }


        let id_grado = document.getElementById('example-select1').value;
        // Crear el objeto horario con los IDs y el curso
        horarios.push({
            acu_id: curso || null,   // `curso` si existe, si no, `null`
            idDiaSemana: idDiaSemana, 
            idHora: idHora, 
            id_grado: id_grado              // Este es el ID de grado, asignado según tu lógica
        });
    });

    // Imprime los datos en la consola para verificar
    console.log(JSON.stringify({ horarios }, null, 2));
    document.getElementById('horarios-json').value = JSON.stringify(horarios);

    // Enviar el formulario
    document.getElementById('scheduleForm').submit();

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

<script>
    $(document).ready(function() {
    // Al cambiar el grado seleccionado
    $('#example-select1').change(function() {
        document.getElementById('registerButton').removeAttribute('disabled');
        document.getElementById('addButton').removeAttribute('disabled');

        // Limpiar las celdas del horario
        $('#scheduleGrid .schedule-cell').each(function() {
            $(this).empty(); // Esto vacía el contenido de cada celda
        });
    });
});

</script>

@endsection
