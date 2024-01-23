<?php
// Procesar el formulario de login

// Validar y sanitizar datos
$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
$contrasena = $_POST['contrasena'];

// Obtener datos del usuario de la base de datos
$conexion = new mysqli("localhost", "root", "", "cookies");
$query = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    $datos_usuario = $resultado->fetch_assoc();

    // Verificar la contraseña
    if (password_verify($contrasena, $datos_usuario['contrasena'])) {
        // Iniciar sesión
        session_start();

        // Crear un identificador único para la sesión (puedes ajustar según tus necesidades)
        $sesion_id = uniqid();

        // Almacenar el correo y el identificador de sesión en la variable de sesión
        $_SESSION['usuario'] = $datos_usuario['correo'];
        $_SESSION['sesion_id'] = $sesion_id;

        // Redirigir al contenido privado
        header('Location: contenido_privado.php');
    } else {
        // Contraseña incorrecta, redirigir al formulario de login con un mensaje de error
        header('Location: formulario_login.php?error=contrasena');
    }
} else {
    // Usuario no encontrado, redirigir al formulario de login con un mensaje de error
    header('Location: formulario_login.php?error=usuario');
}
?>
