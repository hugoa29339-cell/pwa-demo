<?php
session_start(); // Inicia la sesión para trabajar con variables de usuario

// --- INICIO CAMBIO: PUERTA DE SEGURIDAD PARA AJAX ---
// Se ha añadido este bloque para comprobar si el usuario tiene una sesión activa ('login').
// Es la principal medida de seguridad para todas las peticiones AJAX que pasan por este controlador.
if (!isset($_SESSION['login']) || $_SESSION['login'] === '') {
    // Si no hay sesión, se envía una cabecera HTTP 401 'Unauthorized'.
    // El JavaScript del cliente (index.js) está preparado para interceptar este error
    // y redirigir al usuario a la página de login.
    header('HTTP/1.1 401 Unauthorized');
    exit(); // Se detiene la ejecución para que no se procese nada más.
}
// --- FIN CAMBIO ---

$getPost = array_merge($_GET, $_POST, $_FILES); // Junta todos los datos GET, POST y archivos subidos en un solo array

// Si llega el nombre de un controlador y no está vacío
if (isset($getPost['controlador']) && $getPost['controlador'] != '') { 
    // Si existe el archivo del controlador solicitado en la carpeta "controladores"
    if (file_exists('controladores/C' . $getPost['controlador'] . '.php')) { 
        // Si también llega el método (función) a ejecutar
        if (isset($getPost['metodo']) && $getPost['metodo'] != '') { 
            $controlador = 'C' . $getPost['controlador']; // Construye el nombre de la clase del controlador (ej: CUsuarios)
            $metodo = $getPost['metodo']; // Guarda el nombre del método a ejecutar
            require_once('controladores/' . $controlador . '.php'); // Incluye el archivo PHP del controlador

            $objCont = new $controlador(); // Crea una nueva instancia (objeto) del controlador
            // Si el método existe en ese controlador
            if (method_exists($objCont, $metodo)) { 
                $objCont->$metodo($getPost); // Llama al método y le pasa todos los datos de la petición
            } else {
                echo 'Error CF_04'; // El método no existe en el controlador
            }
        } else {
            echo 'Error CF_03'; // No llega el método a ejecutar
        }
    } else {
        echo 'Error CF_02'; // No se encuentra el archivo del controlador
    }
} else {
    echo 'Error CF_01'; // No llega el nombre del controlador
}
?>