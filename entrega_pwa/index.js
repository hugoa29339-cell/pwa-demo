// --- INICIO CAMBIO: FUNCIÓN CENTRALIZADA PARA MANEJAR ERRORES DE AUTORIZACIÓN ---
// Esta función se ha añadido para interceptar todas las respuestas de las peticiones fetch.
function handleResponse(response) {
    // Comprueba si el estado de la respuesta es 401 'Unauthorized', que es lo que
    // CFrontal.php devuelve cuando no hay una sesión de usuario activa.
    if (response.status === 401) {
        // Si el usuario no está autorizado, se le redirige inmediatamente a la página de login.
        window.location.href = 'login.php';
        // Se rechaza la promesa para detener la ejecución del resto del código de la petición.
        return Promise.reject('Unauthorized');
    }
    // Si el estado no es 401, se devuelve la respuesta para que el resto del código la procese.
    return response;
}
// --- FIN CAMBIO ---

// FUNCIÓN: Obtener y cargar una vista por AJAX
function obtenerVista(controlador, metodo, capa) {
    let parametros = "controlador=" + controlador + "&metodo=" + metodo;
    let opciones = { method: "GET" };
    fetch("CFrontal.php?" + parametros, opciones)
        // --- INICIO CAMBIO: APLICAR EL MANEJADOR DE RESPUESTAS ---
        // Se ha añadido .then(handleResponse) después de cada 'fetch'.
        // Esto asegura que la función 'handleResponse' sea lo primero que se ejecute
        // en cuanto se reciba una respuesta del servidor, antes de cualquier otra lógica.
        .then(handleResponse)
        // --- FIN CAMBIO ---
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Network response was not ok.');
        })
        .then(vista => {
            document.getElementById(capa).innerHTML = vista;
        })
        .catch(error => {
            // Se añade esta comprobación para no mostrar un error en la consola cuando
            // la redirección por 'Unauthorized' ocurre, ya que es un comportamiento esperado.
            if (error !== 'Unauthorized') {
                console.error('There has been a problem with your fetch operation:', error);
            }
        });
}
//FIN obtenerVista


// FUNCIÓN: Buscar con filtros de formulario
function buscar(controlador, metodo, formulario, destino) {
    let parametros = "controlador=" + controlador + "&metodo=" + metodo; // Parámetros base
    parametros += "&" + new URLSearchParams(new FormData(document.getElementById(formulario))).toString(); // Añade datos del formulario
    let opciones = { method: "GET", }; // Petición GET
    fetch("CFrontal.php?" + parametros, opciones) // Envía petición con filtros
        .then(handleResponse) // Maneja posible 401
        .then(res => {
            if (res.ok) { // Si respuesta OK
                return res.text(); // Convierte a texto
            }
        })
        .then(vista => {
            document.getElementById(destino).innerHTML = vista; // Inserta resultado en capa destino
        })
        .catch(err => {
            if (err !== 'Unauthorized') {
                document.getElementById(destino).innerHTML = 'Se ha producido un error, vuelva intentarlo'; // Muestra mensaje de error
            }
        })

} //FIN buscar


// FUNCIÓN: Cargar formulario de edición o creación
function editarCrear(controlador, metodo, capa, params = {}) {
    let parametros = `controlador=${controlador}&metodo=${metodo}`; // Parámetros base
    // Añadir parámetros adicionales, como el id para editar
    if (params) { // Si hay parámetros adicionales (ej: idUsuario)
        for (const key in params) {
            parametros += `&${key}=${params[key]}`; // Añade cada parámetro a la URL
        }
    }

    fetch(`CFrontal.php?${parametros}`) // Hace petición con parámetros
        .then(handleResponse) // Maneja posible 401
        .then(response => response.ok ? response.text() : Promise.reject('Error al cargar la vista.')) // Valida respuesta
        .then(vista => {
            // Ocultar las capas principales y mostrar la de edición/creación
            if (document.getElementById('capaFiltrosBusqueda')) {
                document.getElementById('capaFiltrosBusqueda').style.display = 'none'; // Oculta filtros
            }
            if (document.getElementById('capaResultadosBusqueda')) {
                document.getElementById('capaResultadosBusqueda').style.display = 'none'; // Oculta resultados
            }
            const capaEditarCrear = document.getElementById(capa); // Obtiene capa de formulario
            capaEditarCrear.innerHTML = vista; // Inserta formulario
            capaEditarCrear.style.display = 'block'; // Muestra formulario
        })
        .catch(error => {
            if (error !== 'Unauthorized') {
                console.error('Error en editarCrear:', error); // Muestra error en consola
                alert('No se pudo cargar el formulario.'); // Alerta al usuario
            }
        });
}


