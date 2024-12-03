@extends('horario.index')

@section('subcontent')

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar Horario</h2>

    <!-- Formulario de Edición -->
    <form id="horarioForm" action="{{ route('horario.update', $horarios->first()->id_grado) }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="flex flex-col space-y-4">
            <!-- Campo de Grado (Solo Lectura) -->
            <div class="w-full max-w-xs">
                <label for="grado" class="block text-sm font-medium text-gray-700 mb-2">Selecciona un grado:</label>
                <input type="text" id="grado" name="grado" value="{{ $horarios->first()->grado->nombre }} {{ $horarios->first()->grado->nivel->nombre }}" 
                    class="block w-full bg-gray-100 border border-gray-300 rounded-lg shadow-sm text-gray-700 p-3 transition duration-200 ease-in-out" disabled>
                <input type="hidden" name="id_grado" value="{{ $horarios->first()->id_grado }}">
            </div>

            <!-- Selección de Día de la Semana -->
            <div class="w-full max-w-xs">
                <label for="example-select2" class="block text-sm font-medium text-gray-700 mb-2">Selecciona un día de la semana:</label>
                <select id="example-select2" name="idDiaSemana" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 p-3 transition duration-200 ease-in-out">
                    @foreach ($diaSemana as $itemdiaSemana)
                        <option value="{{$itemdiaSemana->idDiaSemana}}">{{$itemdiaSemana->nombreDia}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Selección de Hora -->
            <div class="w-full max-w-xs">
                <label for="example-select3" class="block text-sm font-medium text-gray-700 mb-2">Selecciona una hora:</label>
                <select id="example-select3" name="idHora" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 p-3 transition duration-200 ease-in-out">
                    @foreach ($horas as $itemhora)
                        <option value="{{$itemhora->idHora}}">{{$itemhora->nombreHora}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Selección de Curso -->
            <div class="w-full max-w-xs">
                <label for="example-select4" class="block text-sm font-medium text-gray-700 mb-2">Selecciona un curso:</label>
                <select id="example-select4" name="idCurso" class="block w-full bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 p-3 transition duration-200 ease-in-out">
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso->acu_id }}" 
                            {{ $horarios->first()->id_curso == $curso->acu_id ? 'selected' : '' }}>
                            {{ $curso->acu_nombre }}
                        </option>
                    @endforeach
                </select>  
            </div>
        </div>

        <!-- Botón para agregar el curso -->
<div class="flex justify-end mt-6">
    <button type="button" id="addCourseButton" class="px-8 py-2.5 text-white bg-green-500 rounded-md hover:bg-green-400">Agregar Curso</button>
</div>

<div id="hiddenInputs"></div>
<button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Guardar Cambios</button>

        <!-- Botón de Actualización -->
        {{-- <div class="flex justify-end mt-6">
            <button type="submit" class="px-8 py-2.5 text-white bg-gray-700 rounded-md hover:bg-gray-600">Actualizar</button>
        </div> --}}
    </form>
</section>

