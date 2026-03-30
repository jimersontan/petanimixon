

<?php $__env->startSection('title', 'My Orders - Petverse'); ?>

<?php $__env->startSection('content'); ?>
    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">My Orders</h2>
        </div>

        <?php if($orders->isEmpty()): ?>
            <div class="ud-card" style="padding: 2rem; text-align: center;">
                <p>You haven't placed any orders yet.</p>
                <a href="<?php echo e(route('shop')); ?>" class="ud-btn ud-btn-primary">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="ud-table-wrap">
                <table class="ud-table" style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->display_id); ?></td>
                                <td><?php echo e($order->created_at->format('M j, Y')); ?></td>
                                <td><?php echo e(ucfirst($order->order_status)); ?></td>
                                <td><?php echo e($order->formatted_total); ?></td>
                                <td><?php echo e($order->orderItems->count()); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/frontend/orders.blade.php ENDPATH**/ ?>