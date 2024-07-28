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
                <a class="nav-link active" data-toggle="tab" href="#marcas" onclick="showTab('marcas'); fetchMarcas()">Marcas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#prendas" onclick="showTab('prendas'); fetchPrendas()">Prendas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#ventas" onclick="showTab('ventas'); fetchVentas()">Ventas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#top5" onclick="showTab('top5'); fetchTop5Marcas()">Top 5 Marcas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#prendas-vendidas" onclick="showTab('prendas-vendidas'); fetchPrendasVendidas()">Prendas Vendidas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#marcas-con-ventas" onclick="showTab('marcas-con-ventas'); fetchMarcasConVentas()">Marcas con Ventas</a>
            </li>
        </ul>

        <!-- Contenido de las pestañas -->
        <div class="tab-content mt-3">
            <!-- Pestaña Marcas -->
            <div id="marcas" class="tab-pane fade show active">
                <h2>Marcas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchMarcas()">Actualizar</button>
                <table class="table table-striped" id="marcas-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Datos de marcas se insertarán aquí -->
                    </tbody>
                </table>
                <div class="form-container mt-3">
                    <h3>Agregar/Actualizar Marca</h3>
                    <form id="marca-form" onsubmit="return saveMarca(event)">
                        <input type="hidden" id="marca-id" />
                        <label class="form-label">Nombre</label>
                        <input type="text" id="marca-nombre" class="form-control mb-2" placeholder="Nombre" required minlength="2" maxlength="20" />
                        <div class="invalid-feedback" id="nombre-error">La marca ya existe.</div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>

<!-- Pestaña Prendas -->
<div id="prendas" class="tab-pane fade">
    <h2>Prendas</h2>
    <button class="btn btn-primary mb-3" onclick="fetchPrendas()">Actualizar</button>
    <table id="prendas-table" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Talla</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Marca</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="form-container mt-3">
        <h3>Agregar/Actualizar Prenda</h3>
        <form id="prenda-form">
            <input type="hidden" id="prenda-id" />
            <label for="prenda-nombre" class="form-label">Nombre</label>
            <input type="text" id="prenda-nombre" class="form-control mb-2" placeholder="Nombre" />
            <div class="invalid-feedback" id="nombre-errorprenda">La prenda ya existe.</div>
            <label for="prenda-talla" class="form-label">Talla</label>
            <input type="text" id="prenda-talla" class="form-control mb-2" placeholder="Talla" />
            <label for="prenda-precio" class="form-label">Precio</label>
            <input type="number" id="prenda-precio" class="form-control mb-2" placeholder="Precio" min="1"/>
            <label for="prenda-stock" class="form-label">Cantidad Stock</label>
            <input type="number" id="prenda-stock" class="form-control mb-2" placeholder="Stock" min="1" value="1"/>
            <label for="prenda-marca-id" class="form-label">Marca</label>
            <select id="prenda-marca-id" class="form-control mb-2"></select>
            <button type="button" class="btn btn-success" onclick="savePrenda()">Guardar</button>
        </form>
    </div>
</div>


            <!-- Pestaña Ventas -->
            <div id="ventas" class="tab-pane fade">
                <h2>Ventas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchVentas()">Actualizar</button>
                <table id="ventas-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Prenda</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="form-container mt-3">
                    <h3>Agregar/Actualizar Venta</h3>
                    <form id="venta-form">
                        <input type="hidden" id="venta-id" />
                        <label for="venta-prenda-id" class="form-label">Prenda</label>
                        <select id="venta-prenda-id" class="form-control mb-2"></select>
                        <label for="venta-fecha" class="form-label">Fecha</label>
                        <input type="date" id="venta-fecha" class="form-control mb-2" value="<?php echo date('Y-m-d'); ?>" />
                        <label for="venta-cantidad" class="form-label">Cantidad</label>
                        <input type="number" id="venta-cantidad" class="form-control mb-2" placeholder="Cantidad" min="1" />
                        <button type="button" class="btn btn-success" onclick="saveVenta()">Guardar</button>
                    </form>
                </div>
            </div>
            <div id="top5" class="tab-pane fade">
                <h2>Top 5 Marcas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchTop5Marcas()">Actualizar</button>
                <table class="table table-striped" id="top5-marcas-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marca</th>
                            <th>Vendidos</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div id="prendas-vendidas" class="tab-pane fade">
                <h2>Prendas Vendidas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchPrendasVendidas()">Actualizar</button>
                <table class="table table-striped" id="prendas-vendidas-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Vendidos</th>
                            <th>Disponible</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div id="marcas-con-ventas" class="tab-pane fade">
                <h2>Marcas con Ventas</h2>
                <button class="btn btn-primary mb-3" onclick="fetchMarcasConVentas()">Actualizar</button>
                <table id="marcas-con-ventas-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Unidades Vendidas</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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