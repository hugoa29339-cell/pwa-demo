<?php
// Incluye las clases base necesarias para controlador, vista y modelo
require_once 'controladores/Controlador.php';
require_once 'vistas/Vista.php';
require_once 'modelos/MUsuarios.php';

// Definición del controlador de usuarios que extiende controlador base
class CUsuarios extends Controlador {
    private $modelo; // Atributo para instancia del modelo Usuarios

    // Constructor que crea la instancia del modelo Usuarios
    public function __construct(){
        $this->modelo = new MUsuarios();
    }

    // Método para cargar la vista principal de usuarios (pantalla inicial)
    public function getVistaUsuariosPrincipal($datos = array()){
        Vista::render('vistas/Usuarios/VUsuarioPrincipal.php');
    }

    // Método para obtener el listado de usuarios filtrados y paginados
    public function getVistaListadoUsuarios($filtros = array()){
        // 1. Configuración de la paginación
        $pagina_actual = isset($filtros['pagina']) ? (int)$filtros['pagina'] : 1;
        $resultados_por_pagina = isset($filtros['resultados_por_pagina']) ? (int)$filtros['resultados_por_pagina'] : 10;
        
        // Sanitizar para que no sean menores a 1
        if ($pagina_actual < 1) $pagina_actual = 1;
        if ($resultados_por_pagina < 1) $resultados_por_pagina = 10;

        // 2. Calcular el OFFSET para la consulta SQL
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;

        // 3. Obtener el total de resultados (para calcular el total de páginas)
        $total_resultados = $this->modelo->contarUsuarios($filtros);

        // 4. Obtener los usuarios de la página actual
        $usuarios = $this->modelo->buscarUsuariosPaginados($filtros, $offset, $resultados_por_pagina);
        
        // 5. Preparar los datos para la vista
        $datos_vista = array(
            'usuarios' => $usuarios,
            'paginacion' => array(
                'total_resultados' => $total_resultados,
                'resultados_por_pagina' => $resultados_por_pagina,
                'pagina_actual' => $pagina_actual,
                'url' => "CFrontal.php?controlador=Usuarios&metodo=getVistaListadoUsuarios" // URL base para AJAX
            )
        );

        // 6. Renderizar la vista pasándole todos los datos
        Vista::render('vistas/Usuarios/vUsuariosListado.php', $datos_vista);
    }

    // Método para cargar el formulario de edición de usuario con datos cargados
    public function getVistaUsuarioEditar($datos = array()){
        $usuario = array(); // Inicializamos variable vacía
        if (isset($datos['idUsuario']) && $datos['idUsuario'] > 0) {
            // Busca los datos del usuario por su ID para edición
            $usuario = $this->modelo->buscarUsuarioPorId($datos['idUsuario']);
        }
        // Renderiza formulario para edición pasando los datos
        Vista::render('vistas/Usuarios/vUsuarioEditar.php', array('usuario' => $usuario));
    }

    // Método para actualizar un usuario desde datos recibidos, responde JSON
    public function actualizarUsuario($datos){
        header('Content-Type: application/json'); // Indicamos que vamos a devolver JSON

        $errors = []; // Array para recolectar errores en validación

        // Validar que se reciba idUsuario obligatorio para actualizar
        if (empty($datos['idUsuario'])) {
            echo json_encode(['success' => false, 'message' => 'Error: ID de usuario no encontrado.']);
            exit(); // Termina ejecución
        }

        // Validar que el campo nombre no esté vacío
        if (empty($datos['nombre'])) {
            $errors['nombre'] = 'El nombre es obligatorio.';
        }

        // Validar que el móvil sea solo números si viene
        if (!empty($datos['movil']) && !ctype_digit($datos['movil'])) {
            $errors['movil'] = 'El móvil solo debe contener números.';
        }

        // Si hay errores, los enviamos en formato JSON y detenemos
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit();
        }

        // Llamamos al modelo para actualizar usuario
        $actualiza = $this->modelo->actualizarUsuario($datos);

        // Responder al cliente según resultado de la actualización
        if ($actualiza) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: No se pudo actualizar el usuario en la base de datos.']);
        }
        exit(); // Completar ejecución tras responder
    }

    // Método para mostrar formulario de creación de usuario
    public function getVistaUsuarioCrear($datos = array()){
        Vista::render('vistas/Usuarios/vUsuarioCrear.php');
    }

    // Método para crear un usuario nuevo con datos recibidos, responde JSON
    public function crearUsuario($datos){
        header('Content-Type: application/json'); // Indica que responderá con JSON

        $error = []; // Array para errores de validación

        // Validación: campos obligatorios
        if (empty($datos['login']))  { $error['login']  = 'El login es obligatorio.'; }
        if (empty($datos['nombre'])) { $error['nombre'] = 'El nombre es obligatorio.'; }
        if (empty($datos['pass']))   { $error['pass']   = 'La contraseña es obligatoria.'; }

        // Validar que móvil contenga solo dígitos si viene
        if (!empty($datos['movil']) && !ctype_digit($datos['movil'])) {
            $error['movil'] = 'El móvil solo debe contener números.';
        }

        // Validar que login sea único, si ya existe, generar uno nuevo
        if (!empty($datos['login'])) {
            $loginOriginal = $datos['login'];
            while (!empty($this->modelo->buscarUsuarioPorLogin($datos['login']))) {
                $numeroAleatorio = rand(100, 999);
                $datos['login'] = $loginOriginal . $numeroAleatorio;
            }
        }

        // Enviar errores y terminar si los hay
        if (!empty($error)) {
            echo json_encode(['success' => false, 'error' => $error]);
            exit();
        }

        // Llamar al modelo para crear usuario en base de datos
        $crea = $this->modelo->crearUsuario($datos);

        // Responder según resultado de creación
        if ($crea) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el usuario en la base de datos.']);
        }
        exit();
    } 

    // Método para borrar usuario según ID, devuelve respuesta JSON
    public function borrarUsuario($datos){
        header('Content-Type: application/json'); // Respuesta en JSON

        // Validar que recibimos idUsuario válido
        if (!isset($datos['idUsuario']) || !is_numeric($datos['idUsuario'])) {
            echo json_encode(['success' => false, 'message' => 'Error: ID de usuario no válido.']);
            exit();
        }

        $idUsuario = $datos['idUsuario']; // Guardar ID para borrar
        $resultado = $this->modelo->borrarUsuario($idUsuario); // Llama modelo para borrar

        // Responder JSON según éxito o fallo del borrado
        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el usuario.']);
        }
        exit();
    }
}
?>