<?php
// Crear variable $usuario con datos recibidos o con valores por defecto para nuevo usuario
$usuario = $datos['usuario'] ?? [
    'idUsuario' => 0, // 0 indica nuevo usuario
    'nombre' => '',
    'apellido1' => '',
    'apellido2' => '',
    'login' => '',
    'mail' => '',
    'movil' => '',
    'pass' => '',
    'activo' => 'S', // Por defecto activo
    'sexo' => 'H'    // Por defecto hombre
];
// Variable booleana para saber si es nuevo usuario (idUsuario = 0)
$esNuevo = ($usuario['idUsuario'] == 0);
// Título que cambia según si es creación o edición
$titulo = $esNuevo ? 'Nuevo Usuario' : 'Editar Usuario';
?>


<!-- Formulario para crear o editar usuario -->
<form id="formularioUsuario" name="formularioUsuario" action="">
    <!-- Campo oculto con el id del usuario para identificar en el backend -->
    <input type="hidden" name="idUsuario" value="<?= $usuario['idUsuario'] ?>">
    
    <!-- Título dinámica: Nuevo o Editar -->
    <h4 id="formLabel"><?= $titulo ?></h4>

    <div class="row">
        <!-- Campo para nombre -->
        <div class="form-group col-md-4">
            <label for="nombre">Nombre</label>
            <!-- Escapar HTML para seguridad y mostrar valor -->
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            <div class="invalid-feedback"></div> <!-- Mensaje de error dinámico -->
        </div>
        
        <!-- Campo para primer apellido -->
        <div class="form-group col-md-4">
            <label for="apellido1">Primer Apellido</label>
            <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?= htmlspecialchars($usuario['apellido1']) ?>" required>
            <div class="invalid-feedback"></div>
        </div>
        
        <!-- Campo para segundo apellido -->
        <div class="form-group col-md-4">
            <label for="apellido2">Segundo Apellido</label>
            <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?= htmlspecialchars($usuario['apellido2']) ?>">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Campo login, lectura sola porque no se puede cambiar -->
        <div class="form-group col-md-4">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars($usuario['login']) ?>" readonly>
        </div>
        
        <!-- Campo correo electrónico -->
        <div class="form-group col-md-4">
            <label for="mail">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" value="<?= htmlspecialchars($usuario['mail']) ?>" required>
            <div class="invalid-feedback"></div>
        </div>
        
        <!-- Campo móvil -->
        <div class="form-group col-md-4">
            <label for="movil">Móvil</label>
            <input type="text" class="form-control" id="movil" name="movil" value="<?= htmlspecialchars($usuario['movil']) ?>">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Campo contraseña, placeholder varía si es nuevo o edición -->
        <div class="form-group col-md-6">
            <label for="pass">Contraseña</label>
            <input type="password" class="form-control" id="pass" name="pass" placeholder="<?= $esNuevo ? 'Introduce contraseña' : 'Dejar en blanco para no cambiar' ?>">
        </div>
        
        <!-- Selector de activo/inactivo -->
        <div class="form-group col-md-3">
            <label for="activo">Estado</label>
            <select id="activo" name="activo" class="form-select">
                <option value="S" <?= ($usuario['activo'] == 'S') ? 'selected' : '' ?>>Activo</option>
                <option value="N" <?= ($usuario['activo'] == 'N') ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </div>

    <!-- Botones para guardar cambios o cancelar edición -->
    <div class="mt-4">
        <button type="button" class="btn btn-primary" onclick="guardarUsuario()">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" onclick="cancelarEdicion()">Cancelar</button>
    </div>
</form>