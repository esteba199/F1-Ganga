# 🏎️ F1 Ganga - Reparto de Roles

## 📂 Estructura de Archivos (Asignación Core)
```
app/
├── Http/Controllers/
│   ├── AdminDashboardController.php (Misael)
│   ├── CarController.php (Julio)
│   ├── CartController.php (Esteban)
│   ├── CheckoutController.php (Esteban)
│   ├── OrderController.php (Esteban)
│   ├── ProfileController.php (Jairo)
│   └── ReviewController.php (Misael)
│
├── Models/
│   ├── User.php (Jairo)
│   ├── Car.php, Team.php, Brand.php (Julio)
│   └── Order.php, OrderItem.php, Review.php, Cart.php (Esteban/Misael)
│
├── Services/
│   ├── CloudinaryService.php (Julio)
│   └── PayPalService.php (Esteban)
│
└── Middleware/
    └── AdminMiddleware.php (Misael)

database/
├── migrations/ (Repartidas por entidad)
└── seeders/
    └── DatabaseSeeder.php (Misael - Coordinación)

resources/views/
├── admin/ (Misael)
├── auth/ (Jairo)
├── cars/ (Julio)
├── cart/ (Esteban)
├── checkout/ (Esteban)
├── orders/ (Esteban)
└── layouts/ (Misael)

routes/
├── web.php (Misael/Todos)
└── auth.php (Jairo)
```

### 👤 Jairo: Cimientos y Acceso
**Foco:** Seguridad, usuarios y la base del proyecto.

* **Responsabilidades:**
    * Modelo de Usuario (`app/Models/User.php`).
    * Gestión de usuarios y perfiles (`ProfileController`).
    * Sistema de autenticación y verificación de email (`routes/auth.php`).
    * Vistas de Auth y Perfil (`resources/views/auth/`, `resources/views/profile/`).
    * Estructura inicial de la base de datos (Migración `users`).
    * Seeders primarios (`UserSeeder`).

### 👤 Julio: El Core - CRUD F1
**Foco:** Gestión de la entidad principal y media.

* **Responsabilidades:**
    * Modelos principales (`Car.php`, `Brand.php`, `Team.php`).
    * Catálogo y CRUD de coches (`CarController`).
    * Validación de datos (`app/Http/Requests/CarRequest.php`).
    * Integración con Cloudinary para imágenes (`CloudinaryService`).
    * Vistas del listado y detalles (`resources/views/cars/`).
    * Migraciones de Coches y Equipos.

### 👤 Esteban: Transacciones y Pagos
**Foco:** El flujo de dinero y pedidos.

* **Responsabilidades:**
    * Modelos de compra (`Order.php`, `OrderItem.php`, `Cart.php`, `Transaction.php`).
    * Sistema de pago e integración con PayPal (`CheckoutController`, `PayPalService`).
    * Gestión de pedidos e historial (`OrderController`).
    * Lógica y vistas del carrito y checkout (`resources/views/cart/`, `checkout/`).
    * Generación de facturas (`invoices/order.blade.php`).

### 👤 Misael: Calidad y Feedback
**Foco:** Reseñas, administración e integración global.

* **Responsabilidades:**
    * Modelo de Reseñas (`app/Models/Review.php`).
    * Panel de administración y métricas (`AdminDashboardController`).
    * Moderación de reseñas (`ReviewController`, `resources/views/admin/`).
    * Layout principal y componentes UI (`layouts/app.blade.php`, `components/`).
    * Seguridad de rutas administrativas (`AdminMiddleware`).
    * Coordinación de Seeders (`DatabaseSeeder.php`).