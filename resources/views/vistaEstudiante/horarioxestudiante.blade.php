@extends('dashboard')

@section('content')

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Horario de Cursos</h2>
    @if($gradoAlumno == 'vacio')
    <p class="text-gray-500">No hay cursos registrados. No esta registrado en un grado</p>
    @else

    <form id="roledit" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1">
            <div class="container mx-auto p-6">
                <div class="bg-gray-200 p-4 mb-6 rounded-md">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Información del Estudiante</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Grado: <strong>{{ $gradoAlumno->grado }}</strong></p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Nivel: <strong>{{ $gradoAlumno->nivelNombre }}</strong></p>
                    {{-- <p class="text-sm text-gray-600 dark:text-gray-400">Sección: <strong>{{ $gradoAlumno->seccion }}</strong></p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Aula: <strong>{{ $gradoAlumno->aula }}</strong></p> --}}
                </div>

                <div class="overflow-x-auto">
                    <!-- Tabla de Cursos y Horarios -->
                    <table class="min-w-full border border-gray-300 rounded-lg shadow-lg bg-white">
                        <thead class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                            <tr>
                                <th class="p-4 border-r border-gray-300 text-center font-semibold text-lg">Hora / Día</th>
                                @foreach($horarios->groupBy('idDiaSemana') as $diaSemana => $horariosDia)
                                    <th class="p-4 border-r border-gray-300 text-center font-semibold text-lg">{{ $horariosDia->first()->diaSemana->nombreDia }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($horarios->groupBy('idHora') as $hora => $horariosHora)
                                <tr class="hover:bg-gray-50 transition-colors duration-300">
                                    <td class="p-4 border-t border-r border-gray-300 text-center font-medium text-lg bg-gray-100">{{ $horariosHora->first()->hora->nombreHora }}</td>
                                    @foreach($horarios->groupBy('idDiaSemana') as $diaSemana => $horariosDia)
                                        <td class="p-4 border-t border-r border-gray-300 text-center bg-white">
                                            @foreach($horariosHora->where('idDiaSemana', $diaSemana) as $horario)
                                                <div class="text-sm
                                                    @if(empty($horario->curso) || empty($horario->curso->acu_nombre))
                                                        bg-gray-700 px-2 py-1 rounded-md 
                                                    @else
                                                        bg-transparent 
                                                    @endif">
                                                    {{ $horario->curso ? $horario->curso->acu_nombre : 'Sin Curso' }}
                                                </div>
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

           
        </div>
    </form>

    <!-- Modal de Confirmación -->
    <div id="confirmModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div x-data="{ isOpen: false }" class="relative flex justify-center">
            <div x-show="isOpen" x-transition:enter="transition duration-300 ease-out"
                x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave="transition duration-150 ease-in"
                x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl rtl:text-right dark:bg-gray-900 sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div class="mt-2 text-center">
                            <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white" id="modal-title">Confirmar Actualización</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">¿Estás seguro de que deseas editar esta información?</p>
                        </div>
                        <div class="mt-5 sm:flex sm:items-center sm:justify-between">
                            <button id="cancelButton" class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:mt-0 sm:w-auto sm:mx-2 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">Cancelar</button>
                            <button id="confirmButton" class="w-full px-4 py-2 mt-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md sm:w-auto sm:mt-0 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">Confirmar Actualización</button>
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

    // Lógica para mostrar el modal
    registerButton.addEventListener('click', () => {
        confirmModal.classList.remove('hidden');
    });

    // Lógica para cancelar la acción
    cancelButton.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
    });

    // Lógica cuando se confirma el edit
    confirmButton.addEventListener('click', () => {
        document.getElementById('roledit').submit();
    });
</script>
@endif
@endsection
