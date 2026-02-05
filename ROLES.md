👤 PERSONA A — Autenticación + Usuarios + Base
(el “cimientos guy”)
🎯 Responsabilidades
Sistema de acceso


Verificación de email


Perfil de usuario


Seeders y factories base


📂 Archivos que toca
app/
├── Models/
│   └── User.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   └── ProfileController.php
│   │
│   ├── Middleware/
│   │   └── EnsureEmailIsVerified.php
│
database/
├── migrations/
│   └── create_users_table.php
│
├── seeders/
│   └── UserSeeder.php
│
├── factories/
│   └── UserFactory.php
│
routes/
├── auth.php
└── web.php   // solo auth + profile

✅ Requisitos cubiertos:
Autenticación


Verificación email


Acceso restringido


MVC correcto



👤 PERSONA B — CRUD PRINCIPAL (Coches F1)
(el que sube nota 😎)
🎯 Responsabilidades
Entidad principal


CRUD completo


Paginación + filtros


Imágenes con Cloudinary


📂 Archivos que toca
app/
├── Models/
│   ├── Car.php
│   ├── Team.php
│   ├── Engine.php
│   └── Category.php
│
├── Http/
│   ├── Controllers/
│   │   ├── CarController.php
│   │   ├── TeamController.php
│   │   └── CategoryController.php
│   │
│   ├── Requests/
│   │   ├── StoreCarRequest.php
│   │   └── UpdateCarRequest.php
│
├── Services/
│   └── ImageService.php        // Cloudinary
│
database/
├── migrations/
│   ├── create_cars_table.php
│   ├── create_teams_table.php
│   ├── create_engines_table.php
│   ├── create_categories_table.php
│   └── create_car_category_table.php
│
├── seeders/
│   ├── CarSeeder.php
│   ├── TeamSeeder.php
│   └── CategorySeeder.php
│
├── factories/
│   ├── CarFactory.php
│   └── TeamFactory.php
│
resources/views/
└── cars/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php

✅ Requisitos cubiertos:
CRUD principal


Imágenes (Cloudinary)


Relaciones n:m


Paginación + filtros



👤 PERSONA C — Pagos (PayPal) + Pedidos
(el delicado del grupo 💸)
🎯 Responsabilidades
Flujo de pago PayPal


Registro de transacciones


Página de éxito


Email automático post-pago


📂 Archivos que toca
app/
├── Models/
│   ├── Order.php
│   ├── OrderItem.php
│   └── Payment.php
│
├── Http/
│   ├── Controllers/
│   │   ├── OrderController.php
│   │   └── PaymentController.php
│
├── Services/
│   └── Payment/
│       └── PayPalService.php
│
├── Mail/
│   └── PaymentSuccessMail.php
│
database/
├── migrations/
│   ├── create_orders_table.php
│   ├── create_order_items_table.php
│   └── create_payments_table.php
│
├── seeders/
│   └── OrderSeeder.php
│
resources/views/
└── orders/
    ├── success.blade.php
    └── index.blade.php

✅ Requisitos cubiertos:
Pasarela PayPal


Registro de transacciones


Email automático


Redirección post-pago



👤 PERSONA D — Extras + Calidad + Relaciones
(el que remata y deja todo fino)
🎯 Responsabilidades
Reviews


SoftDeletes


Seeders masivos


Dashboard admin


📂 Archivos que toca
app/
├── Models/
│   └── Review.php
│
├── Http/
│   ├── Controllers/
│   │   └── ReviewController.php
│
database/
├── migrations/
│   └── create_reviews_table.php
│
├── seeders/
│   ├── ReviewSeeder.php
│   └── DatabaseSeeder.php
│
├── factories/
│   └── ReviewFactory.php
│
resources/views/
├── admin/
│   └── dashboard.blade.php

Además:
Revisar validaciones


SoftDeletes en Car


Comprobar relaciones Eloquent


Responsive con Tailwind / Bootstrap



🧠 Organización recomendada (muy importante)
Una rama por persona


PRs pequeños


Un .env.example común


Reunión final para unificar seeders



🏁 Resultado final
✔️ Proyecto equilibrado
 ✔️ Nadie pisa archivos clave
 ✔️ Todos tocan código importante
 ✔️ Muy defendible ante el profe
Si quieres, en el siguiente paso te hago:
el diagrama de BD con campos


el flujo PayPal paso a paso


o un checklist exacto para aprobar


Tú decides 🏎️🔥




