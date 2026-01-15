<?php
// Inicializa la variable $producto con valores vacíos fijos para crear un nuevo producto
$producto = [
    'idProducto' => 0, // ID 0 indica que es producto nuevo sin registro previo
    'producto' => '', // Nombre del producto vacío
    'descripcion' => '', // Descripción vacía
    'precioVenta' => '', // Precio de venta vacío
    'stock' => '', // Stock vacío
    'activo' => 'S', // Producto activo por defecto
];
// Título fijo para la creación
$titulo = 'Nuevo Producto';
?>

<!-- Formulario para crear un producto nuevo -->
<form id="formularioProducto" name="formularioProducto" action="">
    <!-- Campo oculto para pasar el id del producto (0 = nuevo producto) -->
    <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">

    <!-- Título que indica nueva creación -->
    <h4 id="formLabel"><?= $titulo ?></h4>

    <div class="row">
        <!-- Campo nombre de producto, obligatorio -->
        <div class="form-group col-md-12">
            <label for="producto">Nombre del Producto</label>
            <input type="text" class="form-control" id="producto" name="producto" 
                   value="<?= htmlspecialchars($producto['producto']) ?>" required>
            <div class="invalid-feedback"></div> <!-- Para mostrar error si validación falla -->
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
                        <option value="<?= $categoria['idCategoria'] ?>">
                            <?= htmlspecialchars($categoria['categoria']) ?>
                        </option>
                    <?php endforeach; 
                endif;
                ?>
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <!-- Campo descripción, no obligatorio -->
        <div class="form-group col-md-6">
            <label for="descripcion">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" 
                   value="<?= htmlspecialchars($producto['descripcion']) ?>">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Campo de precio de venta numérico con dos decimales, obligatorio -->
        <div class="form-group col-md-4">
            <label for="precioVenta">Precio de Venta</label>
            <input type="number" step="0.01" class="form-control" id="precioVenta" name="precioVenta" 
                   value="<?= htmlspecialchars($producto['precioVenta']) ?>" required>
            <div class="invalid-feedback"></div>
        </div>

        <!-- Campo stock numérico, opcional -->
        <div class="form-group col-md-4">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" 
                   value="<?= htmlspecialchars($producto['stock']) ?>">
        </div>

        <!-- Selector estado activo/inactivo -->
        <div class="form-group col-md-4">
            <label for="activo">Estado</label>
            <select id="activo" name="activo" class="form-select">
                <option value="S" <?= ($producto['activo'] == 'S') ? 'selected' : '' ?>>Activo</option>
                <option value="N" <?= ($producto['activo'] == 'N') ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </div>

    <!-- Botones para crear y cancelar -->
    <div class="mt-4">
        <button type="button" class="btn btn-primary" onclick="crearProducto()">Crear Producto</button> <!-- Llama JS para crear -->
        <button type="button" class="btn btn-secondary" onclick="cancelarEdicion()">Cancelar</button> <!-- Cierra formulario -->
    </div>
</form>