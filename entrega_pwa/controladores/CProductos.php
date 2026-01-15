<?php
// Archivo controlador para productos, maneja la lógica entre modelo y vista
require_once 'controladores/Controlador.php'; // Clase base controlador
require_once 'vistas/Vista.php'; // Clase para renderizar vistas
require_once 'modelos/MProductos.php'; // Modelo de Productos

class CProductos extends Controlador {
    private $modelo; // Atributo para el modelo

    // Constructor crea instancia del modelo de productos
    public function __construct(){
        $this->modelo = new MProductos();
    }

    // Método que carga la vista principal de productos (sin datos aún)
    public function getVistaProductosPrincipal($datos = array()){
        Vista::render('vistas/Productos/vProductoPrincipal.php');
    }

    // Método que obtiene el listado de productos filtrados y paginados
    public function getVistaListadoProductos($filtros = array()){
        // 1. Configuración de la paginación
        $pagina_actual = isset($filtros['pagina']) ? (int)$filtros['pagina'] : 1;
        $resultados_por_pagina = isset($filtros['resultados_por_pagina']) ? (int)$filtros['resultados_por_pagina'] : 10;
        
        if ($pagina_actual < 1) $pagina_actual = 1;
        if ($resultados_por_pagina < 1) $resultados_por_pagina = 10;

        // 2. Calcular el OFFSET
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;

        // 3. Obtener el total de resultados
        $total_resultados = $this->modelo->contarProductos($filtros);

        // 4. Obtener los productos de la página actual
        $productos = $this->modelo->buscarProductosPaginados($filtros, $offset, $resultados_por_pagina);
        
        // 5. Preparar los datos para la vista
        $datos_vista = array(
            'productos' => $productos,
            'paginacion' => array(
                'total_resultados' => $total_resultados,
                'resultados_por_pagina' => $resultados_por_pagina,
                'pagina_actual' => $pagina_actual,
                'url' => "CFrontal.php?controlador=Productos&metodo=getVistaListadoProductos" // URL base para AJAX
            )
        );

        // 6. Renderizar la vista pasándole todos los datos
        Vista::render('vistas/Productos/vProductosListado.php', $datos_vista);
    }

    // Método para cargar el formulario de editar producto con los datos cargados
    public function getVistaProductoEditar($datos = array()){
        $producto = array(); // Inicializa array vacío
        if (isset($datos['idProducto']) && $datos['idProducto'] > 0) {
            // Busca producto por ID para editar
            $producto = $this->modelo->buscarProductoPorId($datos['idProducto']);
        }
        
        // Lee todas las categorías para el desplegable
        $categorias = $this->modelo->leerCategorias();

        // Prepara los datos para la vista
        $datos_vista = array(
            'producto' => $producto,
            'categorias' => $categorias
        );
        
        // Renderiza vista del formulario de edición con datos cargados
        Vista::render('vistas/Productos/vProductoEditar.php', $datos_vista);
    }

    // Actualiza producto con datos recibidos, devuelve JSON para AJAX
    public function actualizarProducto($datos){
        header('Content-Type: application/json'); // Indica respuesta JSON

        $errors = []; // Array para almacenar errores de validación

        // Validación: idProducto obligatorio para actualizar
        if (empty($datos['idProducto'])) {
            echo json_encode(['success' => false, 'message' => 'Error: ID de producto no encontrado.']);
            exit(); // Para ejecución si falta ID
        }

        // Validación: nombre del producto obligatorio
        if (empty($datos['producto'])) {
            $errors['producto'] = 'El nombre del producto es obligatorio.';
        }

        // Validación: idCategoria obligatorio
        if (empty($datos['idCategoria'])) {
            $errors['idCategoria'] = 'La categoría es obligatoria.';
        }

        // Validación: precioVenta debe ser numérico si existe
        if (!empty($datos['precioVenta']) && !is_numeric($datos['precioVenta'])) {
            $errors['precioVenta'] = 'El precio solo debe contener números.';
        }

        // Si hay errores, devolverlos en JSON y detener ejecución
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit();
        }

        // Llama modelo para actualizar producto en BD
        $actualiza = $this->modelo->actualizarProducto($datos);

        // Devuelve JSON según resultado de actualización
        if ($actualiza) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: No se pudo actualizar el producto en la base de datos.']);
        }
        exit();
    } 

    // Carga vista para crear producto nuevo
    public function getVistaProductoCrear($datos = array()){
        // Lee todas las categorías para el desplegable
        $categorias = $this->modelo->leerCategorias();

        // Renderiza la vista del formulario de creación con las categorías
        Vista::render('vistas/Productos/vProductoCrear.php', array('categorias' => $categorias));
    }

    // Crea nuevo producto con datos recibidos, responde JSON
    public function crearProducto($datos){
        header('Content-Type: application/json'); // Indica respuesta JSON

        $error = []; // Array para errores

        // Validación: campos obligatorios
        if (empty($datos['producto'])) { $error['producto'] = 'El nombre del producto es obligatorio.'; }
        if (empty($datos['idCategoria'])) { $error['idCategoria'] = 'La categoría es obligatoria.'; }
        if (empty($datos['precioVenta'])) { $error['precioVenta'] = 'El precio es obligatorio.'; }

        // Validación: precioVenta debe ser numérico
        if (!empty($datos['precioVenta']) && !is_numeric($datos['precioVenta'])) {
            $error['precioVenta'] = 'El precio solo debe contener números.';
        }

        // Si encuentra errores, los envía y para ejecución
        if (!empty($error)) {
            echo json_encode(['success' => false, 'error' => $error]);
            exit();
        }

        // Se crea producto en base de datos vía modelo
        $crea = $this->modelo->crearProducto($datos);

        // Respuesta JSON según éxito o fallo
        if ($crea) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el producto en la base de datos.']);
        }
        exit();
    } 

    // Borra un producto según su ID, devuelve JSON
    public function borrarProducto($datos){
        header('Content-Type: application/json'); // Respuesta JSON

        // Validar que ID producto exista y sea numérico
        if (!isset($datos['idProducto']) || !is_numeric($datos['idProducto'])) {
            echo json_encode(['success' => false, 'message' => 'Error: ID de producto no válido.']);
            exit();
        }

        $idProducto = $datos['idProducto']; // Guardar ID
        $resultado = $this->modelo->borrarProducto($idProducto); // Llama modelo para borrar

        // Responde según resultado
        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el producto.']);
        }
        exit();
    }
}
?>