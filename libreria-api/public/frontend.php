<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KV Estilos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="styles.css">
    <!-- Librería Axios para peticiones AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div id="app" class="container mt-5">
        <h1 class="text-center mb-4">Bienvenido a KV Estilos</h1>
        
        <!-- Pestañas -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#marcas" onclick="showTab('marcas')">Marcas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#prendas" onclick="showTab('prendas')">Prendas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#ventas" onclick="showTab('ventas')">Ventas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#top5" onclick="showTab('top5')">Top 5 Marcas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#prendas-vendidas" onclick="showTab('prendas-vendidas')">Prendas Vendidas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#marcas-con-ventas" onclick="showTab('marcas-con-ventas')">Marcas con Ventas</a>
            </li>
        </ul>

<!-- Contenido de las pestañas -->
<div class="tab-content mt-3">
    <!-- Pestaña Marcas -->
    <div id="marcas" class="tab-pane fade show active">
        <h2>Marcas</h2>
        <button class="btn btn-primary mb-3" onclick="fetchMarcas()">Actualizar</button>
        <ul id="marcas-list" class="list-group"></ul>
        <div class="form-container mt-3">
            <h3>Agregar/Actualizar Marca</h3>
            <form id="marca-form">
                <input type="hidden" id="marca-id" />
                <input type="text" id="marca-nombre" class="form-control mb-2" placeholder="Nombre" />
                <button type="button" class="btn btn-success" onclick="saveMarca()">Guardar</button>
            </form>
        </div>
    </div>
<!-- Pestaña Prendas -->
    <div id="prendas" class="tab-pane fade">
    <h2>Prendas</h2>
    <button class="btn btn-primary mb-3" onclick="fetchPrendas()">Actualizar</button>
    <ul id="prendas-list" class="list-group">
    </ul>
    <div class="form-container mt-3">
        <h3>Agregar/Actualizar Prenda</h3>
        <form id="prenda-form">
            <input type="hidden" id="prenda-id" />
            <input type="text" id="prenda-nombre" class="form-control mb-2" placeholder="Nombre" />
            <input type="text" id="prenda-talla" class="form-control mb-2" placeholder="Talla" />
            <input type="text" id="prenda-precio" class="form-control mb-2" placeholder="Precio" />
            <input type="text" id="prenda-stock" class="form-control mb-2" placeholder="Stock" />
            <select id="prenda-marca-id" class="form-control mb-2"></select>
            <button type="button" class="btn btn-success" onclick="savePrenda()">Guardar</button>
        </form>
    </div>
</div>
<!-- Pestaña Ventas -->
<div id="ventas" class="tab-pane fade">
    <h2>Ventas</h2>
    <button class="btn btn-primary mb-3" onclick="fetchVentas()">Actualizar</button>
    <ul id="ventas-list" class="list-group"></ul>
    <div class="form-container mt-3">
        <h3>Agregar/Actualizar Venta</h3>
        <form id="venta-form">
            <input type="hidden" id="venta-id" />
            <select id="venta-prenda-id" class="form-control mb-2"></select>
            <input type="date" id="venta-fecha" class="form-control mb-2" value="<?php echo date('Y-m-d'); ?>" />
            <input type="number" id="venta-cantidad" class="form-control mb-2" placeholder="Cantidad" min="1" />
            <button type="button" class="btn btn-success" onclick="saveVenta()">Guardar</button>
        </form>
    </div>
</div>


            <div id="top5" class="tab-pane fade">
                <h2>Top 5 Marcas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchTop5Marcas()">Actualizar</button>
                <ul id="top5-marcas-list" class="list-group"></ul>
            </div>

            <div id="prendas-vendidas" class="tab-pane fade">
                <h2>Prendas Vendidas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchPrendasVendidas()">Actualizar</button>
                <ul id="prendas-vendidas-list" class="list-group"></ul>
            </div>

            <div id="marcas-con-ventas" class="tab-pane fade">
                <h2>Marcas con Ventas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchMarcasConVentas()">Actualizar</button>
                <ul id="marcas-con-ventas-list" class="list-group"></ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (jQuery required) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Scripts individuales para cada sección -->
    <script src="scripts/marcas.js"></script>
    <script src="scripts/prendas.js"></script>
    <script src="scripts/ventas.js"></script>
    <script src="scripts/top5.js"></script>
    <script src="scripts/prendas-vendidas.js"></script>
    <script src="scripts/marcas-con-ventas.js"></script>

    <script>
        // Función para mostrar la pestaña activa
        function showTab(tabId) {
            $('.nav-tabs a[href="#' + tabId + '"]').tab('show');
        }
    </script>
</body>
</html>
