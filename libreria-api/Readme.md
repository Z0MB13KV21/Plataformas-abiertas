# Librería API

Este proyecto proporciona una API para gestionar una biblioteca de productos, permitiendo realizar operaciones CRUD sobre entidades como marcas, prendas y ventas. También ofrece funcionalidades para generar reportes específicos.

## Uso

La API soporta las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para las entidades Marca, Prenda y Venta. Además, incluye endpoints para generar reportes específicos.

### Endpoints

#### Marcas
- **GET /marcas**: Obtiene todas las marcas.
- **GET /marcas/{id}**: Obtiene una marca por ID.
- **POST /marcas**: Crea una nueva marca.
- **PUT /marcas/{id}**: Actualiza una marca por ID.
- **DELETE /marcas/{id}**: Elimina una marca por ID.

#### Prendas
- **GET /prendas**: Obtiene todas las prendas.
- **GET /prendas/{id}**: Obtiene una prenda por ID.
- **POST /prendas**: Crea una nueva prenda.
- **PUT /prendas/{id}**: Actualiza una prenda por ID.
- **DELETE /prendas/{id}**: Elimina una prenda por ID.

#### Ventas
- **GET /ventas**: Obtiene todas las ventas.
- **GET /ventas/{id}**: Obtiene una venta por ID.
- **POST /ventas**: Crea una nueva venta.
- **PUT /ventas/{id}**: Actualiza una venta por ID.
- **DELETE /ventas/{id}**: Elimina una venta por ID.

### Reportes
- **GET /marcas/conVentas**: Obtiene la lista de todas las marcas que tienen al menos una venta.
- **GET /prendas/vendidas**: Obtiene las prendas vendidas y su cantidad restante en stock.
- **GET /marcas/top5**: Obtiene el listado de las 5 marcas más vendidas y su cantidad de ventas.

## Estructura del Proyecto

El proyecto está organizado de la siguiente manera:

libreria-api/
├── public/
│ ├── frontend.php
│ ├── index.php
│ ├── styles.css
│ ├── error/
│ │ └── response.html
│ └── scripts/
│ ├── marcas-con-ventas.js
│ ├── marcas.js
│ ├── prendas-vendidas.js
│ ├── prendas.js
│ ├── top5.js
│ └── ventas.js
├── src/
│ ├── controllers/
│ │ ├── MarcaController.php
│ │ ├── PrendaController.php
│ │ └── VentaController.php
│ ├── db/
│ │ └── Database.php
│ ├── module/
│ │ ├── Marca.php
│ │ ├── Prenda.php
│ │ └── Venta.php
│ └── routes.php
└── README.md

### Detalles de los Archivos

- **public/frontend.php**: Archivo principal para la interfaz de usuario del proyecto. Contiene el HTML y las conexiones a los scripts JavaScript.
- **public/index.php**: Punto de entrada para las peticiones API. Maneja las rutas y las solicitudes.
- **public/styles.css**: Contiene los estilos personalizados para la interfaz.
- **public/error/response.html**: Página de error personalizada.
- **public/scripts/**: Carpeta que contiene los archivos JavaScript para la interacción con la API.
  - `marcas-con-ventas.js`: Maneja la visualización de marcas con ventas.
  - `marcas.js`: Maneja la visualización y gestión de marcas.
  - `prendas-vendidas.js`: Maneja la visualización de prendas vendidas.
  - `prendas.js`: Maneja la visualización y gestión de prendas.
  - `top5.js`: Maneja la visualización del top 5 de marcas.
  - `ventas.js`: Maneja la visualización y gestión de ventas.
- **src/controllers/**: Carpeta que contiene los controladores para manejar la lógica de negocio.
  - `MarcaController.php`: Controlador para las operaciones relacionadas con marcas.
  - `PrendaController.php`: Controlador para las operaciones relacionadas con prendas.
  - `VentaController.php`: Controlador para las operaciones relacionadas con ventas.
- **src/db/Database.php**: Archivo para la conexión con la base de datos.
- **src/module/**: Carpeta que contiene los modelos para interactuar con la base de datos.
  - `Marca.php`: Modelo para la entidad Marca.
  - `Prenda.php`: Modelo para la entidad Prenda.
  - `Venta.php`: Modelo para la entidad Venta.
- **src/routes.php**: Archivo de configuración de rutas para la API.