// FUNCIÓN: Borrar un registro con confirmación
function borrar(controlador, metodo, params, filaId) {
    if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) { // Pide confirmación
        return; // Si cancela, detiene función
    }

    const formData = new FormData(); // Crea FormData para enviar POST
    formData.append('controlador', controlador); // Añade controlador
    formData.append('metodo', metodo); // Añade método
    for (const key in params) { // Recorre parámetros adicionales
        formData.append(key, params[key]); // Añade cada parámetro (ej: idUsuario)
    }

    fetch("CFrontal.php", { // Envía petición POST
        method: 'POST',
        body: formData
    })
        .then(handleResponse) // Maneja posible 401
        .then(response => response.json()) // Espera respuesta JSON
        .then(data => {
            if (data.success) { // Si eliminación exitosa
                // Eliminar la fila de la tabla
                const fila = document.getElementById(filaId); // Busca fila por ID
                if (fila) {
                    fila.remove(); // Elimina fila del DOM
                } else {
                    // Si no se puede eliminar la fila, refrescar la lista
                    document.querySelector('#capaFiltrosBusqueda button[onclick*="buscar"]').click(); // Simula clic en buscar
                }
            } else {
                alert('Error: ' + (data.message || 'No se pudo eliminar el elemento.')); // Muestra error
            }
        })
        .catch(error => {
            if (error !== 'Unauthorized') {
                console.error('Error en la comunicación:', error); // Error en consola
                alert('Ha ocurrido un error de comunicación. Por favor, inténtelo de nuevo.'); // Alerta usuario
            }
        });
}


// FUNCIÓN: Cancelar edición y volver a listado
function cancelarEdicion() {
    const capaEditar = document.getElementById('capaEditarCrear'); // Obtiene capa de formulario
    capaEditar.innerHTML = ''; // Vacía contenido
    capaEditar.style.display = 'none'; // Oculta capa
    document.getElementById('capaFiltrosBusqueda').style.display = 'block'; // Muestra filtros
    document.getElementById('capaResultadosBusqueda').style.display = 'block'; // Muestra resultados
}


// FUNCIÓN: Cancelar creación y volver a listado
function cancelarCreacion() {
    const capaCrear = document.getElementById('capaEditarCrear'); // Obtiene capa de formulario
    capaCrear.innerHTML = ''; // Vacía contenido
    capaCrear.style.display = 'none'; // Oculta capa
    document.getElementById('capaFiltrosBusqueda').style.display = 'block'; // Muestra filtros
    document.getElementById('capaResultadosBusqueda').style.display = 'block'; // Muestra resultados
}


// --- FUNCIONES PARA USUARIOS ---


// FUNCIÓN: Generar login automáticamente desde nombre y apellido
function generarLogin() {
    const nombre = document.getElementById('nombre').value; // Obtiene valor del nombre
    const apellido1 = document.getElementById('apellido1').value; // Obtiene primer apellido
    const loginInput = document.getElementById('login'); // Obtiene campo login

    if (nombre.length > 0 && apellido1.length > 0) { // Si ambos campos tienen valor
        const primeraLetra = nombre.charAt(0).toLowerCase(); // Primera letra del nombre en minúscula
        const apellido = apellido1.toLowerCase().replaceAll(' ', ''); // Apellido en minúscula sin espacios
        loginInput.value = primeraLetra + apellido; // Genera login: primera letra + apellido
    } else {
        loginInput.value = ''; // Si falta alguno, deja login vacío
    }
}


