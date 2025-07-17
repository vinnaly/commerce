

<?php $__env->startSection('title', 'Riwayat Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h3>Riwayat Pesanan</h3>
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-3">
            <div class="card-header">
                Order #<?php echo e($order->id); ?> - <?php echo e($order->created_at->format('d M Y')); ?>

            </div>
            <div class="card-body">
                <ul>
                    <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($item->product->name); ?> x <?php echo e($item->quantity); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <p>Total: <strong>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></strong></p>

                <a href="<?php echo e(route('home')); ?>" class="btn btn-sm btn-outline-primary">Beli Lagi</a>
                <a href="<?php echo e(route('account.reviews.form', $order->id)); ?>" class="btn btn-sm btn-outline-warning">Beri Nilai</a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Tutik_TSH\resources\views/frontend/account/history.blade.php ENDPATH**/ ?>