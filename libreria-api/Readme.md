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
│ ├── frontend/
│ │ ├── index.php
│ │ ├── styles.css
│ │ ├── scripts/
│ │ │ ├── marcas-con-ventas.js
│ │ │ ├── marcas.js
│ │ │ ├── prendas-vendidas.js
│ │ │ ├── prendas.js
│ │ │ ├── top5.js
│ │ │ └── ventas.js
│ ├── index.php
│ ├── error/
│ │ └── response.html
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

- **public/frontend/index.php**: Archivo principal para la interfaz de usuario del proyecto. Contiene el HTML y las conexiones a los scripts JavaScript.
- **public/index.php**: Punto de entrada para las peticiones API. Maneja las rutas y las solicitudes.
- **public/frontend/styles.css**: Contiene los estilos personalizados para la interfaz.
- **public/error/response.html**: Página de error personalizada.
- **public/frontend/scripts/**: Carpeta que contiene los archivos JavaScript para la interacción con la API.
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

### Detalles de los Scripts JavaScript

#### `marcas.js`
Este script maneja la visualización y gestión de las marcas en la interfaz de usuario. Se encarga de:
- Cargar y mostrar todas las marcas.
- Permitir la creación, actualización y eliminación de marcas.
- Mostrar mensajes de error si se producen errores en las operaciones.

#### `prendas.js`
Este script maneja la visualización y gestión de las prendas en la interfaz de usuario. Se encarga de:
- Cargar y mostrar todas las prendas.
- Permitir la creación, actualización y eliminación de prendas.
- Validar los datos antes de enviarlos al servidor.
- Mostrar mensajes de error si se producen errores en las operaciones.

#### `ventas.js`
Este script maneja la visualización y gestión de las ventas en la interfaz de usuario. Se encarga de:
- Cargar y mostrar todas las ventas.
- Permitir la creación, actualización y eliminación de ventas.
- Validar las fechas de las ventas para que solo se puedan seleccionar fechas válidas según si es una nueva venta o una edición.
- Mostrar mensajes de error si se producen errores en las operaciones.

#### `marcas-con-ventas.js`
Este script maneja la visualización de las marcas que tienen al menos una venta. Se encarga de:
- Cargar y mostrar todas las marcas con ventas.
- Mostrar mensajes de error si se producen errores en las operaciones.

#### `prendas-vendidas.js`
Este script maneja la visualización de las prendas vendidas y su cantidad restante en stock. Se encarga de:
- Cargar y mostrar todas las prendas vendidas.
- Mostrar mensajes de error si se producen errores en las operaciones.

#### `top5.js`
Este script maneja la visualización de las 5 marcas más vendidas. Se encarga de:
- Cargar y mostrar el top 5 de marcas.
- Mostrar mensajes de error si se producen errores en las operaciones.

### Detalles de los Módulos

#### `Marca.php`
Modelo para la entidad Marca. Define la estructura de los datos y las operaciones relacionadas con las marcas en la base de datos.

#### `Prenda.php`
Modelo para la entidad Prenda. Define la estructura de los datos y las operaciones relacionadas con las prendas en la base de datos.

#### `Venta.php`
Modelo para la entidad Venta. Define la estructura de los datos y las operaciones relacionadas con las ventas en la base de datos.

### Detalles de los Controladores

#### `MarcaController.php`
Controlador para las operaciones relacionadas con marcas. Define los métodos para gestionar las operaciones CRUD sobre las marcas.

#### `PrendaController.php`
Controlador para las operaciones relacionadas con prendas. Define los métodos para gestionar las operaciones CRUD sobre las prendas.

#### `VentaController.php`
Controlador para las operaciones relacionadas con ventas. Define los métodos para gestionar las operaciones CRUD sobre las ventas.

### Detalles del Frontend

El archivo `public/frontend/index.php` contiene la interfaz de usuario del proyecto. Este archivo incluye:

- **Pestañas de Navegación**: 
  - Marcas
  - Prendas
  - Ventas
  - Reportes(Top 5 Marcas , Prendas Vendidas y Marcas con Ventas)

Cada pestaña muestra una tabla correspondiente a la entidad seleccionada (Marcas, Prendas, Ventas) y formularios para añadir o editar entradas.

- **Validaciones**: 
  - Los formularios cuentan con validaciones para asegurarse de que todos los campos obligatorios estén completos antes de enviar los datos al servidor.
  - En la pestaña de ventas, se valida que la fecha de una nueva venta solo puede seleccionarse desde la fecha actual hasta tres meses en el futuro. Para la edición de ventas, la fecha solo puede seleccionarse desde la fecha actual hasta tres meses en el pasado.

- **Interacción con la API**: 
  - Los scripts JavaScript cargan datos dinámicamente desde la API y actualizan la interfaz de usuario en tiempo real sin necesidad de recargar la página.
  - Los datos se presentan en listas y tablas, permitiendo la edición y eliminación de elementos directamente desde la interfaz.

- **Mensajes de Error**: 
  - Los scripts JavaScript muestran alertas y mensajes de error si se producen errores en las operaciones, como fallos en la conexión con la API o intentos de crear entradas duplicadas.
