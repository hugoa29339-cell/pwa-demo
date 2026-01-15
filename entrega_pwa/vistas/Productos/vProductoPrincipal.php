<?php
// No hay PHP específico en esta vista, es un formulario HTML para filtros de búsqueda
?>

<!-- Contenedor principal para filtros de búsqueda -->
<div class="container-fluid" id="capaFiltrosBusqueda">
  <!-- Formulario con ID y nombre para usar en JavaScript -->
  <form id="formularioBuscar" name="formularioBuscar" action="" onsubmit="buscar('Productos', 'getVistaListadoProductos', 'formularioBuscar','capaResultadosBusqueda'); return false;">
    <div class="row">
      <!-- Campo de texto para buscar productos por nombre o texto relacionado -->
      <div class="form-group col-md-3 col-sm-3 col-xs-6">
        <label for="ftexto" >Nombre/texto:</label><br>
        <input type="text" id="ftexto" name="ftexto" 
          class="form-control form-control-sm" 
          placeholder="Texto a buscar" value=""/> <!-- Inicialmente vacío -->
      </div>
      
      <!-- Selector para filtrar por estado activo o no -->
      <div class="form-group col-md-3 col-sm-3 col-xs-6">
        <label for="factivo" >Estado:</label><br>
        <select id="factivo" name="factivo" class="form-select form-select-sm">
          <option value="" selected>Todos</option> <!-- Opción por defecto: todos -->
          <option value="S">Activos</option> <!-- Solo activos -->
          <option value="N">NO activos</option> <!-- Solo inactivos -->
        </select>
      </div>
    </div>
    <br>
    <div class="row">
      <!-- Botón para realizar la búsqueda, llama a función JS buscar() con parámetros -->
      <div class="col-lg-12">
        <button type="button" class="btn btn-outline-primary btn-sm" 
          onclick="buscar('Productos', 'getVistaListadoProductos', 'formularioBuscar','capaResultadosBusqueda');">Buscar 🔎</button>
      </div> 
    </div>
  </form>
</div>

<!-- Contenedor oculta/visible para formularios de crear/editar productos -->
<div id="capaEditarCrear" class="container-fluid" ></div>

<!-- Contenedor donde se muestran los resultados de la búsqueda -->
<div id="capaResultadosBusqueda" class="container-fluid" ></div>