## Uso

La API soporta las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para las entidades Marca, Prenda y Venta. Además, se pueden generar reportes específicos.

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
│
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
│ ├── public/
│ │ ├── index.php
│ │ └── error/
│ │ └── response.html
│ └── routes.php
└── README.md