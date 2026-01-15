<?php 
  if(isset($datos) && isset($datos['pedidos'])){
      $pedidos = $datos['pedidos'];
  } else {
      $pedidos = array();
  }
?>
<div class="table-container">
  <div class="table-actions">
    <button class="btn btn-success btn-sm" onclick="editarCrear('Pedidos', 'getVistaPedidoCrear', 'capaEditarCrear')">Crear Pedido 📦</button>
  </div>
  <table class="table table-sm table-striped">
    <thead>
        <tr>
          <th>ID PEDIDO</th>
          <th>Usuario</th>
          <th>Fecha Pedido</th>
          <th>Fecha Almacén</th>
          <th>Fecha Envío</th>
          <th>Fecha Recibido</th>
          <th>Transporte</th>
          <th>Dirección de entrega</th>
          <th>Detalles</th>
          <th>Editar</th>
          <th>Borrar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($pedidos) > 0): ?>
            <?php foreach ($pedidos as $p): ?>
                <tr id="filaPedido<?= $p['idPedido'] ?>">
                    <td><?= $p['idPedido'] ?></td>
                    <td><?= htmlspecialchars($p['nombreUsuario'] ?? $p['idUsuario']) ?></td>
                    <td><?= !empty($p['fechaPedido']) ? date('d/m/Y', strtotime($p['fechaPedido'])) : '' ?></td>
                    <td><?= !empty($p['fechaAlmacen']) ? date('d/m/Y', strtotime($p['fechaAlmacen'])) : '' ?></td>
                    <td><?= !empty($p['fechaEnvio']) ? date('d/m/Y', strtotime($p['fechaEnvio'])) : '' ?></td>
                    <td><?= !empty($p['fechaRecibido']) ? date('d/m/Y', strtotime($p['fechaRecibido'])) : '' ?></td>
                    <td><?= htmlspecialchars($p['transporte'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['direccion']) ?></td>
                    <td class="text-center">
                        <button class="btn btn-info btn-sm" 
                                onclick="editarCrear('Pedidos', 'getVistaPedidoDetalles', 'capaEditarCrear', { idPedido: <?= $p['idPedido'] ?> })">📋</button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm" 
                                onclick="editarCrear('Pedidos', 'getVistaPedidoEditar', 'capaEditarCrear', { idPedido: <?= $p['idPedido'] ?> })">Editar✏️</button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" 
                                onclick="borrar('Pedidos', 'borrarPedido', { idPedido: <?= $p['idPedido'] ?> }, 'filaPedido<?= $p['idPedido'] ?>')">Borrar🗑️</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="11" class="text-center">No se encontraron pedidos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
if (isset($datos['paginacion'])) {
    $total_resultados = $datos['paginacion']['total_resultados'];
    $resultados_por_pagina = $datos['paginacion']['resultados_por_pagina'];
    $pagina_actual = $datos['paginacion']['pagina_actual'];
    $url = $datos['paginacion']['url'];
    require 'vistas/Paginador/vPaginador.php';
}
?>
</div>
