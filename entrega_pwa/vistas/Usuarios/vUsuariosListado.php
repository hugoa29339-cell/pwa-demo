<?php 
  // Verifica si se pasaron datos de usuarios y los extrae, si no crea un array vacío
  if(isset($datos) && isset($datos['usuarios'])){
      $usuarios = $datos['usuarios']; // Guarda los usuarios en variable para usar en la vista
  } else {
      $usuarios = array(); // Evita errores si no hay datos, establece array vacío
  }
?>
<div class="table-container">
  <div class="table-actions">
    <!-- Botón para abrir formulario creación usuario con AJAX -->
    <button class="btn btn-success btn-sm" onclick="editarCrear('Usuarios', 'getVistaUsuarioCrear', 'capaEditarCrear')">Crear Usuario 👤</button>
  </div>
  <table class="table table-sm">
    <thead>
        <tr>
          <!-- Cabeceras de tabla -->
          <!-- Las columnas comentadas son opcionales -->
          <th>Nombre completo</th>
          <th>Login</th>
          <th>Fecha alta</th>
          <th>Email</th>
          <th>Activo</th>
          <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($usuarios) > 0): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <!-- Cada fila tiene id único para manipularla con JavaScript (p.ej. borrar) -->
                <tr id="filaUsuario<?= $usuario['idUsuario'] ?>">
                 <!-- Las columnas de apellidos e ID están comentadas pero disponibles -->
                <td>
                  <!-- Botón editar que carga formulario edición mediante AJAX -->
                    <button class="btn btn-primary btn-sm" 
                            onclick="editarCrear('Usuarios', 'getVistaUsuarioEditar', 'capaEditarCrear', { idUsuario: <?= $usuario['idUsuario'] ?> })">Editar✏️</button>
                    <!-- Mostrar nombre completo escapando HTML para seguridad -->
                    <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido1'] . ' ' . $usuario['apellido2']) ?>
                </td>

                    <td><?php echo $usuario['login']; ?></td> <!-- Login del usuario -->
                    <td><?php echo date('d-m-Y', strtotime($usuario['fechaAlta'])); ?></td> <!-- Fecha de alta -->
                    <td><?php echo $usuario['mail']; ?></td> <!-- Email -->
                    <td>
                        <!-- Badge que indica si usuario está activo -->
                        <?= ($usuario['activo'] ?? '') === 'S'
      ? '<span class="badge text-bg-success" style="min-width:52px;display:inline-block;text-align:center;">Sí✅</span>'
      : '<span class="badge text-bg-danger"  style="min-width:52px;display:inline-block;text-align:center;">No❌</span>' ?>
     </td>
                    <td>
                        <!-- Botón de borrar que llama a función AJAX borrar -->
                        <button class="btn btn-danger btn-sm" onclick="borrar('Usuarios', 'borrarUsuario', { idUsuario: <?= $usuario['idUsuario'] ?> }, 'filaUsuario<?= $usuario['idUsuario'] ?>')">Borrar🗑️</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Mensaje si no hay usuarios -->
            <tr>
                <td colspan="7" class="text-center">No se encontraron usuarios</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// Integración del paginador
if (isset($datos['paginacion'])) {
    // Extraer variables para que el paginador las pueda usar
    $total_resultados = $datos['paginacion']['total_resultados'];
    $resultados_por_pagina = $datos['paginacion']['resultados_por_pagina'];
    $pagina_actual = $datos['paginacion']['pagina_actual'];
    $url = $datos['paginacion']['url'];

    // Incluir la vista del paginador
    require 'vistas/Paginador/vPaginador.php';
}
?>
</div>