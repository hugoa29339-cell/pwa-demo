<?php
    class Vista{
        // Método estático para mostrar cualquier vista
        static public function render($rutaVista, $datos=array()){
            // Si el array de datos tiene variables, las convertimos en variables sueltas
            if (is_array($datos) && !empty($datos)) {
                extract($datos, EXTR_SKIP); // Ahora puedes usar $usuarios, $productos, etc. en la vista
            }
            require($rutaVista); // Incluye el archivo de la vista para mostrar el HTML/PHP correspondiente
        }
    }
?>