<?php
$pedido = $datos['pedido'] ?? array();
$detalles = $datos['detalles'] ?? array();

$idPedido = $pedido['idPedido'] ?? 0;
$titulo = 'Detalles del Pedido #' . $idPedido;
?>

<div class="container-fluid">
    <h4><?= $titulo ?></h4>
    <hr>
    
    <!-- CABECERA DEL PEDIDO -->
    <div class="row mb-3">
        <!-- Usuario -->
        <div class="col-md-3">
            <label class="form-label fw-bold">Usuario</label>
            <p class="form-control-plaintext"><?= htmlspecialchars($pedido['nombreUsuario'] ?? 'N/A') ?></p>
        </div>
        
        <!-- Fecha Pedido -->
        <div class="col-md-3">
            <label class="form-label fw-bold">Fecha Pedido</label>
            <p class="form-control-plaintext"><?= !empty($pedido['fechaPedido']) ? date('d/m/Y', strtotime($pedido['fechaPedido'])) : 'N/A' ?></p>
        </div>

        <!-- Transporte -->
        <div class="col-md-3">
             <label class="form-label fw-bold">Transporte</label>
             <p class="form-control-plaintext"><?= htmlspecialchars($pedido['transporte'] ?? 'N/A') ?></p>
        </div>

        <!-- Dirección -->
        <div class="col-md-3">
             <label class="form-label fw-bold">Dirección de entrega</label>
             <p class="form-control-plaintext"><?= htmlspecialchars($pedido['direccion'] ?? 'N/A') ?></p>
        </div>
    </div>

    <div class="row mb-3">
         <!-- Resto de fechas con lógica de estado -->
         <?php
            $txtAlmacen = !empty($pedido['fechaAlmacen']) ? "✅ En almacén desde: " . date('d/m/Y', strtotime($pedido['fechaAlmacen'])) : "⏳ Pendiente de almacén";
            $txtEnvio = !empty($pedido['fechaEnvio']) ? "✅ Enviado el: " . date('d/m/Y', strtotime($pedido['fechaEnvio'])) : "⏳ Pendiente de envío";
            $txtRecibido = !empty($pedido['fechaRecibido']) ? "✅ Entregado el: " . date('d/m/Y', strtotime($pedido['fechaRecibido'])) : "⏳ Pendiente de entrega";
         ?>
        <div class="col-md-4">
            <label class="form-label fw-bold">Estado Almacén</label>
            <p class="form-control-plaintext"><?= $txtAlmacen ?></p>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">Estado Envío</label>
            <p class="form-control-plaintext"><?= $txtEnvio ?></p>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">Estado Recepción</label>
            <p class="form-control-plaintext"><?= $txtRecibido ?></p>
        </div>
    </div>

    <hr>
    <h5>Detalle del Pedido</h5>
    
    <!-- TABLA DE DETALLES -->
    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th style="width: 40%;">Producto</th>
                <th style="width: 20%;">Precio Unit.</th>
                <th style="width: 15%;">Cantidad</th>
                <th style="width: 25%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach($detalles as $d): 
                $subtotal = $d['precioVenta'] * $d['cantidad'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($d['producto'] ?? 'Producto #' . $d['idProducto']) ?></td>
                    <td><?= number_format($d['precioVenta'], 2, ',', '.') ?> €</td>
                    <td><?= $d['cantidad'] ?></td>
                    <td><?= number_format($subtotal, 2, ',', '.') ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total Pedido:</td>
                <td class="fw-bold"><?= number_format($total, 2, ',', '.') ?> €</td>
            </tr>
        </tfoot>
    </table>
    
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
        <button type="button" class="btn btn-secondary" onclick="cancelarEdicion()">Volver</button>
    </div>
</div>
