<?php
require_once 'controladores/Controlador.php';
require_once 'vistas/Vista.php';
require_once 'modelos/MPedidos.php';
require_once 'modelos/MProductos.php'; // Necesario para cargar productos en la vista de edición
require_once 'modelos/MUsuarios.php';  // Necesario para seleccionar usuario

class CPedidos extends Controlador {
    private $modelo;
    private $modeloProductos;
    private $modeloUsuarios;

    public function __construct(){
        $this->modelo = new MPedidos();
        $this->modeloProductos = new MProductos(); // Asumiendo que existe o existirá MProductos para listar productos
        $this->modeloUsuarios = new MUsuarios();   // Para el combo de usuarios
    }

    public function getVistaPedidosPrincipal($datos = array()){
        $usuarios = $this->modeloUsuarios->buscarUsuariosPaginados(array(), 0, 1000);
        $datos_vista = array('listaUsuarios' => $usuarios);
        Vista::render('vistas/Pedidos/VPedidoPrincipal.php', $datos_vista);
    }

    public function getVistaListadoPedidos($filtros = array()){
        $pagina_actual = isset($filtros['pagina']) ? (int)$filtros['pagina'] : 1;
        $resultados_por_pagina = isset($filtros['resultados_por_pagina']) ? (int)$filtros['resultados_por_pagina'] : 10;
        
        if ($pagina_actual < 1) $pagina_actual = 1;
        if ($resultados_por_pagina < 1) $resultados_por_pagina = 10;

        $offset = ($pagina_actual - 1) * $resultados_por_pagina;

        $total_resultados = $this->modelo->contarPedidos($filtros);
        $pedidos = $this->modelo->buscarPedidosPaginados($filtros, $offset, $resultados_por_pagina);
        
        $datos_vista = array(
            'pedidos' => $pedidos,
            'paginacion' => array(
                'total_resultados' => $total_resultados,
                'resultados_por_pagina' => $resultados_por_pagina,
                'pagina_actual' => $pagina_actual,
                'url' => "CFrontal.php?controlador=Pedidos&metodo=getVistaListadoPedidos"
            )
        );

        Vista::render('vistas/Pedidos/VPedidosListado.php', $datos_vista);
    }

    public function getVistaPedidoEditar($datos = array()){
        $pedido = array();
        $detalles = array();

        if (isset($datos['idPedido']) && $datos['idPedido'] > 0) {
            $pedido = $this->modelo->buscarPedidoPorId($datos['idPedido']);
            $detalles = $this->modelo->buscarDetallesPedido($datos['idPedido']);
        }
        
        // Cargar listas necesarias para los selects
        // Nota: MProductos debe tener un metodo buscarProductosPaginados o similar. Usaremos un listado general.
        // Simulamos un 'dame todos' con filtros vacíos y limite alto o metodo específico si existiera.
         $productos = $this->modeloProductos->buscarProductosPaginados(array('orden' => 'p.producto ASC'), 0, 1000); 
        $usuarios = $this->modeloUsuarios->buscarUsuariosPaginados(array(), 0, 1000);

        $datos_vista = array(
            'pedido' => $pedido,
            'detalles' => $detalles,
            'listaProductos' => $productos,
            'listaUsuarios' => $usuarios
        );

        Vista::render('vistas/Pedidos/VPedidoEditar.php', $datos_vista);
    }
    
    public function getVistaPedidoCrear($datos = array()){
         // Reutilizamos la lógica de Editar pero sin pedido cargado
          $productos = $this->modeloProductos->buscarProductosPaginados(array('orden' => 'p.producto ASC'), 0, 1000); 
         $usuarios = $this->modeloUsuarios->buscarUsuariosPaginados(array(), 0, 1000);

         $datos_vista = array(
             'pedido' => array(), // Vacío indica nuevo
             'detalles' => array(),
             'listaProductos' => $productos,
             'listaUsuarios' => $usuarios
         );
         
         Vista::render('vistas/Pedidos/VPedidoEditar.php', $datos_vista);
    }
    
    public function getVistaPedidoDetalles($datos = array()){
        $pedido = array();
        $detalles = array();

        if (isset($datos['idPedido']) && $datos['idPedido'] > 0) {
            $pedido = $this->modelo->buscarPedidoPorId($datos['idPedido']);
            $detalles = $this->modelo->buscarDetallesPedido($datos['idPedido']);
        }

        $datos_vista = array(
            'pedido' => $pedido,
            'detalles' => $detalles
        );

        Vista::render('vistas/Pedidos/VPedidoDetalles.php', $datos_vista);
    }

    public function crearPedido($datos){
        header('Content-Type: application/json');
        
        // Validaciones básicas
        if (empty($datos['idUsuario'])) {
            echo json_encode(['success' => false, 'message' => 'El usuario es obligatorio.']);
            exit();
        }
        if (empty($datos['fechaPedido'])) {
            echo json_encode(['success' => false, 'message' => 'La fecha de pedido es obligatoria.']);
            exit();
        }
        
        // Decodificar los detalles que vienen como string JSON si se enviaron así, 
        // o procesarlos si vienen como array directo (depende de cómo lo enviemos desde JS).
        // Asumo que desde JS enviaremos un array de objetos.
        // En POST form data, 'detalles' suele necesitar un tratamiento especial o enviarse como JSON string.
        // Vamos a asumir que el JS enviará 'detalles' como string JSON y aquí lo decodificamos.
        if (isset($datos['detalles_json'])) {
            $datos['detalles'] = json_decode($datos['detalles_json'], true);
        }

        if (empty($datos['detalles'])) {
             echo json_encode(['success' => false, 'message' => 'Debe agregar al menos un producto al pedido.']);
             exit();
        }

        $creado = $this->modelo->crearPedido($datos);

        if ($creado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar en base de datos.']);
        }
    }

    public function actualizarPedido($datos){
        header('Content-Type: application/json');

        if (empty($datos['idPedido'])) {
            echo json_encode(['success' => false, 'message' => 'ID de pedido no encontrado.']);
            exit();
        }
        
        if (isset($datos['detalles_json'])) {
            $datos['detalles'] = json_decode($datos['detalles_json'], true);
        }
        
         if (empty($datos['detalles'])) {
             echo json_encode(['success' => false, 'message' => 'Debe haber al menos un producto.']);
             exit();
        }

        $actualizado = $this->modelo->actualizarPedido($datos);

        if ($actualizado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el pedido.']);
        }
    }

    public function borrarPedido($datos){
        header('Content-Type: application/json');
        
        if (!isset($datos['idPedido'])) {
             echo json_encode(['success' => false, 'message' => 'ID incorrecto.']);
             exit();
        }

        $borrado = $this->modelo->borrarPedido($datos['idPedido']);

        if ($borrado) {
             echo json_encode(['success' => true]);
        } else {
             echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el pedido.']);
        }
    }
}
?>
