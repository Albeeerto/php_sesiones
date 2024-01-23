<!-- formulario_login.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
<h2>Inicio de Sesión</h2>

<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            exit();
        } else {
            // Contraseña incorrecta
            echo '<p style="color: red;">Contraseña incorrecta. Inténtalo de nuevo.</p>';
        }
    } else {
        // Usuario no encontrado
        echo '<p style="color: red;">Usuario no encontrado. Inténtalo de nuevo.</p>';
    }
}
?>

<form action="procesar_login.php" method="post">
    Correo: <input type="email" name="correo" required><br>
    Contraseña: <input type="password" name="contrasena" required><br>
    <input type="submit" value="Iniciar Sesión">
</form>
</body>
</html>
