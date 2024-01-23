<?php
// Procesar el formulario de registro

// Validar y sanitizar datos
$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
$contrasena = $_POST['contrasena'];

// Encriptar la contraseña
$contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

// Subir imagen y obtener la ruta
$imagen_ruta = "uploads/" . $_FILES['imagen']['name'];
move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_ruta);

// Insertar datos en la base de datos
$conexion = new mysqli("localhost", "root", "", "cookies");
$query = "INSERT INTO usuarios (correo, contrasena, imagen_perfil) VALUES ('$correo', '$contrasena_encriptada', '$imagen_ruta')";
$conexion->query($query);

// Establecer una cookie (puedes ajustar la expiración según tus necesidades)
setcookie('usuario', $correo, time() + 3600, '/');

// Redirigir al formulario de login
header('Location: formulario_login.php');
?>
