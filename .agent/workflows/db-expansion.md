---
description: Database expansion and cart implementation
---

# SPRINT 1: Base de Datos y Carrito

## Fase 1: Crear Migraciones (En progreso)
1. car_conditions table
2. cart table  
3. car_models table
4. owned_cars table (Mi Garaje)
5. transactions table
6. order_car pivot table (N:M)
7. favorites pivot table (N:M)

## Fase 2: Crear Modelos y Relaciones
- Crear todos los modelos Eloquent
- Definir relaciones en los modelos
- Actualizar modelo Car con nuevas relaciones

## Fase 3: Seeders
- Crear seeders para todas las nuevas tablas
- Ejecutar migrate:fresh --seed

## Fase 4: CartController
- Implementar CRUD de carrito
- Vista del carrito
- Botones "Añadir al carrito"

// turbo-all
