<?php
// Incluye clases base para Modelo y DAO
require_once 'modelos/Modelo.php';
require_once 'modelos/DAO.php';

// Clase modelo para productos que extiende clase Modelo base
class MProductos extends Modelo{
    public $DAO; // Propiedad pública para acceso a BD

    // Constructor que inicializa DAO para conexión y consultas
    function __construct(){
        parent::__construct(); // Llama al constructor padre (Modelo)
        $this->DAO = new DAO(); // Crea instancia DAO
    }

    // Contar productos según filtros
    public function contarProductos($filtros = array()){
        $ftexto = ''; 
        $factivo = ''; 
        extract($filtros); 
        
        $sql = "SELECT COUNT(*) as total FROM productos WHERE 1=1 ";

        if($ftexto != ''){
            $sql .= " AND (producto LIKE '%$ftexto%' OR descripcion LIKE '%$ftexto%')";
        }

        if($factivo != ''){
            $sql .= " AND activo='$factivo' ";
        }

        $resultado = $this->DAO->consultar($sql);
        return $resultado[0]['total'] ?? 0;
    }

    // Busca productos con filtros y paginación
    public function buscarProductosPaginados($filtros = array(), $offset = 0, $limit = 10){
        $ftexto = ''; 
        $factivo = ''; 
        extract($filtros);
        
        $sql = "SELECT p.*, pc.categoria 
                FROM productos p 
                LEFT JOIN productos_categorias pc ON p.idCategoria = pc.idCategoria 
                WHERE 1=1 ";

        if($ftexto != ''){
            $sql .= " AND (p.producto LIKE '%$ftexto%' OR p.descripcion LIKE '%$ftexto%')";
        }

        if($factivo != ''){
            $sql .= " AND p.activo='$factivo' ";
        }

        // Añadir orden y paginación
        if(isset($filtros['orden'])){
            $sql .= " ORDER BY " . $filtros['orden'];
        } else {
            $sql .= " ORDER BY p.idProducto DESC";
        }
        $sql .= " LIMIT " . (int)$offset . ", " . (int)$limit;

        $productos = $this->DAO->consultar($sql); 

        return $productos;
    }

    // Busca un producto específico por su ID
    public function buscarProductoPorId($idProducto){
        // Consulta SQL por ID del producto
        $sql = "SELECT p.*, pc.categoria 
                FROM productos p 
                LEFT JOIN productos_categorias pc ON p.idCategoria = pc.idCategoria 
                WHERE p.idProducto = '$idProducto'"; 
        $producto = $this->DAO->consultar($sql); // Ejecuta consulta

        // Devuelve el primer resultado o null si no existe
        return $producto[0] ?? null;
    }

    // Inserta nuevo producto en la base de datos
    public function crearProducto($datos){
        extract($datos); // Extrae variables de datos para mayor claridad

        // Preparar sentencia INSERT con datos recibidos (uso directo, ojo con inyección)
        $sql = "INSERT INTO productos (producto, descripcion, idCategoria, precioVenta, stock, activo) 
                VALUES ('$producto', '$descripcion', '$idCategoria', '$precioVenta', '$stock', '$activo')";
        
        // Ejecuta inserción y devuelve resultado (true/false)
        return $this->DAO->insertar($sql);
    }

    // Actualiza datos de un producto existente por ID
    public function actualizarProducto($datos){
        extract($datos); // Extrae variables de datos

        // Construye sentencia UPDATE con los valores recibidos
        $sql = "UPDATE productos SET 
                    producto = '$producto', 
                    descripcion = '$descripcion', 
                    idCategoria = '$idCategoria',
                    precioVenta = '$precioVenta', 
                    stock = '$stock', 
                    activo = '$activo' 
                WHERE idProducto = '$idProducto'";

        // Ejecuta actualización y devuelve resultado
        return $this->DAO->actualizar($sql);
    }

    // Borra un producto por su ID
    public function borrarProducto($idProducto){
        // Construye sentencia DELETE por idProducto
        $sql = "DELETE FROM productos WHERE idProducto = '$idProducto'";

        // Ejecuta borrado
        return $this->DAO->borrar($sql);
    }

    // Lee todas las categorías de productos
    public function leerCategorias(){
        $sql = "SELECT * FROM productos_categorias WHERE activo = 'S' ORDER BY categoria ASC";
        $categorias = $this->DAO->consultar($sql);
        return $categorias;
    }
}
?>