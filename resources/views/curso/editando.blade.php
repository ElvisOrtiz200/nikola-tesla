@extends('apoderado.index')

@section('subcontent') 



<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Editar Curso</h2>

    <form id="editCourseForm" action="{{ route('curso.update', $curso->acu_id) }}" method="POST" onsubmit="return validarFormulario()">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-gray-700 dark:text-gray-200">Nombre del Curso</label>
                <input id="acu_nombre" name="acu_nombre" value="{{ $curso->acu_nombre }}" type="text" 
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border border-gray-200 rounded-md 
                    dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                    focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorNombre" class="text-red-500 text-sm hidden mt-1"></div>
            </div>

            <div>
                <label class="text-gray-700 dark:text-gray-200">Grado</label>
                <select id="id_grado" name="id_grado" 
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border border-gray-200 rounded-md 
                    dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 
                    focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                    <option value="" disabled>Seleccione un grado</option>
                    @foreach($grados as $grado)
                        <option value="{{ $grado->id_grado }}" 
                            {{ $curso->id_grado == $grado->id_grado ? 'selected' : '' }}>
                            {{ $grado->nombre }}
                        </option>
                    @endforeach
                </select>
                <div id="errorGrado" class="text-red-500 text-sm hidden mt-1"></div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-blue-600 
                rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                Guardar Cambios
            </button>
        </div>
    </form>
</section>

<script>
    function validarFormulario() {
        let valid = true;

        // Limpiar errores
        document.getElementById('errorNombre').classList.add('hidden');
        document.getElementById('errorGrado').classList.add('hidden');

        // Validar nombre del curso
        const nombre = document.getElementById('acu_nombre').value.trim();
        if (!nombre) {
            document.getElementById('errorNombre').textContent = "El nombre del curso es obligatorio.";
            document.getElementById('errorNombre').classList.remove('hidden');
            valid = false;
        }

        // Validar grado seleccionado
        const grado = document.getElementById('id_grado').value;
        if (!grado) {
            document.getElementById('errorGrado').textContent = "Debe seleccionar un grado.";
            document.getElementById('errorGrado').classList.remove('hidden');
            valid = false;
        }

        return valid;
    }
</script>



@endsection