<?php 
    // Verifica si $datos contiene 'productos', si es así los asigna a $productos, sino crea array vacío
    if(isset($datos) && isset($datos['productos'])){
        $productos = $datos['productos'];
    } else {
        $productos = array();
    }
?>
<div class="table-container">
    <div class="table-actions">
        <!-- Botón para abrir formulario para crear producto nuevo -->
        <button class="btn btn-success btn-sm" onclick="editarCrear('Productos', 'getVistaProductoCrear', 'capaEditarCrear')">Crear Producto 📦</button>
    </div>
    <table class="table table-sm">
        <thead>
            <tr>
                <!-- Cabeceras de la tabla de productos -->
                <th>Producto</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($productos) > 0): ?>
                <!-- Loop que recorre cada producto y crea una fila para cada uno -->
                <?php foreach ($productos as $producto): ?>
                    <tr id="filaProducto<?= $producto['idProducto'] ?>">
                        <td>
                            <!-- Botón para editar producto, carga formulario con AJAX -->
                            <button 
                                class="btn btn-primary btn-sm"
                                onclick="editarCrear('Productos', 'getVistaProductoEditar', 'capaEditarCrear', { idProducto: <?= $producto['idProducto'] ?> })">
                                Editar✏️
                            </button>
                            <!-- Nombre del producto escapado para seguridad -->
                            <?= htmlspecialchars($producto['producto']) ?>
                        </td>
                        <td><?= htmlspecialchars($producto['descripcion']) ?></td> <!-- Descripción -->
                        <td><?= htmlspecialchars($producto['categoria'] ?? 'Sin categoría') ?></td> <!-- Categoría -->
                        <td><?= htmlspecialchars($producto['precioVenta']) ?> €</td> <!-- Precio con € -->
                        <td><?= htmlspecialchars($producto['stock']) ?></td> <!-- Cantidad disponible -->
                        <td>
                            <!-- Indicador visual de si el producto está activo -->
                            <?= ($producto['activo'] ?? '') === 'S'
                                ? '<span class="badge text-bg-success" style="min-width:52px;display:inline-block;text-align:center;">Sí✅</span>'
                                : '<span class="badge text-bg-danger" style="min-width:52px;display:inline-block;text-align:center;">No❌</span>'
                            ?>
                        </td>
                        <td>
                            <!-- Botón para borrar producto con confirmación y AJAX -->
                            <button 
                                class="btn btn-danger btn-sm" 
                                onclick="borrar('Productos', 'borrarProducto', { idProducto: <?= $producto['idProducto'] ?> }, 'filaProducto<?= $producto['idProducto'] ?>')">
                                Borrar🗑️
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mensaje si no hay productos para mostrar -->
                <tr>
                    <td colspan="7" class="text-center">No se encontraron productos</td>
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
    ?></div>