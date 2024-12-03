@extends('asignarStuCurso.index')

@section('subcontent')

@if (request()->cookie('success'))
<div id="alert" class="fixed top-4 right-4 z-50 w-full max-w-sm overflow-hidden bg-emerald-500 text-white rounded-lg shadow-md">
    <div class="flex items-center p-4">
        <svg class="w-6 h-6 text-white mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 12l2 2l4-4M4 12h16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p class="font-semibold">¡Éxito!</p>
        <p class="ml-2">{{ request()->cookie('success') }}</p>
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
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Registrar Estudiantes en grado</h2>

    <form id="rolCrear" action="{{route('estudiante-curso.store')}}" method="POST">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div class="w-full max-w-xs">
                    <label for="example-select" class="block text-sm font-medium text-gray-700 mb-2">Selecciona una opción:</label>
                    <select id="example-select" name="id_grado" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 hover:bg-blue-50 text-gray-700 p-3 transition duration-200 ease-in-out">
                        @foreach ($grado as $itemgrado)
                            <option value="{{$itemgrado->id_grado}}">{{$itemgrado->grado}} {{$itemgrado->nivel}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full max-w-xs">
                    <label for="example-select" class="block text-sm font-medium text-gray-700 mb-2">Selecciona bimestre:</label>
                    <select id="example-select" name="bim_sigla" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 hover:bg-blue-50 text-gray-700 p-3 transition duration-200 ease-in-out">
                        @foreach ($bimestre as $itembimestre)
                            <option value="{{$itembimestre->bim_sigla}}">{{$itembimestre->bim_sigla}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="container mx-auto p-4">
                <!-- Search bar -->
                <div class="mb-4">
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Buscar estudiante por DNI, apellidos o nombres..." 
                        class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 text-gray-700 transition duration-200 ease-in-out"
                    >
                </div>

                <!-- Tabla de estudiantes -->
                <div class="h-40 overflow-y-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md" id="studentTable">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Seleccionar</th>
                                <th class="py-3 px-4 text-left">DNI</th>
                                <th class="py-3 px-4 text-left">APELLIDOS</th>
                                <th class="py-3 px-4 text-left">NOMBRES</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($estudiantes as $itemestudiantes)
                                <tr class="border-b hover:bg-blue-50">
                                    <td class="py-3 px-4 text-center">
                                        <input 
                                            type="checkbox" 
                                            name="estudiantes[]" 
                                            value="{{$itemestudiantes->alu_dni}}" 
                                            class="rounded hover:bg-blue-100 focus:ring-2 focus:ring-blue-300" 
                                            onchange="updateSelectedStudents()"
                                        >
                                    </td>
                                    <td class="py-3 px-4">{{$itemestudiantes->alu_dni}}</td>
                                    <td class="py-3 px-4">{{$itemestudiantes->alu_apellidos}}</td>
                                    <td class="py-3 px-4">{{$itemestudiantes->alu_nombres}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detalle de estudiantes seleccionados -->
        <div id="selected-students" class="mt-6">
            <h3 class="text-lg font-semibold text-gray-700">Estudiantes seleccionados:</h3>
            <ul id="student-list" class="list-disc pl-5 mt-2 text-gray-600">
                <!-- Estudiantes seleccionados aparecerán aquí -->
            </ul>
        </div>

        <div class="flex justify-end mt-6">
            <button id="registerButton" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" type="button">Registrar</button>
        </div>
        
    </form>
</section>

<div id="confirmModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="relative flex justify-center">
        <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl rtl:text-right dark:bg-gray-900 sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
            <div>
                <div class="flex items-center justify-center">
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
            <div class="mt-5 sm:flex sm:items-center sm:justify-between">
                <button id="cancelButton" class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:mt-0 sm:w-auto sm:mx-2 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                    Cancelar
                </button>
                <button id="confirmButton" class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md sm:w-auto sm:mt-0 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                    Confirmar Registro
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Mensaje de éxito
    function deleteCookie(name) {
        document.cookie = name + '=; Max-Age=0; path=/; domain=' + window.location.hostname + ';';
    }
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) {
            alert.style.display = 'none';
            deleteCookie('success');
            deleteCookie('error');
        }
    }, 3000);

    // Modal de confirmación
    const registerButton = document.getElementById('registerButton');
    const confirmModal = document.getElementById('confirmModal');
    const cancelButton = document.getElementById('cancelButton');
    const confirmButton = document.getElementById('confirmButton');
    
    registerButton.addEventListener('click', function () {
        confirmModal.classList.remove('hidden');    
    });

    confirmButton.addEventListener('click', () => {
        const form = document.getElementById('rolCrear');
        form.submit();
    });

    cancelButton.addEventListener('click', function () {
        confirmModal.classList.add('hidden');
    });

    // Actualizar lista de estudiantes seleccionados
    function updateSelectedStudents() {
        const checkboxes = document.querySelectorAll('input[name="estudiantes[]"]:checked');
        const studentList = document.getElementById('student-list');
        studentList.innerHTML = '';

        checkboxes.forEach(checkbox => {
            const tr = checkbox.closest('tr');
            const nombre = tr.querySelector('td:nth-child(4)').textContent;
            const apellido = tr.querySelector('td:nth-child(3)').textContent;
            const li = document.createElement('li');
            li.textContent = `${apellido} ${nombre}`;
            studentList.appendChild(li);
        });
    }

    // Filtrar estudiantes dinámicamente
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#studentTable tbody tr');

        rows.forEach(row => {
            const dni = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const apellidos = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const nombres = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            // Mostrar fila si coincide con el filtro
            if (dni.includes(filter) || apellidos.includes(filter) || nombres.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection
