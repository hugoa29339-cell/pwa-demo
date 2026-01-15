<?php
// Se inicializa un nuevo usuario con campos vacíos para crear desde cero
$usuario = [
    'idUsuario' => 0, // Indica nuevo usuario (no existe en BD)
    'nombre' => '', // Campo nombre vacío
    'apellido1' => '', // Primer apellido vacío
    'apellido2' => '', // Segundo apellido vacío
    'login' => '', // Login vacío, se generará
    'mail' => '', // Email vacío
    'movil' => '', // Teléfono móvil vacío
    'pass' => '', // Contraseña vacía (debe introducirse)
    'activo' => 'S', // Usuario activo por defecto
    'sexo' => 'H' // Sexo hombre por defecto
];
// Título fijo para creación de nuevo usuario
$titulo = 'Nuevo Usuario';
?>

<!-- Formulario para crear un nuevo usuario -->
<form id="formularioUsuario" name="formularioUsuario" action="" onsubmit="crearUsuario(); return false;">
    <!-- Campo oculto que almacena ID (0 porque es nuevo) -->
    <input type="hidden" name="idUsuario" value="<?= $usuario['idUsuario'] ?>">
    
    <!-- Título del formulario -->
    <h4 id="formLabel"><?= $titulo ?></h4>

    <div class="row">
        <!-- Campo para ingresar nombre, obligatorio -->
        <div class="form-group col-md-4">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" onkeyup="generarLogin()" required>
            <div class="invalid-feedback"></div> <!-- Registro de mensajes de error -->
        </div>
        
        <!-- Campo para primer apellido, obligatorio -->
        <div class="form-group col-md-4">
            <label for="apellido1">Primer Apellido</label>
            <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?= htmlspecialchars($usuario['apellido1']) ?>" onkeyup="generarLogin()" required>
            <div class="invalid-feedback"></div>
        </div>
        
        <!-- Campo para segundo apellido, opcional -->
        <div class="form-group col-md-4">
            <label for="apellido2">Segundo Apellido</label>
            <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?= htmlspecialchars($usuario['apellido2']) ?>">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Campo login generado (readonly), no editable -->
        <div class="form-group col-md-4">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars($usuario['login']) ?>" readonly>
            <div class="invalid-feedback"></div> <!-- Por si hay errores -->
        </div>
        
        <!-- Campo email, obligatorio -->
        <div class="form-group col-md-4">
            <label for="mail">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" value="<?= htmlspecialchars($usuario['mail']) ?>" required>
            <div class="invalid-feedback"></div>
        </div>
        
        <!-- Campo móvil, opcional -->
        <div class="form-group col-md-4">
            <label for="movil">Móvil</label>
            <input type="text" class="form-control" id="movil" name="movil" value="<?= htmlspecialchars($usuario['movil']) ?>">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Campo contraseña, obligatorio para crear -->
        <div class="form-group col-md-6">
            <label for="pass">Contraseña</label>
            <input type="password" class="form-control" id="pass" name="pass" placeholder="Introduce contraseña">
            <div class="invalid-feedback"></div>
        </div>
        
        <!-- Select para estado activo/inactivo -->
        <div class="form-group col-md-3">
            <label for="activo">Estado</label>
            <select id="activo" name="activo" class="form-select">
                <option value="S" <?= ($usuario['activo'] == 'S') ? 'selected' : '' ?>>Activo</option> <!-- Opción por defecto -->
                <option value="N" <?= ($usuario['activo'] == 'N') ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </div>

    <!-- Botones para crear usuario o cancelar -->
    <div class="mt-4">
        <button type="button" class="btn btn-primary" onclick="crearUsuario()">Crear Usuario</button> <!-- Llama a JS para crear -->
        <button type="button" class="btn btn-secondary" onclick="cancelarCreacion()">Cancelar</button> <!-- Cierra formulario -->
    </div>
</form>