// FUNCIÓN: Validar formulario de usuario en el cliente
function validarFormularioUsuario(form, esNuevo) {
    let esValido = true; // Bandera de validación
    // Limpiar errores previos
    form.querySelectorAll('input').forEach(input => { // Recorre todos los inputs
        input.classList.remove('is-invalid'); // Quita clase de error
        const errorDiv = input.nextElementSibling; // Obtiene div de mensaje error
        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
            errorDiv.textContent = ''; // Limpia mensaje
        }
    });

    // Función para mostrar un error
    const mostrarError = (idCampo, mensaje) => {
        esValido = false; // Marca como no válido
        const campo = form.querySelector(`#${idCampo}`); // Busca campo por ID
        campo.classList.add('is-invalid'); // Añade clase de error (borde rojo)
        campo.nextElementSibling.textContent = mensaje; // Muestra mensaje de error
    };

    // Validaciones
    if (!form.nombre.value.trim()) mostrarError('nombre', 'El nombre es obligatorio.'); // Valida nombre
    if (!form.apellido1.value.trim()) mostrarError('apellido1', 'El primer apellido es obligatorio.'); // Valida apellido
    if (!form.login.value.trim()) mostrarError('login', 'El login es obligatorio.'); // Valida login
    if (esNuevo && !form.pass.value) mostrarError('pass', 'La contraseña es obligatoria para nuevos usuarios.'); // Contraseña solo obligatoria si es nuevo

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar email
    if (!form.mail.value.trim()) {
        mostrarError('mail', 'El email es obligatorio.'); // Email vacío
    } else if (!emailRegex.test(form.mail.value)) {
        mostrarError('mail', 'El formato del email no es válido.'); // Email con formato incorrecto
    }

    const movilRegex = /^[0-9]+$/; // Expresión regular: solo números
    if (form.movil.value.trim() && !movilRegex.test(form.movil.value)) {
        mostrarError('movil', 'El móvil solo debe contener números.'); // Móvil con caracteres no numéricos
    }

    return esValido; // Devuelve true si todo está OK, false si hay errores
}


// FUNCIÓN: Guardar o actualizar usuario (privada, usada por crear y guardar)
function _guardarDatosUsuario(esNuevo) {
    const form = document.getElementById('formularioUsuario'); // Obtiene formulario
    if (!validarFormularioUsuario(form, esNuevo)) { // Valida en cliente primero
        return; // Detiene la ejecución si la validación falla
    }

    const formData = new FormData(form); // Crea FormData con datos del formulario
    formData.append('controlador', 'Usuarios'); // Añade controlador
    formData.append('metodo', esNuevo ? 'crearUsuario' : 'actualizarUsuario'); // Método según si es nuevo o edición

    fetch("CFrontal.php", { // Envía POST al servidor
        method: 'POST',
        body: formData
    })
        .then(handleResponse) // Maneja posible 401
        .then(response => response.json()) // Espera respuesta JSON
        .then(data => {
            if (data.success) { // Si el servidor responde éxito
                // Si tiene éxito, cerramos el formulario y refrescamos la lista
                esNuevo ? cancelarCreacion() : cancelarEdicion(); // Cierra formulario
                // Simulamos clic en el botón de búsqueda para refrescar
                document.querySelector('#capaFiltrosBusqueda button[onclick*="buscar"]').click(); // Refresca listado
            } else {
                // Si el servidor devuelve errores de validación
                if (data.errors) { // Si hay errores específicos de campos
                    Object.keys(data.errors).forEach(key => { // Recorre cada error
                        const campo = form.querySelector(`#${key}`); // Busca campo
                        if (campo) {
                            campo.classList.add('is-invalid'); // Marca como inválido
                            campo.nextElementSibling.textContent = data.errors[key]; // Muestra mensaje del servidor
                        }
                    });
                } else {
                    // Error general
                    alert('Error: ' + (data.message || 'Error desconocido.')); // Alerta genérica
                }
            }
        })
        .catch(error => {
            if (error !== 'Unauthorized') {
                console.error('Error en la comunicación:', error); // Error en consola
                alert('Ha ocurrido un error de comunicación. Por favor, inténtelo de nuevo.'); // Alerta al usuario
            }
        });
}


// FUNCIÓN: Crear nuevo usuario (wrapper)
function crearUsuario() {
    _guardarDatosUsuario(true); // Llama función interna con true (es nuevo)
}


