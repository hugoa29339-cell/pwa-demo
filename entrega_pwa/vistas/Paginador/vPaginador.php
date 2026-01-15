<?php
// Variables que la vistaa necesita:
// $total_resultados: Número total de resultados de la consulta.
// $resultados_por_pagina: Número de resultados a mostrar por página.
// $pagina_actual: La página que se está mostrando actualmente.
// $url: La URL base para las llamadas AJAX (apuntando a CFrontal.php).

if (empty($total_resultados) || empty($resultados_por_pagina)) {
    return; // No mostrar nada si no hay resultados o configuración.
}

$total_paginas = ceil($total_resultados / $resultados_por_pagina);

if ($total_paginas <= 1) {
    // Si solo hay una página, mostramos solo la info de resultados pero sin enlaces.
    echo '<nav class="paginador-container mt-4"><div class="info-resultados mb-3 mb-md-0">
            Mostrando <strong>' . $total_resultados . '</strong> de <strong>' . $total_resultados . '</strong> resultados totales.
          </div></nav>';
    return;
}

// Helper para añadir parámetros a la URL de forma segura.
function anadir_param_url($url, $param, $valor) {
    $simbolo = (strpos($url, '?') === false) ? '?' : '&';
    return $url . $simbolo . htmlspecialchars($param) . '=' . htmlspecialchars($valor);
}

// Construye la URL base que ya incluye el número de resultados por página actual.
$url_con_resultados = anadir_param_url($url, 'resultados_por_pagina', $resultados_por_pagina);

?>

<nav aria-label="Navegación de páginas" class="paginador-container mt-4">
    <div class="info-resultados mb-3 mb-md-0">
        Mostrando resultados en página <strong><?php echo $pagina_actual; ?></strong> de <strong><?php echo $total_paginas; ?></strong>
        (<?php echo $total_resultados; ?> resultados totales)
    </div>

    <ul class="pagination justify-content-center align-items-center flex-wrap">
        <!-- Primera Página -->
        <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="javascript:void(0);" onclick="ajaxNavigate('<?php echo anadir_param_url($url_con_resultados, 'pagina', 1); ?>')" aria-label="Primera">
                <span aria-hidden="true">&laquo;&laquo;</span>
            </a>
        </li>

        <!-- Página Anterior -->
        <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="javascript:void(0);" onclick="ajaxNavigate('<?php echo anadir_param_url($url_con_resultados, 'pagina', $pagina_actual - 1); ?>')" aria-label="Anterior">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <!-- Ir a la página -->
        <li class="page-item-label d-none d-sm-block mx-2">Página</li>
        <li class="page-item-input">
            <div class="d-flex">
                <input type="number" id="paginaIrInput" class="form-control form-control-sm" value="<?php echo $pagina_actual; ?>" min="1" max="<?php echo $total_paginas; ?>" style="width: 70px;" onkeyup="if(event.keyCode===13) document.getElementById('btnIrPagina').click()">
                <button id="btnIrPagina" type="button" class="btn btn-sm btn-primary ms-1" onclick="ajaxNavigate('<?php echo $url_con_resultados; ?>&pagina=' + document.getElementById('paginaIrInput').value)">Ir</button>
            </div>
        </li>
        <li class="page-item-label d-none d-sm-block mx-2">de <?php echo $total_paginas; ?></li>
        
        <!-- Página Siguiente -->
        <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
            <a class="page-link" href="javascript:void(0);" onclick="ajaxNavigate('<?php echo anadir_param_url($url_con_resultados, 'pagina', $pagina_actual + 1); ?>')" aria-label="Siguiente">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>

        <!-- Última Página -->
        <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
            <a class="page-link" href="javascript:void(0);" onclick="ajaxNavigate('<?php echo anadir_param_url($url_con_resultados, 'pagina', $total_paginas); ?>')" aria-label="Última">
                <span aria-hidden="true">&raquo;&raquo;</span>
            </a>
        </li>
    </ul>

    <div class="resultados-por-pagina ms-md-3 mt-3 mt-md-0">
        <div class="d-flex align-items-center">
            <label for="resultadosPorPaginaSelect" class="form-label me-2 mb-0">Resultados:</label>
            <select id="resultadosPorPaginaSelect" class="form-select form-select-sm" onchange="ajaxNavigate('<?php echo $url; ?>&pagina=1&resultados_por_pagina=' + this.value)" style="width: 80px;">
                <option value="5" <?php echo ($resultados_por_pagina == 5) ? 'selected' : ''; ?>>5</option>
                <option value="10" <?php echo ($resultados_por_pagina == 10) ? 'selected' : ''; ?>>10</option>
                <option value="15" <?php echo ($resultados_por_pagina == 15) ? 'selected' : ''; ?>>15</option>
                <option value="20" <?php echo ($resultados_por_pagina == 20) ? 'selected' : ''; ?>>20</option>
            </select>
        </div>
    </div>
</nav>
