<?php
session_start(); // Inicia sesión para acceder a sus datos
$_SESSION = []; // Vacía todas las variables de sesión

// Verifica si las cookies están habilitadas
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params(); // Obtiene parámetros de la cookie
    
    // Elimina la cookie del navegador con fecha expirada
    setcookie(
        session_name(),        // Nombre de la cookie (PHPSESSID)
        '',                    // Valor vacío
        time() - 42000,        // Fecha pasada para que expire
        $params['path'],       // Ruta de la cookie
        $params['domain'],     // Dominio válido
        $params['secure'],     // Solo HTTPS si es true
        $params['httponly']    // Impide acceso desde JS
    );
}

session_destroy(); // Destruye la sesión en el servidor
header('Location: login.php'); // Redirige al login
exit; // Detiene ejecución del script
?>