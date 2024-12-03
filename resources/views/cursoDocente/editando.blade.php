@extends('cursoDocente.index')

@section('subcontent')

<section class="max-w-4xl p-6 mx-auto bg-white rounded-md drop-shadow-2xl dark:bg-gray-800">
    <h2 class="text-xl font-bold text-gray-800 capitalize dark:text-white mb-6">
        Editar docente a curso
    </h2>
    {{-- {{ route('curso-docente.update', $cursoDocente->acdo_id) }} --}}
    <!-- Formulario de edición -->
    <form action="{{ route('cursodocente.update', $cursoDocente->acdo_id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Campo: Grado -->
        <div>
            <label for="example-select1" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                Selecciona un grado
            </label>
            <select id="example-select1" name="id_grado" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                <option value="">Selecciona un grado</option>
                @foreach ($grados as $itemgrado)
                    <option value="{{ $itemgrado->id_grado }}" {{ $cursoDocente->id_grado == $itemgrado->id_grado ? 'selected' : '' }}>
                        {{ $itemgrado->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Campo: Curso -->
        <div>
            <label for="example-select4" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                Selecciona un curso
            </label>
            <select id="example-select4" name="acu_id" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                <option value="">Selecciona un curso</option>
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->acu_id }}" {{ $cursoDocente->acu_id == $curso->acu_id ? 'selected' : '' }}>
                        {{ $curso->acu_nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Campo: Docente -->
        <div>
            <label for="selectOption" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                Seleccionar docente
            </label>
            <select id="selectOption" name="per_id" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                @foreach ($docentes as $itemdocentes)
                    <option value="{{ $itemdocentes->per_id }}" {{ $cursoDocente->per_id == $itemdocentes->per_id ? 'selected' : '' }}>
                        {{ $itemdocentes->personal->per_apellidos }} - {{ $itemdocentes->personal->per_nombres }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Fecha de inicio y fin -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="datepicker-range-start" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Fecha de inicio
                </label>
                <input id="datepicker-range-start" name="acdo_fecha_ini" type="date" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300" value="{{ $cursoDocente->acdo_fecha_ini }}">
            </div>
            <div>
                <label for="datepicker-range-end" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Fecha fin
                </label>
                <input id="datepicker-range-end" name="acdo_fecha_fin" type="date" class="block w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300" value="{{ $cursoDocente->acdo_fecha_fin }}">
            </div>
        </div>

        <!-- Botón de guardar -->
        <div class="flex justify-end">
            <a href="{{route('curso-docente.show')}}" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" >Regresar</a>
            <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                Guardar cambios
            </button>
        </div>
    </form>
</section>

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