// FUNCIÓN: Actualizar usuario existente (wrapper)
function guardarUsuario() {
    _guardarDatosUsuario(false); // Llama función interna con false (es edición)
}


// --- FUNCIONES PARA PRODUCTOS ---


// FUNCIÓN: Validar formulario de producto en el cliente
function validarFormularioProducto(form, esNuevo) {
    let esValido = true; // Bandera de validación
    form.querySelectorAll('input').forEach(input => { // Limpia errores previos
        input.classList.remove('is-invalid');
        const errorDiv = input.nextElementSibling;
        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
            errorDiv.textContent = '';
        }
    });

    const mostrarError = (idCampo, mensaje) => { // Función para mostrar error
        esValido = false;
        const campo = form.querySelector(`#${idCampo}`);
        campo.classList.add('is-invalid');
        campo.nextElementSibling.textContent = mensaje;
    };

    if (!form.producto.value.trim()) mostrarError('producto', 'El nombre del producto es obligatorio.'); // Valida nombre producto

    const precio = form.precioVenta.value.trim(); // Obtiene precio
    if (!precio) {
        mostrarError('precioVenta', 'El precio es obligatorio.'); // Precio vacío
    } else if (isNaN(precio)) {
        mostrarError('precioVenta', 'El precio debe ser un número.'); // Precio no numérico
    }

    return esValido; // Devuelve resultado de validación
}


// FUNCIÓN: Guardar o actualizar producto (privada, usada por crear y guardar)
function _guardarDatosProducto(esNuevo) {
    const form = document.getElementById('formularioProducto'); // Obtiene formulario
    if (!validarFormularioProducto(form, esNuevo)) { // Valida en cliente
        return; // Detiene si falla validación
    }

    const formData = new FormData(form); // Crea FormData
    formData.append('controlador', 'Productos'); // Añade controlador
    formData.append('metodo', esNuevo ? 'crearProducto' : 'actualizarProducto'); // Método según contexto

    fetch("CFrontal.php", { // Envía POST
        method: 'POST',
        body: formData
    })
        .then(handleResponse) // Maneja posible 401
        .then(response => response.json()) // Espera JSON
        .then(data => {
            if (data.success) { // Si éxito
                esNuevo ? cancelarCreacion() : cancelarEdicion(); // Cierra formulario
                document.querySelector('#capaFiltrosBusqueda button[onclick*="buscar"]').click(); // Refresca listado
            } else {
                if (data.errors) { // Si hay errores de campos
                    Object.keys(data.errors).forEach(key => {
                        const campo = form.querySelector(`#${key}`);
                        if (campo) {
                            campo.classList.add('is-invalid');
                            campo.nextElementSibling.textContent = data.errors[key];
                        }
                    });
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido.')); // Error genérico
                }
            }
        })
        .catch(error => {
            if (error !== 'Unauthorized') {
                console.error('Error en la comunicación:', error); // Error consola
                alert('Ha ocurrido un error de comunicación. Por favor, inténtelo de nuevo.'); // Alerta
            }
        });
}


// FUNCIÓN: Crear nuevo producto (wrapper)
function crearProducto() {
    _guardarDatosProducto(true); // Llama función interna con true
}


// FUNCIÓN: Actualizar producto existente (wrapper)
function guardarProducto() {
    _guardarDatosProducto(false); // Llama función interna con false
}

// --- FUNCIÓN PARA PAGINACIÓN AJAX ---

