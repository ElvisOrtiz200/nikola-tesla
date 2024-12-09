@extends('usuario.index')



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
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Registrar usuario</h2>

    <form id="rolCrear" action="{{route('register')}}" method="POST" >
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="correo">Correo</label>
                <input id="correo" name="correo" type="email" 
                       class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                       required>
                <div id="errorCorreo" class="text-red-500 hidden mt-2"></div>
            </div>

            <div class="flex justify-center space-x-8 mb-6">
                <label for="estudiante" class="inline-flex items-center">
                    <input type="radio" id="estudiante" name="user_type" value="estudiante" checked class="text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">Estudiante</span>
                </label>
                <label for="personal" class="inline-flex items-center">
                    <input type="radio" id="personal" name="user_type" value="personal" class="text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">Personal</span>
                </label>
            </div>
        
                <!-- Combo de ID Personal -->
            <div id="personal_id" class="mb-6">
                <label for="per_id" class="block text-lg font-semibold text-gray-700">ID Personal</label>
                <select id="per_id" name="per_id" class="select2 block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                   
                    @foreach ($rrhh as $person)
                        <option value="{{ $person->per_id }}" {{ old('per_id') == $person->per_id ? 'selected' : '' }}>
                            {{ $person->per_dni }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Combo de DNI Estudiante -->
            <div id="estudiante_dni" class="mb-6">
                <label for="alu_dni" class="block text-lg font-semibold text-gray-700">DNI Estudiante</label>
                <select id="alu_dni" name="alu_dni" class="select2 block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                   
                    @foreach ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->alu_dni }}" {{ old('alu_dni') == $estudiante->alu_dni ? 'selected' : '' }}>
                            {{ $estudiante->alu_dni }}
                        </option>
                    @endforeach
                </select>
            </div>

            


            <div>
                <label class="text-gray-700 dark:text-gray-200" for="usu_login">Nombre de usuario</label>
                <input id="usu_login" name="usu_login" type="text" 
                       class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                       pattern="^[A-Za-z0-9_.-]+$"
                       title="El nombre de usuario solo puede contener letras, números, guiones bajos y puntos."
                       required>
                <div id="errorUsuario" class="text-red-500 hidden mt-2"></div>
            </div>

            <div>
                <label class="text-gray-700 dark:text-gray-200" for="password">Contraseña</label>
                <input id="password" name="password" type="password" 
                       class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                <div id="errorPassword" class="text-red-500 hidden mt-2"></div>
            </div>
            <div>
                    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Asignar rol</h2>

                <div class="max-w-xs mx-auto mt-4">
        
                    <select
                        class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        id="selectOption"
                        name="idrol"
                    >
                    @foreach ($roles as $itemdoroles)
                    <option value="{{ $itemdoroles->idrol}}">{{ $itemdoroles->nombre_rol }} </option>
                @endforeach
                
                    
                    </select>
                </div>
            </div>
          
            
            


        </div>

        <div class="flex justify-end mt-6">
            <button id="registerButton" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600" type="button">Registrar</button>
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
        alert.style.display = 'none';
        deleteCookie('success'); // Borrar cookie de éxito
        deleteCookie('error');   // Borrar cookie de error
    }
}, 3000);
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


     // Lógica cuando se confirma el registro
    confirmButton.addEventListener('click', () => {
        // Aquí puedes proceder con el registro, por ejemplo, enviando el formulario
        document.getElementById('rolCrear').submit();
    });

    // Mostrar el modal cuando se hace clic en "Registrar"
   

    // Ocultar el modal cuando se hace clic en "Cancelar"
    cancelButton.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
    });

</script>

<script>
    function validarFormulario() {
    var correo = document.getElementById('correo').value;
    var usuario = document.getElementById('usu_login').value;
    var password = document.getElementById('password').value;

    var errorCorreo = document.getElementById('errorCorreo');
    var errorUsuario = document.getElementById('errorUsuario');
    var errorPassword = document.getElementById('errorPassword');

    // Limpiar los mensajes de error antes de realizar nuevas validaciones
    errorCorreo.textContent = '';
    errorUsuario.textContent = '';
    errorPassword.textContent = '';

    errorCorreo.classList.add('hidden');
    errorUsuario.classList.add('hidden');
    errorPassword.classList.add('hidden');

    // Validación del correo
    var regexCorreo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!correo) {
        errorCorreo.textContent = "El correo es obligatorio.";
        errorCorreo.classList.remove('hidden');
        return false;
    } else if (!regexCorreo.test(correo)) {
        errorCorreo.textContent = "Por favor ingrese un correo electrónico válido.";
        errorCorreo.classList.remove('hidden');
        return false;
    }

    // Validación del nombre de usuario (solo letras, números, guiones bajos y puntos)
    var regexUsuario = /^[A-Za-z0-9_.-]+$/;
    if (!regexUsuario.test(usuario)) {
        errorUsuario.textContent = "El nombre de usuario solo puede contener letras, números, guiones bajos y puntos.";
        errorUsuario.classList.remove('hidden');
        return false;
    }

    // Validación de la contraseña (al menos 8 caracteres)
    if (password.length < 8) {
        errorPassword.textContent = "La contraseña debe tener al menos 8 caracteres.";
        errorPassword.classList.remove('hidden');
        return false;
    }

    return true; // Si todo es válido, el formulario se enviará
}

</script>


<script>
    const estudianteRadio = document.getElementById('estudiante');
    const personalRadio = document.getElementById('personal');
    const personalIdField = document.getElementById('personal_id');
    const estudianteDniField = document.getElementById('estudiante_dni');

    function toggleFields() {
        if (estudianteRadio.checked) {
            personalIdField.classList.add('hidden');
            estudianteDniField.classList.remove('hidden');
        } else if (personalRadio.checked) {
            estudianteDniField.classList.add('hidden');
            personalIdField.classList.remove('hidden');
        }
    }

    estudianteRadio.addEventListener('change', toggleFields);
    personalRadio.addEventListener('change', toggleFields);
    toggleFields(); // Inicializa los campos según la selección predeterminada
</script>

<script>
    // Inicializa Select2 en todos los elementos con la clase 'select2'
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Seleccione una opción", // Texto inicial
            allowClear: true, // Agrega la opción para limpiar la selección
            width: 'resolve' // Ajusta el ancho
        });
    });
</script>

@endsection
