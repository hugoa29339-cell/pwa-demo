<?php
    define('HOST', '127.0.0.1');
    define('USER', 'root');
    define('PASS', '');
    define('DB', 'db_di25');

    class DAO{
		public $conexion; 
        private $error;
				
		public function __construct(){ //constructor
			$this->conexion= new mysqli(HOST,USER,PASS,DB);
			if($this->conexion->connect_errno){
				die('Error de conexión: '.$this->conexion->connect_error);
			}
			$this->error='';
		}

      public function consultar($SQL){
    // Ejecuta el SELECT 
    $res = $this->conexion->query($SQL, MYSQLI_USE_RESULT);

    // Si la query falla, mostrar error y parar
    if ($this->conexion->errno) {
        die('Error en consulta: '.$this->conexion->error.' SQL: '.$SQL);
    } else {
        // Pasar el resultado a un array de filas
        $filas = array();
        while ($reg = $res->fetch_assoc()) {
            $filas[] = $reg;
        }
    }
    return $filas;
}

public function insertar($SQL){
    // Ejecuta el INSERT
    $this->conexion->query($SQL);

    // Si falla la query, error y parar
    if ($this->conexion->errno){
        die('Error consulta BD: '.$this->conexion->error.' SQL: '.$SQL);
        return '';
    } else {
        // Devuelve el id autoincrement (0 si no hay)
        return $this->conexion->insert_id;
    }
}

public function actualizar($SQL){
    // Ejecuta el UPDATE
    $this->conexion->query($SQL);

    // Si falla la query, error y parar
    if ($this->conexion->errno){
        die('Error consuta BD: '.$this->conexion->error.' SQL: '.$SQL);
        return '';
    } else {
        // Devuelve cuántas filas se modificaron
        return $this->conexion->affected_rows;
    }
}

public function borrar($SQL){
    // Ejecuta el DELETE
    $this->conexion->query($SQL);

    // Devuelve cuántas filas se borraron
    return $this->conexion->affected_rows;
}
    }
?>