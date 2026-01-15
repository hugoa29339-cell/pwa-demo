<?php
// Vista principal de Pedidos con filtros
?>
<div class="container-fluid" id="capaFiltrosBusqueda">
  <form id="formularioBuscar" name="formularioBuscar" action="" onsubmit="buscar('Pedidos', 'getVistaListadoPedidos', 'formularioBuscar','capaResultadosBusqueda'); return false;">
    <div class="row">
      
      <!-- Filtro por Nombre Usuario con Datalist -->
      <div class="form-group col-md-4">
        <label for="nombreUsuario">Usuario / Nombre:</label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" 
               class="form-control form-control-sm" 
               list="usuariosSearchList"
               placeholder="Buscar por usuario..."
               oninput="buscar('Pedidos', 'getVistaListadoPedidos', 'formularioBuscar','capaResultadosBusqueda');">
        <datalist id="usuariosSearchList">
            <?php 
            $listaUsuarios = $datos['listaUsuarios'] ?? array();
            foreach($listaUsuarios as $u): ?>
                <option value="<?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido1']) ?> (<?= $u['login'] ?>)">
            <?php endforeach; ?>
        </datalist>
      </div>



    </div>
    <br>
    <div class="row">
      <div class="col-lg-12">
        <button type="button" class="btn btn-outline-primary btn-sm" 
          onclick="buscar('Pedidos', 'getVistaListadoPedidos', 'formularioBuscar','capaResultadosBusqueda');">
          Buscar Pedidos 🔎
        </button>
      </div> 
    </div>
  </form>
</div>

<div id="capaEditarCrear" class="container-fluid"></div>

<div id="capaResultadosBusqueda" class="container-fluid"></div>