function ajaxNavigate(url) {
    const destino = 'capaResultadosBusqueda';
    const formFiltros = document.getElementById('formularioBuscar');

    // Usamos el constructor de URL para manipular los parámetros fácilmente.
    // Se asume que la URL base es la página actual si no se especifica un dominio.
    const urlObj = new URL(url, window.location.href);

    // Si existe el formulario de filtros, tomamos sus valores actuales
    // y los añadimos a la URL de la petición.
    // Esto asegura que los filtros se mantienen al paginar.
    if (formFiltros) {
        const formData = new FormData(formFiltros);
        formData.forEach((value, key) => {
            urlObj.searchParams.set(key, value);
        });
    }

    // Realizamos la petición AJAX
    fetch(urlObj.href, { method: 'GET' })
        .then(handleResponse) // Maneja posible 401
        .then(res => {
            if (res.ok) {
                return res.text(); // Si la respuesta es correcta, la convertimos a texto (HTML)
            }
            // Si hay un error en la respuesta, rechazamos la promesa
            return Promise.reject('La respuesta del servidor no fue exitosa.');
        })
        .then(vista => {
            // Inyectamos el HTML recibido en el div de resultados
            document.getElementById(destino).innerHTML = vista;
        })
        .catch(err => {
            if (err !== 'Unauthorized') {
                // En caso de error, lo mostramos en la consola y en el div de resultados
                console.error('Error en ajaxNavigate:', err);
                document.getElementById(destino).innerHTML = '<div class="alert alert-danger">Se ha producido un error al cargar los datos. Por favor, inténtelo de nuevo.</div>';
            }
        });
}

// --- FUNCIONES PARA PEDIDOS (Movidas desde VPedidoEditar.php) ---

var listaProductosPedido = [];

function initPedido() {
    let inputProds = document.getElementById('jsonProductos');
    let inputDetalles = document.getElementById('jsonDetalles');

    if (inputProds && inputProds.value) {
        try {
            listaProductosPedido = JSON.parse(inputProds.value);
        } catch (e) { listaProductosPedido = []; }
    } else {
        listaProductosPedido = [];
    }

    let detallesExistentes = [];
    if (inputDetalles && inputDetalles.value) {
        try {
            detallesExistentes = JSON.parse(inputDetalles.value);
        } catch (e) { detallesExistentes = []; }
    }

    // Limpiar cuerpo tabla por si acaso
    let tbody = document.getElementById('bodyDetalles');
    if (tbody) tbody.innerHTML = '';

    if (detallesExistentes.length > 0) {
        detallesExistentes.forEach(d => {
            agregarLinea(d);
        });
    } else {
        // Si es nuevo, añadimos una línea vacía por defecto
        agregarLinea();
    }
    calcularTotalGlobal();

    // Setup user autocomplete
    const usuarioSearch = document.getElementById('usuarioSearch');
    const usuariosList = document.getElementById('usuariosList');
    const idUsuarioHidden = document.getElementById('idUsuario');

    if (usuarioSearch && usuariosList && idUsuarioHidden) {
        usuarioSearch.addEventListener('input', function () {
            const selectedOption = Array.from(usuariosList.options).find(
                option => option.value === this.value
            );

            if (selectedOption) {
                idUsuarioHidden.value = selectedOption.getAttribute('data-id');
            }
        });
    }
}

function agregarLinea(datos = null) {
    const tbody = document.getElementById('bodyDetalles');
    if (!tbody) return;

    const tr = document.createElement('tr');

    let idProd = datos ? datos.idProducto : '';
    let cantidad = datos ? datos.cantidad : 1;
    let precio = datos ? datos.precioVenta : 0;

    // Find product name if editing
    let productoNombre = '';
    if (idProd && listaProductosPedido) {
        const prod = listaProductosPedido.find(p => p.idProducto == idProd);
        if (prod) productoNombre = prod.producto;
    }

    // Generate unique ID for this row's datalist
    const rowId = 'row_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

    let optionsHtml = '';
    listaProductosPedido.forEach(p => {
        optionsHtml += `<option value="${p.producto}" data-id="${p.idProducto}" data-precio="${p.precioVenta}">`;
    });

    tr.innerHTML = `
        <td>
            <input type="text" 
                   class="form-control form-control-sm producto-search" 
                   list="productos_${rowId}"
                   placeholder="Buscar producto..."
                   value="${productoNombre}">
            <datalist id="productos_${rowId}">
                ${optionsHtml}
            </datalist>
            <input type="hidden" class="producto-id" value="${idProd}">
        </td>
        <td>
            <input type="number" class="form-control form-control-sm precio-input" step="0.01" value="${precio}" readonly>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm cantidad-input" min="1" value="${cantidad}" onchange="calcularSubtotal(this)">
        </td>
        <td>
            <span class="subtotal-span">${(precio * cantidad).toFixed(2)}</span> €
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-xs" onclick="eliminarLinea(this)">🗑</button>
        </td>
    `;

    tbody.appendChild(tr);

    // Add event listener for product selection
    const productoSearch = tr.querySelector('.producto-search');
    const datalistId = 'productos_' + rowId;

    productoSearch.addEventListener('input', function () {
        const datalist = document.getElementById(datalistId);
        const selectedOption = Array.from(datalist.options).find(
            option => option.value === this.value
        );

        if (selectedOption) {
            const productoId = selectedOption.getAttribute('data-id');
            const productoPrecio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;

            tr.querySelector('.producto-id').value = productoId;
            tr.querySelector('.precio-input').value = productoPrecio.toFixed(2);
            calcularSubtotal(tr.querySelector('.precio-input'));
        }
    });
}

