<?php
require_once 'modelos/Modelo.php';
require_once 'modelos/DAO.php';

class MPedidos extends Modelo {
    public $DAO;

    function __construct() {
        $this->DAO = new DAO();
    }

    public function contarPedidos($filtros = array()) {
        $fechaDesde = '';
        $fechaHasta = '';
        $nombreUsuario = ''; 
        extract($filtros);

        $sql = "SELECT COUNT(*) as total 
                FROM pedidos p
                LEFT JOIN usuarios u ON p.idUsuario = u.idUsuario 
                WHERE 1=1 ";

        if (!empty($nombreUsuario)) {
            $sql .= " AND (
                CONCAT(u.nombre, ' ', u.apellido1, ' (', u.login, ')') LIKE '%$nombreUsuario%'
                OR u.nombre LIKE '%$nombreUsuario%' 
                OR u.apellido1 LIKE '%$nombreUsuario%' 
                OR u.login LIKE '%$nombreUsuario%'
            ) "; 
        }

        $resultado = $this->DAO->consultar($sql);
        return $resultado[0]['total'] ?? 0;
    }

    public function buscarPedidosPaginados($filtros = array(), $offset = 0, $limit = 10) {
        $fechaDesde = '';
        $fechaHasta = '';
        $nombreUsuario = ''; 
        extract($filtros);

        $sql = "SELECT p.*, CONCAT(u.nombre, ' ', u.apellido1) as nombreUsuario 
                FROM pedidos p 
                LEFT JOIN usuarios u ON p.idUsuario = u.idUsuario 
                WHERE 1=1 ";

        if (!empty($nombreUsuario)) {
             $sql .= " AND (
                 CONCAT(u.nombre, ' ', u.apellido1, ' (', u.login, ')') LIKE '%$nombreUsuario%'
                 OR u.nombre LIKE '%$nombreUsuario%' 
                 OR u.apellido1 LIKE '%$nombreUsuario%' 
                 OR u.login LIKE '%$nombreUsuario%'
             ) "; 
        }

        $sql .= " ORDER BY p.idPedido DESC ";
        $sql .= " LIMIT " . (int)$offset . ", " . (int)$limit;

        return $this->DAO->consultar($sql);
    }

    public function buscarPedidoPorId($idPedido) {
        $idPedido = (int)$idPedido;
        $sql = "SELECT p.*, u.nombre, u.apellido1, u.apellido2, u.login 
                FROM pedidos p
                LEFT JOIN usuarios u ON p.idUsuario = u.idUsuario
                WHERE p.idPedido = $idPedido";
        $datos = $this->DAO->consultar($sql);
        return $datos[0] ?? array();
    }

    public function buscarDetallesPedido($idPedido) {
        $idPedido = (int)$idPedido;
        // Join con productos para obtener nombre del producto
        $sql = "SELECT dp.*, prod.producto 
                FROM pedidosdetalles dp
                LEFT JOIN productos prod ON dp.idProducto = prod.idProducto
                WHERE dp.idPedido = $idPedido";
        return $this->DAO->consultar($sql);
    }

    public function crearPedido($datos) {
        // Extraer datos de cabecera con valores por defecto para evitar fallos de NOT NULL
        $idUsuario = (int)$datos['idUsuario'];
        $fechaPedido = !empty($datos['fechaPedido']) ? $datos['fechaPedido'] : date('Y-m-d H:i:s');
        
        // La base de datos no permite NULLs en estas campos, así que usamos la fecha actual como valor inicial
        $fechaAlmacen = !empty($datos['fechaAlmacen']) ? $datos['fechaAlmacen'] : $fechaPedido;
        $fechaEnvio = !empty($datos['fechaEnvio']) ? $datos['fechaEnvio'] : $fechaPedido;
        $fechaRecibido = !empty($datos['fechaRecibido']) ? $datos['fechaRecibido'] : $fechaPedido;
        $fechaFinalizado = !empty($datos['fechaFinalizado']) ? $datos['fechaFinalizado'] : $fechaPedido;
        
        $direccion = $datos['direccion'] ?? '';
        $transporte = $datos['transporte'] ?? '';
        
        // Insertar Cabecera usando Prepared Statement
        $stmt = $this->DAO->conexion->prepare("INSERT INTO pedidos (idUsuario, fechaPedido, fechaAlmacen, fechaEnvio, fechaRecibido, fechaFinalizado, direccion, transporte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) return false;

        $stmt->bind_param("isssssss", 
            $idUsuario, 
            $fechaPedido, 
            $fechaAlmacen, 
            $fechaEnvio, 
            $fechaRecibido, 
            $fechaFinalizado,
            $direccion, 
            $transporte
        );
        
        $ok = $stmt->execute();
        $idPedido = $stmt->insert_id;
        $stmt->close();

        if ($ok && $idPedido && !empty($datos['detalles'])) {
            // Insertar Detalles
            foreach ($datos['detalles'] as $detalle) {
                $idProducto = (int)$detalle['idProducto'];
                $cantidad = (int)$detalle['cantidad'];
                $precioVenta = (float)$detalle['precioVenta'];

                $sqlDetalle = "INSERT INTO pedidosdetalles (idPedido, idProducto, cantidad, precioVenta) 
                               VALUES ($idPedido, $idProducto, $cantidad, $precioVenta)";
                $this->DAO->insertar($sqlDetalle);
            }
            return true;
        }
        return false;
    }

    public function actualizarPedido($datos) {
        $idPedido = (int)($datos['idPedido'] ?? 0);
        if ($idPedido === 0) return false;

        // Actualizar Cabecera
        // Usamos lógica simple sin prepared statements complexes para mantener consistencia con el estilo 'rápido' visto en MUsuarios (aunque MUsuarios usaba prepared para insert/update, aquí replicaré update simple o prepared según DAO).
        // DAO tiene metodo 'actualizar' que ejecuta query directa. MUsuarios usaba prepared statements manualmente.
        // Voy a usar sentencias preparadas manualmente como en MUsuarios para seguridad.
        
        $fechaAlmacen = !empty($datos['fechaAlmacen']) ? $datos['fechaAlmacen'] : $datos['fechaPedido'];
        $fechaEnvio = !empty($datos['fechaEnvio']) ? $datos['fechaEnvio'] : $datos['fechaPedido'];
        $fechaRecibido = !empty($datos['fechaRecibido']) ? $datos['fechaRecibido'] : $datos['fechaPedido'];
        $fechaFinalizado = !empty($datos['fechaFinalizado']) ? $datos['fechaFinalizado'] : $datos['fechaPedido'];
        $transporte = $datos['transporte'] ?? '';
        
        $stmt = $this->DAO->conexion->prepare("UPDATE pedidos SET idUsuario=?, fechaPedido=?, fechaAlmacen=?, fechaEnvio=?, fechaRecibido=?, fechaFinalizado=?, direccion=?, transporte=? WHERE idPedido=?");
        if (!$stmt) return false;

        $stmt->bind_param("isssssssi", 
            $datos['idUsuario'], 
            $datos['fechaPedido'], 
            $fechaAlmacen, 
            $fechaEnvio, 
            $fechaRecibido, 
            $fechaFinalizado,
            $datos['direccion'], 
            $transporte,
            $idPedido
        );
        
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            // Actualizar Detalles: Estrategia simple -> Borrar todos y recrear (menos eficiente pero más sencillo de implementar en MVC escolar)
            // O mejor: Comparar. Para simplificar y seguir "hacindolo poco a poco", primero borraré los anteriores.
            $this->DAO->borrar("DELETE FROM pedidosdetalles WHERE idPedido = $idPedido");

            if (!empty($datos['detalles'])) {
                foreach ($datos['detalles'] as $detalle) {
                    $idProducto = $detalle['idProducto'];
                    $cantidad = $detalle['cantidad'];
                    $precioVenta = $detalle['precioVenta'];
    
                    // Insertamos de nuevo
                    $sqlDetalle = "INSERT INTO pedidosdetalles (idPedido, idProducto, cantidad, precioVenta) 
                                   VALUES ($idPedido, $idProducto, $cantidad, $precioVenta)";
                    $this->DAO->insertar($sqlDetalle);
                }
            }
            return true;
        }
        return false;
    }

    public function borrarPedido($idPedido) {
        $idPedido = (int)$idPedido;
        // Foreign key con ON DELETE CASCADE debería manejar los detalles, pero por si acaso en la lógica de negocio:
        $sql = "DELETE FROM pedidos WHERE idPedido = $idPedido";
        return $this->DAO->borrar($sql);
    }
}
?>
