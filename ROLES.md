# 🏎️ F1 Ganga - Reparto de Responsabilidades

### 👤 Persona A: Cimientos y Acceso (Jairo)

**Foco:** Seguridad, usuarios y la base del proyecto.

* **Modelos:** `User`
* **Controladores:** `ProfileController`, `Auth/*` (Breeze/Jetstream)
* **Migraciones:** `users` (añadir campos extra si es necesario)
* **Rutas:** `auth.php`, `web.php` (perfil)

### 👤 Persona B: El Core - CRUD F1 (Bruno)

**Foco:** Gestión de la entidad principal y media.

* **Modelos:** `Car`, `Team`, `Brand`
* **Controlador:** `CarController` (Gestiona también marcas/equipos para no crear 4 controladores)
* **Servicio:** `CloudinaryService` (Carga de imágenes)
* **Vistas:** `cars/*.blade.php` (Index, Create, Edit, Show)
* **Validación:** `CarRequest`

### 👤 Persona C: Transacciones y Pagos (Carla)

**Foco:** El flujo de dinero y pedidos.

* **Modelos:** `Order`, `OrderItem`
* **Controladores:** `CheckoutController` (Integra PayPal), `OrderController` (Historial)
* **Servicio:** `PayPalService`
* **Mail:** `OrderConfirmed`
* **Vistas:** `orders/*.blade.php`

### 👤 Persona D: Calidad y Feedback (Diego)

**Foco:** Reseñas, administración y pulido final.

* **Modelos:** `Review`
* **Controladores:** `ReviewController`, `AdminDashboardController`
* **Seeders:** `DatabaseSeeder` (Centraliza los de todos)
* **Vistas:** `admin/*.blade.php`, componentes de `Review`
* **Global:** UI/UX (Tailwind/Bootstrap) y SoftDeletes.


## 📂 Estructura de Archivos
```
app/
├── Http/Controllers/
│   ├── Auth/ ... (Ana)
│   ├── CarController.php (Bruno)
│   ├── CheckoutController.php (Carla)
│   ├── ReviewController.php (Diego)
│   └── ProfileController.php (Ana)
│
├── Models/
│   ├── User.php, Car.php, Team.php, Order.php, Review.php
│
├── Services/
│   ├── CloudinaryService.php (Bruno)
│   └── PayPalService.php (Carla)
│
└── Mail/
    └── OrderConfirmed.php (Carla)

database/
├── migrations/
│   ├── 01_create_users_table.php
│   ├── 02_create_cars_and_teams_tables.php (Bruno - puede unirlas)
│   ├── 03_create_orders_table.php (Carla)
│   └── 04_create_reviews_table.php (Diego)
│
└── seeders/
    └── DatabaseSeeder.php (Diego - El "Director de Orquesta")

resources/views/
├── cars/ ... (Bruno)
├── orders/ ... (Carla)
├── admin/ ... (Diego)
└── components/ (Diego/Todos)

routes/
├── web.php (Diego/Todos)
└── auth.php (Ana)
```


### 👤 Ana (Autenticación y Perfil)

Se encarga de todo lo que viene por defecto con el kit de inicio (Breeze/Jetstream) y la gestión del usuario.

* `resources/views/auth/`
* `login.blade.php` (Acceso)
* `register.blade.php` (Registro)
* `verify-email.blade.php` (Verificación)


* `resources/views/profile/`
* `edit.blade.php` (Editar datos del usuario)



---

### 👤 Bruno (El Catálogo de Coches)

Se encarga de la parte visual del CRUD principal y la subida de fotos.

* `resources/views/cars/`
* `index.blade.php` (Listado con filtros y paginación)
* `show.blade.php` (Detalle del coche y ficha técnica)
* `create.blade.php` (Formulario de subida + Cloudinary)
* `edit.blade.php` (Edición de datos)



---

### 👤 Carla (Flujo de Compra)

Se encarga de la experiencia desde que el usuario decide comprar hasta que recibe el correo.

* `resources/views/checkout/`
* `index.blade.php` (Resumen del pedido y botón de PayPal)
* `success.blade.php` (Mensaje de éxito tras el pago)


* `resources/views/orders/`
* `index.blade.php` (Historial de compras del usuario)


* `resources/views/emails/`
* `order-confirmed.blade.php` (Plantilla del correo)



---

### 👤 Diego (Admin y Componentes Globales)

Se encarga de la "cáscara" del proyecto y el panel de control.

* `resources/views/layouts/`
* `app.blade.php` (El layout principal, Navbar y Footer)


* `resources/views/admin/`
* `dashboard.blade.php` (Métricas y gestión global)


* `resources/views/components/`
* `review-card.blade.php` (Caja de comentarios/estrellas)
* `input-error.blade.php` (Y otros componentes UI compartidos)