<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 mt-4">
    <div class="container mb-5">
        <h1 class="display-4 fw-bold text-warning letter-spacing-2">
            <i class="bi bi-grid me-2"></i>CATÁLOGO F1
        </h1>
        <p class="text-white-50 lead">Explora nuestra selección exclusiva de monoplazas de leyenda.</p>
    </div>

    <?php if($cars->count() > 0): ?>
        <div class="row g-4 animate__animated animate__fadeInUp">
            <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12">
                    <div class="card glass border-0 shadow-lg overflow-hidden hover-lift">
                        <div class="row g-0">
                            <!-- Image Column -->
                            <div class="col-md-5 position-relative">
                                <div class="position-relative h-100" style="min-height: 300px;">
                                    <?php if($car->image_url): ?>
                                        <img src="<?php echo e($car->image_url); ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo e($car->model); ?>">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-dark">
                                            <i class="bi bi-car-front display-1 text-warning opacity-25"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-uppercase fw-bold py-2 px-3"><?php echo e($car->year); ?></span>
                                </div>
                            </div>

                            <!-- Details Column -->
                            <div class="col-md-7">
                                <div class="card-body p-4 d-flex flex-column h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h2 class="fw-bold text-warning mb-1"><?php echo e($car->model); ?></h2>
                                            <p class="text-white-50 fs-5 mb-0">
                                                <i class="bi bi-building me-1"></i><?php echo e($car->brand->name); ?> • 
                                                <i class="bi bi-flag ms-2 me-1"></i><?php echo e($car->team->name); ?>

                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <h1 class="text-warning fw-bold mb-0"><?php echo e(number_format($car->price / 1000000, 1)); ?>M€</h1>
                                            <small class="text-white-50"><?php echo e(number_format($car->price, 0, ',', '.')); ?>€</small>
                                        </div>
                                    </div>

                                    <p class="text-white-50 mb-4 flex-grow-1 lead"><?php echo e($car->description); ?></p>

                                    <!-- Technical Specs -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-6 col-md-3">
                                            <div class="spec-box p-3 rounded bg-white bg-opacity-5">
                                                <i class="bi bi-speedometer text-warning fs-4 d-block mb-2"></i>
                                                <small class="text-white-50 d-block text-uppercase letter-spacing-1">Top Speed</small>
                                                <strong class="text-white h5 mb-0"><?php echo e($car->top_speed ?? 'N/A'); ?> km/h</strong>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="spec-box p-3 rounded bg-white bg-opacity-5">
                                                <i class="bi bi-lightning-charge text-warning fs-4 d-block mb-2"></i>
                                                <small class="text-white-50 d-block text-uppercase letter-spacing-1">0-100</small>
                                                <strong class="text-white h5 mb-0"><?php echo e($car->acceleration ?? 'N/A'); ?> s</strong>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="spec-box p-3 rounded bg-white bg-opacity-5">
                                                <i class="bi bi-gear text-warning fs-4 d-block mb-2"></i>
                                                <small class="text-white-50 d-block text-uppercase letter-spacing-1">Power Unit</small>
                                                <strong class="text-white h5 mb-0"><?php echo e(Str::limit($car->engine ?? 'N/A', 12)); ?></strong>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="spec-box p-3 rounded bg-white bg-opacity-5">
                                                <i class="bi bi-fire text-warning fs-4 d-block mb-2"></i>
                                                <small class="text-white-50 d-block text-uppercase letter-spacing-1">Power</small>
                                                <strong class="text-white h5 mb-0"><?php echo e($car->horsepower ?? 'N/A'); ?> HP</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-3">
                                        <a href="<?php echo e(route('cars.show', $car)); ?>" class="btn btn-outline-warning btn-lg flex-grow-1 fw-bold">
                                            <i class="bi bi-eye me-2"></i>VER DETALLES
                                        </a>
                                        <?php if(auth()->guard()->check()): ?>
                                            <form action="<?php echo e(route('cart.store')); ?>" method="POST" class="flex-grow-1">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="car_id" value="<?php echo e($car->id); ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-warning btn-lg fw-bold w-100">
                                                    <i class="bi bi-cart-plus me-2"></i>AÑADIR AL CARRITO
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="container mt-5">
            <?php echo e($cars->links()); ?>

        </div>
    <?php endif; ?>
</div>

<style>
.hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-lift:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(253, 197, 0, 0.2) !important; }
.spec-box { transition: background 0.3s ease; }
.spec-box:hover { background: rgba(253, 197, 0, 0.1) !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\F1-Ganga\resources\views/cars/index.blade.php ENDPATH**/ ?>