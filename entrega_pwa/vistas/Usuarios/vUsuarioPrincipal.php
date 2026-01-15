<?php
// Este archivo es la vista con el formulario de filtros para buscar usuarios
?>

<!-- Contenedor principal para los filtros -->
<div class="container-fluid" id="capaFiltrosBusqueda">
  <!-- Formulario de búsqueda -->
  <form id="formularioBuscar" name="formularioBuscar" action="" onsubmit="buscar('Usuarios', 'getVistaListadoUsuarios', 'formularioBuscar','capaResultadosBusqueda'); return false;">
    <div class="row">
      <!-- Campo de texto para buscar por nombre o cualquier texto -->
      <div class="form-group col-md-3 col-sm-3 col-xs-6">
        <label for="ftexto">Nombre/texto:</label><br>
        <input type="text" id="ftexto" name="ftexto" 
          class="form-control form-control-sm" 
          placeholder="Texto a buscar" value=""/> <!-- Campo vacío inicialmente -->
      </div>

      <!-- Selector para estado activo o no -->
      <div class="form-group col-md-3 col-sm-3 col-xs-6">
        <label for="factivo">Estado:</label><br>
        <select id="factivo" name="factivo" class="form-select form-select-sm">
          <option value="" selected>Todos</option> <!-- Opción para todos -->
          <option value="S">Activos</option> <!-- Usuarios activos -->
          <option value="N">NO activos</option> <!-- Usuarios inactivos -->
        </select>
      </div>
    </div>
    <br>
    <div class="row">
      <!-- Botón buscar que llama a la función JavaScript buscar() -->
      <div class="col-lg-12">
        <button type="button" class="btn btn-outline-primary btn-sm" 
          onclick="buscar('Usuarios', 'getVistaListadoUsuarios', 'formularioBuscar','capaResultadosBusqueda');">
          Buscar 🔎
        </button>
      </div> 
    </div>
  </form>
</div>

<!-- Contenedor donde se carga el listado de resultados después de buscar -->
<div id="capaResultadosBusqueda" class="container-fluid" ></div>