function actualizarPrecio(select) {
    let precio = 0;
    let option = select.options[select.selectedIndex];
    if (option.value) {
        precio = parseFloat(option.getAttribute('data-precio')) || 0;
    }

    // Buscar el input de precio en la misma fila
    let tr = select.closest('tr');
    let precioInput = tr.querySelector('.precio-input');
    precioInput.value = precio.toFixed(2);

    calcularSubtotal(select);
}

function calcularSubtotal(elemento) {
    let tr = elemento.closest('tr');
    let precio = parseFloat(tr.querySelector('.precio-input').value) || 0;
    let cantidad = parseInt(tr.querySelector('.cantidad-input').value) || 1;

    let subtotal = precio * cantidad;
    tr.querySelector('.subtotal-span').textContent = subtotal.toFixed(2);

    calcularTotalGlobal();
}

function eliminarLinea(btn) {
    let tr = btn.closest('tr');
    tr.remove();
    calcularTotalGlobal();
}

function calcularTotalGlobal() {
    let total = 0;
    document.querySelectorAll('.subtotal-span').forEach(span => {
        total += parseFloat(span.textContent) || 0;
    });
    let elTotal = document.getElementById('totalPedido');
    if (elTotal) elTotal.textContent = total.toFixed(2);
}

function guardarPedidoJS() {
    // Validar formulario básico
    const form = document.getElementById('formularioPedido');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Recolectar detalles
    let detalles = [];
    let filas = document.querySelectorAll('#bodyDetalles tr');
    let error = false;

    filas.forEach(tr => {
        let idProd = tr.querySelector('.producto-id').value;
        let precio = tr.querySelector('.precio-input').value;
        let cantidad = tr.querySelector('.cantidad-input').value;

        if (!idProd) {
            error = true;
            alert('Debe seleccionar un producto en todas las líneas.');
            return;
        }

        detalles.push({
            idProducto: idProd,
            precioVenta: precio,
            cantidad: cantidad
        });
    });

    if (error) return;
    if (detalles.length === 0) {
        alert('Debe añadir al menos un producto al pedido.');
        return;
    }

    let esNuevoInput = document.getElementById('esNuevoPedido');
    let esNuevo = (esNuevoInput && esNuevoInput.value == '1');

    // Preparar FormData
    const formData = new FormData(form);
    formData.append('controlador', 'Pedidos');
    formData.append('metodo', esNuevo ? 'crearPedido' : 'actualizarPedido');

    // Añadir detalles como JSON string
    formData.append('detalles_json', JSON.stringify(detalles));

    // Enviar
    fetch('CFrontal.php', {
        method: 'POST',
        body: formData
    })
        .then(handleResponse)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (esNuevo) cancelarCreacion(); else cancelarEdicion();

                // Refrescar listado
                if (document.querySelector('#capaFiltrosBusqueda button[onclick*="buscar"]')) {
                    document.querySelector('#capaFiltrosBusqueda button[onclick*="buscar"]').click();
                } else {
                    obtenerVista('Pedidos', 'getVistaPedidosPrincipal', 'capaContenido');
                }
            } else {
                alert('Error: ' + (data.message || 'Error desconocido.'));
            }
        })
        .catch(error => {
            if (error !== 'Unauthorized') {
                console.error('Error:', error);
                alert('Error al guardar.');
            }
        });
}
