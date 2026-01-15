<?php
$pedido = $datos['pedido'] ?? array();
$detalles = $datos['detalles'] ?? array();
$listaProductos = $datos['listaProductos'] ?? array();
$listaUsuarios = $datos['listaUsuarios'] ?? array();

$idPedido = $pedido['idPedido'] ?? 0;
$esNuevo = ($idPedido == 0);
$titulo = $esNuevo ? 'Nuevo Pedido' : 'Editar Pedido #' . $idPedido;

// Preparamos lista de productos para JS
$jsonProductos = json_encode($listaProductos);
?>

<form id="formularioPedido" name="formularioPedido">
    <input type="hidden" name="idPedido" value="<?= $idPedido ?>">
    
    <h4><?= $titulo ?></h4>
    <hr>
    
    <!-- CABECERA DEL PEDIDO -->
    <div class="row mb-3">
        <!-- Usuario -->
        <div class="col-md-3">
            <label for="idUsuario" class="form-label">Usuario</label>
            <?php 
                $nombreUser = '';
                if (isset($pedido['nombre'])) {
                    $nombreUser = $pedido['nombre'] . ' ' . ($pedido['apellido1'] ?? '') . ' (' . ($pedido['login'] ?? '') . ')';
                }
            ?>
            <input type="text" 
                   class="form-control" 
                   id="usuarioSearch" 
                   list="usuariosList"
                   placeholder="Buscar usuario..."
                   value="<?= htmlspecialchars($nombreUser) ?>"
                   <?= !$esNuevo ? 'disabled' : 'required' ?>>
            <datalist id="usuariosList">
                <?php foreach($listaUsuarios as $u): ?>
                    <option value="<?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido1']) ?> (<?= $u['login'] ?>)" 
                            data-id="<?= $u['idUsuario'] ?>">
                <?php endforeach; ?>
            </datalist>
            <input type="hidden" name="idUsuario" id="idUsuario" value="<?= $pedido['idUsuario'] ?? '' ?>" required>
        </div>
        
        <!-- Fecha Pedido -->
        <div class="col-md-3">
            <label for="fechaPedido" class="form-label">Fecha Pedido</label>
            <input type="text" class="form-control" id="fechaPedidoDisplay" 
                   value="<?= !empty($pedido['fechaPedido']) ? date('d/m/Y', strtotime($pedido['fechaPedido'])) : date('d/m/Y') ?>" readonly>
            <input type="hidden" name="fechaPedido" value="<?= $pedido['fechaPedido'] ?? date('Y-m-d') ?>">
        </div>

        <!-- Transporte -->
        <div class="col-md-3">
             <label for="transporte" class="form-label">Transporte</label>
             <input type="text" class="form-control" id="transporte" name="transporte" 
                    value="<?= htmlspecialchars($pedido['transporte'] ?? '') ?>" placeholder="Ej: DHL">
        </div>

        <!-- Dirección -->
        <div class="col-md-3">
             <label for="direccion" class="form-label">Dirección de entrega</label>
             <input type="text" class="form-control" id="direccion" name="direccion" 
                    value="<?= htmlspecialchars($pedido['direccion'] ?? '') ?>" required>
        </div>
    </div>

    <div class="row mb-3">
         <!-- Resto de fechas con lógica de estado -->
         <?php
            $txtAlmacen = !empty($pedido['fechaAlmacen']) ? "✅ En almacén desde: " . $pedido['fechaAlmacen'] : "⏳ Pendiente de almacén";
            $txtEnvio = !empty($pedido['fechaEnvio']) ? "✅ Enviado el: " . $pedido['fechaEnvio'] : "⏳ Pendiente de envío";
            $txtRecibido = !empty($pedido['fechaRecibido']) ? "✅ Entregado el: " . $pedido['fechaRecibido'] : "⏳ Pendiente de entrega";
         ?>
        <div class="col-md-4">
            <label for="fechaAlmacen" class="form-label">Estado Almacén</label>
            <input type="text" class="form-control" value="<?= $txtAlmacen ?>" readonly>
            <!-- Mantenemos el hidden por si acaso se necesitara enviar, aunque al ser readonly/disabled no suele hacer falta para updates parciales -->
            <input type="hidden" name="fechaAlmacen" value="<?= $pedido['fechaAlmacen'] ?? '' ?>">
        </div>
        <div class="col-md-4">
            <label for="fechaEnvio" class="form-label">Estado Envío</label>
            <input type="text" class="form-control" value="<?= $txtEnvio ?>" readonly>
            <input type="hidden" name="fechaEnvio" value="<?= $pedido['fechaEnvio'] ?? '' ?>">
        </div>
        <div class="col-md-4">
            <label for="fechaRecibido" class="form-label">Estado Recepción</label>
            <input type="text" class="form-control" value="<?= $txtRecibido ?>" readonly>
            <input type="hidden" name="fechaRecibido" value="<?= $pedido['fechaRecibido'] ?? '' ?>">
        </div>
    </div>

    <hr>
    <h5>Detalle del Pedido</h5>
    
    <!-- TABLA DE DETALLES -->
    <table class="table table-bordered table-sm" id="tablaDetalles">
        <thead class="table-light">
            <tr>
                <th style="width: 40%;">Producto</th>
                <th style="width: 15%;">Precio Unit.</th>
                <th style="width: 15%;">Cantidad</th>
                <th style="width: 20%;">Subtotal</th>
                <th style="width: 10%;">Acción</th>
            </tr>
        </thead>
        <tbody id="bodyDetalles">
            <!-- Las filas se generarán con JS -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total Pedido:</td>
                <td class="fw-bold"><span id="totalPedido">0.00</span> €</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <button type="button" class="btn btn-info btn-sm mb-4" onclick="agregarLinea()">+ Añadir Producto</button>
    
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" class="btn btn-secondary me-md-2" onclick="cancelarEdicion()">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarPedidoJS()">Guardar Pedido</button>
    </div>

    <!-- Datos ocultos para JS -->
    <input type="hidden" id="jsonProductos" value='<?= htmlspecialchars($jsonProductos, ENT_QUOTES) ?>'>
    <input type="hidden" id="jsonDetalles" value='<?= htmlspecialchars(json_encode($detalles), ENT_QUOTES) ?>'>
    <input type="hidden" id="esNuevoPedido" value="<?= $esNuevo ? '1' : '0' ?>">

    <!-- Hack para inicializar el JS de pedidos al cargar la vista -->
    <img src="" onerror="if(window.initPedido) window.initPedido(); this.remove();" style="display:none;">

</form>
