<?php
// Incluye las clases base necesarias: Modelo y DAO
require_once 'modelos/Modelo.php';
require_once 'modelos/DAO.php';

// Clase Modelo de Usuarios que extiende clase base Modelo
class MUsuarios extends Modelo{
    public $DAO; // Propiedad pública para acceso a base de datos
    
    // Constructor que crea instancia de DAO para operaciones de BD
    function __construct(){
        $this->DAO= new DAO();
    }

    // Método para contar usuarios con los mismos filtros que la búsqueda
    public function contarUsuarios($filtros=array()){
        $ftexto= ''; 
        $factivo= ''; 
        extract($filtros); 
       
        // La consulta es casi idéntica a la de búsqueda, pero con COUNT(*)
        $sql= "SELECT COUNT(*) as total FROM usuarios WHERE 1=1 "; 
        
        if($factivo!=''){
            $sql.=" AND activo='$factivo' ";
        }

        if($ftexto!=''){
            $aTexto=explode(' ', $ftexto); 
            $sql.=" AND ( 1=0 "; 
            foreach ($aTexto as $palabra) { 
                $sql.=" OR nombre LIKE '%$palabra%' "; 
                $sql.=" OR apellido1 LIKE '%$palabra%' "; 
                $sql.=" OR apellido2 LIKE '%$palabra%' "; 
                $sql.=" OR mail LIKE '%$palabra%' "; 
                $sql.=" OR login LIKE '%$palabra%' "; 
            }
            $sql.=" ) "; 
        }

        $resultado = $this->DAO->consultar($sql); 
        return $resultado[0]['total'] ?? 0; // Devuelve el total o 0 si falla
    }

    // Método para buscar usuarios con filtros y paginación
    public function buscarUsuariosPaginados($filtros=array(), $offset = 0, $limit = 10){
        $ftexto= ''; 
        $factivo= ''; 
        extract($filtros);
       
        $sql= "SELECT * FROM usuarios WHERE 1=1 "; 
        
        if($factivo!=''){
            $sql.=" AND activo='$factivo' ";
        }

        if($ftexto!=''){
            $aTexto=explode(' ', $ftexto); 
            $sql.=" AND ( 1=0 "; 
            foreach ($aTexto as $palabra) { 
                $sql.=" OR nombre LIKE '%$palabra%' "; 
                $sql.=" OR apellido1 LIKE '%$palabra%' "; 
                $sql.=" OR apellido2 LIKE '%$palabra%' "; 
                $sql.=" OR mail LIKE '%$palabra%' "; 
                $sql.=" OR login LIKE '%$palabra%' "; 
            }
            $sql.=" ) "; 
        }

        // Añadir orden y paginación
        $sql .= " ORDER BY idUsuario DESC"; // Ordenar para consistencia
        $sql .= " LIMIT " . (int)$offset . ", " . (int)$limit; // Añadir LIMIT y OFFSET

        $usuarios= $this->DAO->consultar($sql); 

        return $usuarios; 
    }

    // Método para buscar un usuario específico por su ID
    public function buscarUsuarioPorId($idUsuario = 0){
        $idUsuario = (int)$idUsuario; // Convierte a entero para seguridad
        $sql = "SELECT * FROM usuarios WHERE idUsuario = $idUsuario"; // Consulta por ID
        $datos = $this->DAO->consultar($sql); // Ejecuta consulta
        if (count($datos) > 0) { // Si encuentra resultados
            return $datos[0]; // Devuelve primera fila (única)
        }
        return array(); // Devuelve array vacío si no encuentra nada
    }

    // Método para buscar usuario por login (para validar login único)
    public function buscarUsuarioPorLogin($login){
        $sql = "SELECT * FROM usuarios WHERE login = '$login'"; // Busca por login exacto
        $datos = $this->DAO->consultar($sql); // Ejecuta consulta
        if (count($datos) > 0) { // Si existe
            return $datos[0]; // Devuelve datos del usuario
        }
        return array(); // Devuelve vacío si no existe
    }

