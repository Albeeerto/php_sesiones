<?php
// contenido_privado.php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirigir al formulario de login
    header('Location: formulario_login.php');
    exit();
}

// Mostrar contenido privado
echo "Bienvenido, " . $_SESSION['usuario'] . "! Este es tu contenido privado.";
?>