<!-- Visualización del Horario -->
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Horario de Cursos</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg bg-white">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-4 border-b text-center font-semibold text-lg">Hora / Día</th>
                    @foreach($horarios->groupBy('idDiaSemana') as $diaSemana => $horariosDia)
                        <th class="p-4 border-b text-center font-semibold text-lg">{{ $horariosDia->first()->diaSemana->nombreDia }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($horarios->groupBy('idHora') as $hora => $horariosHora)
                    <tr class="border-b">
                        <td class="p-4 text-center font-medium text-lg bg-gray-50">{{ $horariosHora->first()->hora->nombreHora }}</td>
                        @foreach($horarios->groupBy('idDiaSemana') as $diaSemana => $horariosDia)
                            <td class="p-4 text-center bg-white">
                                @foreach($horariosHora->where('idDiaSemana', $diaSemana) as $horario)
                                    <div class="schedule-cell text-sm cursor-pointer @if(!empty($horario->curso)) bg-gray-200 px-2 py-1 rounded-md @endif"
                                         data-day="{{ $horario->diaSemana->nombreDia }}"
                                         data-hour="{{ $horario->hora->nombreHora }}">
                                        @if(!empty($horario->curso)) 
                                            {{ $horario->curso->acu_nombre }} 
                                            <span class="remove-course text-red-600 cursor-pointer ml-2">&times;</span>
                                        @endif
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

<!-- Modal de Confirmación para Actualizar -->
<div id="confirmModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center ">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h3 class="text-lg font-semibold text-gray-700">Confirmar actualización</h3>
        <p class="text-sm text-gray-600">¿Estás seguro de que deseas actualizar este horario?</p>
        <div class="mt-4 flex justify-end">
            <button id="cancelButton" class="px-4 py-2 mr-4 text-gray-700 border border-gray-300 rounded-md">Cancelar</button>
            <button id="confirmButton" class="px-4 py-2 text-white bg-blue-500 rounded-md">Confirmar</button>
        </div>
    </div>
</div>


<script>
    // Función para agregar el curso a la celda
    function agregarCurso(cell, cursoSeleccionado, cursoValor) {
        // Si la celda está vacía, agregar el curso
        if (cell.innerHTML.trim() === '') {
            // Agregar curso con "X" para eliminar
            cell.innerHTML = `${cursoSeleccionado} <span class="remove-course text-red-600 cursor-pointer ml-2">&times;</span>`;
            cell.classList.add('bg-green-200');
            cell.classList.add(`curso-${cursoValor}`);

            // Agregar el evento de eliminación en la "X"
            const removeButton = cell.querySelector('.remove-course');
            removeButton.addEventListener('click', function(event) {
                event.stopPropagation(); // Evitar que el clic se propague al contenedor de la celda
                cell.innerHTML = ''; // Limpiar el contenido de la celda
                cell.classList.remove('bg-green-200', `curso-${cursoValor}`); // Remover clases de estilo
                console.log("Curso eliminado de la celda.");
            });
        }
    }

    // Evento para agregar el curso
    document.getElementById('addCourseButton').addEventListener('click', function() {
        const selectDia = document.getElementById('example-select2');
        const selectHora = document.getElementById('example-select3');
        const selectCurso = document.getElementById('example-select4');

        const diaSeleccionado = selectDia.value;
        const horaSeleccionada = selectHora.value;
        const cursoSeleccionado = selectCurso.selectedOptions[0].text;
        const cursoValor = selectCurso.value;

        // Encontrar la celda correspondiente en la tabla
        const celdas = document.querySelectorAll('.schedule-cell');
        celdas.forEach(cell => {
            // Verificar si la celda corresponde al día y hora seleccionados
            if (cell.dataset.day === selectDia.selectedOptions[0].text &&
                cell.dataset.hour === selectHora.selectedOptions[0].text) {
                
                // Agregar el curso a la celda
                agregarCurso(cell, cursoSeleccionado, cursoValor);
            }
        });
    });

    // Agregar el evento a los elementos de "remove-course" directamente
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.remove-course').forEach(removeButton => {
            removeButton.addEventListener('click', function(event) {
                const cell = removeButton.closest('.schedule-cell');
                event.stopPropagation(); // Evitar que el clic se propague al contenedor de la celda
                cell.innerHTML = ''; // Limpiar el contenido de la celda
                cell.classList.remove('bg-green-200'); // Remover las clases de estilo
                console.log("Curso eliminado desde el span.");
            });
        });
    });
</script>



<script>document.getElementById('horarioForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Evita que se recargue la página

    // Limpia los inputs ocultos previos
    const hiddenInputs = document.getElementById('hiddenInputs');
    hiddenInputs.innerHTML = '';

    // Recorrer todas las celdas con la clase 'schedule-cell'
    document.querySelectorAll('.schedule-cell').forEach(cell => {
        const day = cell.dataset.day; // Día de la celda
        const hour = cell.dataset.hour; // Hora de la celda
        const course = cell.innerText.replace('×', '').trim(); // Curso de la celda

        // Solo agrega datos si hay un curso en la celda
        if (course) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'horarios[]'; // Se envía como array
            input.value = JSON.stringify({ day, hour, course }); // Serializa los datos
            hiddenInputs.appendChild(input);
        }
    });

    console.log('Datos recopilados:', hiddenInputs.innerHTML);

    // Enviar el formulario
    this.submit();
});
</script>


@endsection