    // Método para actualizar usuario con prepared statement
    public function actualizarUsuario($d) {
        $id = (int)($d['idUsuario'] ?? 0); // Obtiene y convierte ID a entero
        if ($id === 0) return false; // Si no hay ID, no se puede actualizar

        $permitidos = ['nombre','apellido1','apellido2','mail','movil','activo']; // Lista blanca de campos editables
        $set = []; // Array para almacenar fragmentos "campo = ?"
        $params = []; // Array para valores que irán en los ?
        $types  = ''; // String para tipos de datos (s=string)

        foreach ($permitidos as $c) { // Recorre cada campo permitido
            if (isset($d[$c])) { // Si el campo viene en los datos
                $set[] = "`$c` = ?"; // Añade fragmento SQL
                $params[] = $d[$c]; // Guarda valor
                $types .= 's'; // Marca como string
            }
        }

        // Si viene nueva contraseña, la cifra y añade
        if (!empty($d['pass'])) {
            $set[] = "`pass` = ?"; // Añade campo pass
            $params[] = password_hash($d['pass'], PASSWORD_DEFAULT); // Cifra contraseña con bcrypt
            $types .= 's'; // Tipo string
        }

        if (!$set) return true; // Si no hay cambios, retorna true

        $sql = "UPDATE usuarios SET " // Inicia UPDATE
             . implode(', ', $set) // Une todos los "campo = ?" con comas
             . " WHERE idUsuario = ?"; // Condición para actualizar solo este usuario

        $params[] = $id; // Añade ID al final de parámetros
        $types .= 'i'; // ID es entero (i)

        $stmt = $this->DAO->conexion->prepare($sql); // Prepara consulta
        if (!$stmt) return false; // Si falla preparación, retorna false

        $stmt->bind_param($types, ...$params); // Vincula tipos y valores a los ?
        $ok = $stmt->execute(); // Ejecuta UPDATE
        $stmt->close(); // Cierra statement

        return $ok; // Retorna true/false según éxito
    }

    // Método para crear usuario nuevo con prepared statement
    public function crearUsuario($d) {
        $permitidos = ['nombre','apellido1','apellido2','login','mail','movil','activo']; // Campos permitidos

        $set = []; // Array para "campo = ?"
        $params = []; // Array para valores
        $types  = ''; // String para tipos

        foreach ($permitidos as $c) { // Recorre campos permitidos
            if (isset($d[$c])) { // Si el campo viene en datos
                $set[] = "`$c` = ?"; // Añade fragmento SQL
                $params[] = $d[$c]; // Guarda valor
                $types .= 's'; // Marca como string
            }
        }

        // Si viene contraseña, la cifra
        if (!empty($d['pass'])) {
            $set[] = "`pass` = ?"; // Añade campo pass
            $params[] = password_hash($d['pass'], PASSWORD_DEFAULT); // Cifra con bcrypt
            $types .= 's'; // Tipo string
        }

        // Añade fecha de alta automáticamente
        $set[] = "`fechaAlta` = ?";
        $params[] = date('Y-m-d'); // Fecha actual formato YYYY-MM-DD
        $types .= 's'; // Tipo string

        if (!$set) return false; // Si no hay datos, retorna false

        $sql = "INSERT INTO usuarios SET " // Inicia INSERT
             . implode(', ', $set); // Une "campo = ?" con comas

        $stmt = $this->DAO->conexion->prepare($sql); // Prepara consulta
        if (!$stmt) return false; // Si falla, retorna false

        $stmt->bind_param($types, ...$params); // Vincula tipos y valores a ?
        $ok = $stmt->execute(); // Ejecuta INSERT
        $stmt->close(); // Cierra statement

        return $ok; // Retorna true si insertó correctamente
    }

    // Método para borrar usuario por ID con prepared statement
    public function borrarUsuario($idUsuario) {
        $idUsuario = (int)$idUsuario; // Convierte a entero para seguridad
        if ($idUsuario <= 0) { // Valida que ID sea positivo
            return false;
        }

        $sql = "DELETE FROM usuarios WHERE idUsuario = ?"; // Consulta DELETE con placeholder
        
        $stmt = $this->DAO->conexion->prepare($sql); // Prepara consulta
        if (!$stmt) { // Si falla preparación
            return false;
        }

        $stmt->bind_param('i', $idUsuario); // Vincula ID como entero
        $ok = $stmt->execute(); // Ejecuta DELETE
        $stmt->close(); // Cierra statement

        return $ok; // Retorna true/false según éxito
    }
}
?>