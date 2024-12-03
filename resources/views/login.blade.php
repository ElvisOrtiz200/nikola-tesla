<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="container">
    @if (request()->cookie('error'))
    <div id="alert" class="fixed top-4 right-4 z-50 flex w-full max-w-sm overflow-hidden bg-red-600 rounded-lg shadow-md dark:bg-red-700" style="display: flex;">
        <div class="flex items-center justify-center w-12 bg-red-700">
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
    <form class="form" action="{{ route('login') }}" method="POST">
        @csrf
        <p class="heading">Nikola Tesla</p>
        <input class="input" id="usu_login" name="usu_login" placeholder="Nombre de usuario" type="text" required>
        <input class="input" type="password" id="password" name="password" placeholder="Contraseña" required> 
        <button class="btn" type="submit">Iniciar sesión</button>
    </form>
</div>

</body>
</html>

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






{{-- <form action="{{ route('login') }}" method="POST">
    @csrf
    <div>
        <label for="usu_login">usu_login</label>
        <input type="text" id="usu_login" name="usu_login">
    </div>
    <div>
        <label class="" for="password">Contraseña</label>
        <input type="password" id="password" name="password">
    </div>
    <button type="submit">Iniciar sesión</button>
</form> --}}


<style>
body {
    margin: 0;
    height: 100vh; /* Hace que el body ocupe toda la altura de la ventana */
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center; /* Centra verticalmente */
    background-color: #161C34; /* Color de fondo (opcional) */
}

.container {
     /* Fondo blanco para el formulario */
    padding: 20px;
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra para dar profundidad */
}

.form {
  display: flex;
  flex-direction: column;
  gap: 10px;
  background-color: white;
  padding: 2.5em;
  border-radius: 25px;
  transition: .4s ease-in-out;
  box-shadow: rgba(0, 0, 0, 0.4) 1px 2px 2px;
}

.form:hover {
  transform: translateX(-0.5em) translateY(-0.5em);
  border: 1px solid #171717;
  box-shadow: 10px 10px 0px #666666;
}

.heading {
  color: black;
  padding-bottom: 2em;
  text-align: center;
  font-weight: bold;
}

.input {
  border-radius: 5px;
  border: 1px solid whitesmoke;
  background-color: whitesmoke;
  outline: none;
  padding: 0.7em;
  transition: .4s ease-in-out;
}

.input:hover {
  box-shadow: 6px 6px 0px #969696,
             -3px -3px 10px #ffffff;
}

.input:focus {
  background: #ffffff;
  box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
}

.form .btn {
  margin-top: 2em;
  align-self: center;
  padding: 0.7em;
  padding-left: 1em;
  padding-right: 1em;
  border-radius: 10px;
  border: none;
  color: black;
  transition: .4s ease-in-out;
  box-shadow: rgba(0, 0, 0, 0.4) 1px 1px 1px;
}

.form .btn:hover {
  box-shadow: 6px 6px 0px #969696,
             -3px -3px 10px #ffffff;
  transform: translateX(-0.5em) translateY(-0.5em);
}

.form .btn:active {
  transition: .2s;
  transform: translateX(0em) translateY(0em);
  box-shadow: none;
}
</style>