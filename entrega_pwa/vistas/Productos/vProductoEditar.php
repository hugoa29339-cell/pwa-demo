<?php
// Se inicializa la variable $producto con datos recibidos o valores por defecto para nuevo producto
$producto = $datos['producto'] ?? [
    'idProducto' => 0, // 0 indica producto nuevo
    'producto' => '', // Nombre vacío inicialmente
    'descripcion' => '', // Descripción vacía
    'precioVenta' => '', // Precio vacío
    'stock' => '', // Stock vacío
    'activo' => 'S', // Por defecto activo
];
// Variable booleana para saber si es creación o edición según idProducto
$esNuevo = ($producto['idProducto'] == 0);
// Título cambia dinámicamente según contexto
$titulo = $esNuevo ? 'Nuevo Producto' : 'Editar Producto';
?>

<!-- Formulario para crear o editar producto -->
<form id="formularioProducto" name="formularioProducto" action="">
    <!-- Campo oculto para el ID (0 si es nuevo) -->
    <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">
    
    <!-- Título del formulario -->
    <h4 id="formLabel"><?= $titulo ?></h4>

    <div class="row">
        <!-- Campo para nombre del producto, obligatorio -->
        <div class="form-group col-md-12">
            <label for="producto">Nombre del Producto</label>
            <input type="text" class="form-control" id="producto" name="producto" 
                   value="<?= htmlspecialchars($producto['producto']) ?>" required>
            <div class="invalid-feedback"></div> <!-- Espacio para mensajes de error -->
        </div>
    </div>

    <div class="row mt-3">
        <!-- Campo para seleccionar la categoría del producto -->
        <div class="form-group col-md-6">
            <label for="idCategoria">Categoría</label>
            <select class="form-control" id="idCategoria" name="idCategoria" required>
                <option value="">Seleccione una categoría</option>
                <?php 
                // Asegurarse de que $datos['categorias'] existe y es un array
                if (isset($datos['categorias']) && is_array($datos['categorias'])):
                    foreach ($datos['categorias'] as $categoria): ?>
                        <option value="<?= $categoria['idCategoria'] ?>" 
                                <?= (isset($producto['idCategoria']) && $producto['idCategoria'] == $categoria['idCategoria']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['categoria']) ?>
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>
            <div class="invalid-feedback"></div>
        </div>
        
        <!-- Campo para descripción, opcional -->
        <div class="form-group col-md-6">
            <label for="descripcion">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" 
                   value="<?= htmlspecialchars($producto['descripcion']) ?>">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Campo para precio de venta (número con decimales), obligatorio -->
        <div class="form-group col-md-4">
            <label for="precioVenta">Precio de Venta</label>
            <input type="number" step="0.01" class="form-control" id="precioVenta" name="precioVenta" 
                   value="<?= htmlspecialchars($producto['precioVenta']) ?>" required>
            <div class="invalid-feedback"></div>
        </div>
        <!-- Campo para stock (número), opcional -->
        <div class="form-group col-md-4">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" 
                   value="<?= htmlspecialchars($producto['stock']) ?>">
        </div>
        <!-- Selector para estado activo o inactivo -->
        <div class="form-group col-md-4">
            <label for="activo">Estado</label>
            <select id="activo" name="activo" class="form-select">
                <option value="S" <?= ($producto['activo'] == 'S') ? 'selected' : '' ?>>Activo</option>
                <option value="N" <?= ($producto['activo'] == 'N') ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </div>

    <!-- Botones para guardar o cancelar -->
    <div class="mt-4">
        <button type="button" class="btn btn-primary" onclick="guardarProducto()">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" onclick="cancelarEdicion()">Cancelar</button>
    </div>
</form>