F1-Heritage-Cars/
│
├── app/
│   ├── Console/
│   │   └── Kernel.php                         (Laravel)
│   │
│   ├── Exceptions/
│   │   └── Handler.php                        (Laravel)
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                          (Ana)
│   │   │   │   ├── AuthenticatedSessionController.php (Ana)
│   │   │   │   ├── ConfirmablePasswordController.php  (Ana)
│   │   │   │   ├── EmailVerificationPromptController.php (Ana)
│   │   │   │   ├── NewPasswordController.php  (Ana)
│   │   │   │   ├── PasswordController.php     (Ana)
│   │   │   │   ├── RegisteredUserController.php (Ana)
│   │   │   │   └── VerifyEmailController.php  (Ana)
│   │   │   │
│   │   │   ├── ProfileController.php          (Ana)
│   │   │   ├── CarController.php              (Bruno)
│   │   │   ├── TeamController.php             (Bruno)
│   │   │   ├── EngineController.php           (Bruno)
│   │   │   ├── CategoryController.php         (Bruno)
│   │   │   ├── OrderController.php            (Carla)
│   │   │   ├── PaymentController.php          (Carla)
│   │   │   └── ReviewController.php           (Diego)
│   │   │
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php               (Laravel)
│   │   │   ├── EnsureEmailIsVerified.php      (Ana)
│   │   │   └── RedirectIfAuthenticated.php    (Laravel)
│   │   │
│   │   └── Requests/
│   │       ├── StoreCarRequest.php             (Bruno)
│   │       ├── UpdateCarRequest.php            (Bruno)
│   │       ├── StoreOrderRequest.php           (Carla)
│   │       └── StoreReviewRequest.php          (Diego)
│   │
│   ├── Mail/
│   │   └── PaymentSuccessMail.php              (Carla)
│   │
│   ├── Models/
│   │   ├── User.php                            (Ana)
│   │   ├── Car.php                             (Bruno)
│   │   ├── Team.php                            (Bruno)
│   │   ├── Engine.php                          (Bruno)
│   │   ├── Category.php                        (Bruno)
│   │   ├── Order.php                           (Carla)
│   │   ├── OrderItem.php                       (Carla)
│   │   ├── Payment.php                         (Carla)
│   │   └── Review.php                          (Diego)
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php              (Todos)
│   │   ├── AuthServiceProvider.php             (Ana)
│   │   └── RouteServiceProvider.php            (Laravel)
│   │
│   └── Services/
│       ├── ImageService.php                    (Bruno)
│       └── Payment/
│           └── PayPalService.php               (Carla)
│
├── bootstrap/
│   └── app.php                                 (Laravel)
│
├── config/
│   ├── app.php                                 (Laravel)
│   ├── auth.php                                (Ana)
│   ├── database.php                            (Laravel)
│   ├── mail.php                                (Carla)
│   ├── services.php                            (Carla / Bruno)
│   └── cloudinary.php                          (Bruno)
│
├── database/
│   ├── factories/
│   │   ├── UserFactory.php                     (Ana)
│   │   ├── TeamFactory.php                     (Bruno)
│   │   ├── CarFactory.php                      (Bruno)
│   │   ├── OrderFactory.php                    (Carla)
│   │   └── ReviewFactory.php                   (Diego)
│   │
│   ├── migrations/
│   │   ├── create_users_table.php              (Ana)
│   │   ├── create_teams_table.php              (Bruno)
│   │   ├── create_engines_table.php            (Bruno)
│   │   ├── create_categories_table.php         (Bruno)
│   │   ├── create_cars_table.php               (Bruno)
│   │   ├── create_car_category_table.php       (Bruno)
│   │   ├── create_orders_table.php             (Carla)
│   │   ├── create_order_items_table.php        (Carla)
│   │   ├── create_payments_table.php           (Carla)
│   │   └── create_reviews_table.php            (Diego)
│   │
│   ├── seeders/
│   │   ├── DatabaseSeeder.php                  (Diego)
│   │   ├── UserSeeder.php                      (Ana)
│   │   ├── TeamSeeder.php                      (Bruno)
│   │   ├── EngineSeeder.php                    (Bruno)
│   │   ├── CategorySeeder.php                  (Bruno)
│   │   ├── CarSeeder.php                       (Bruno)
│   │   ├── OrderSeeder.php                     (Carla)
│   │   └── ReviewSeeder.php                    (Diego)
│
├── public/
│   ├── index.php                               (Laravel)
│   └── storage/                               (Bruno)
│
├── resources/
│   ├── css/
│   │   └── app.css                             (Todos)
│   │
│   ├── js/
│   │   └── app.js                              (Todos)
│   │
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php                   (Todos)
│   │   │
│   │   ├── cars/
│   │   │   ├── index.blade.php                 (Bruno)
│   │   │   ├── create.blade.php                (Bruno)
│   │   │   ├── edit.blade.php                  (Bruno)
│   │   │   └── show.blade.php                  (Bruno)
│   │   │
│   │   ├── orders/
│   │   │   ├── index.blade.php                 (Carla)
│   │   │   └── success.blade.php               (Carla)
│   │   │
│   │   ├── profile/
│   │   │   └── edit.blade.php                  (Ana)
│   │   │
│   │   └── admin/
│   │       └── dashboard.blade.php             (Diego)
│
├── routes/
│   ├── web.php                                 (Todos)
│   ├── auth.php                                (Ana)
│   └── api.php                                 (—)
│
├── storage/
│   └── app/
│       └── public/
│           └── cars/                           (Bruno)
│
├── tests/                                      (Opcional)
│
├── .env.example                                (Todos)
├── artisan
├── composer.json
├── package.json
├── vite.config.js
└── README.md                                   (Diego)


