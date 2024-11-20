<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form class="form" action="{{ route('login') }}" method="POST">
            @csrf
            <p class="heading">Login</p>
            <input class="input" id="usu_login" name="usu_login" placeholder="Nombre de usuario" type="text">
            <input class="input" type="password" id="password" name="password" placeholder="Contraseña" type="text"> 
            <button class="btn" type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>








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