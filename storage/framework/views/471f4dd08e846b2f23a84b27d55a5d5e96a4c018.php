<?php $__env->startSection('title', 'Returns & Refunds'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-header">
    <h1 class="page-title">Returns & Refunds</h1>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 7l-7 7-7-7"/></svg></div>
        <div class="metric-content"><div class="metric-value"><?php echo e($stats['total']); ?></div><div class="metric-label">Total Requests</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#fef3c7; color:#d97706;"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg></div>
        <div class="metric-content"><div class="metric-value"><?php echo e($stats['pending']); ?></div><div class="metric-label">Pending</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
        <div class="metric-content"><div class="metric-value"><?php echo e($stats['approved']); ?></div><div class="metric-label">Approved</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#fee2e2; color:#dc2626;"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg></div>
        <div class="metric-content"><div class="metric-value"><?php echo e($stats['rejected']); ?></div><div class="metric-label">Rejected</div></div>
    </div>
</div>

<div class="card orders-table-card">
    <div class="orders-section-header"><h2 class="card-title">Return Requests</h2></div>
    <div class="order-status-tabs" role="tablist">
        <a href="<?php echo e(route('returns.admin')); ?>" class="order-tab <?php echo e($statusFilter === 'all' ? 'active' : ''); ?>">All</a>
        <a href="<?php echo e(route('returns.admin', ['status' => 'pending'])); ?>" class="order-tab <?php echo e($statusFilter === 'pending' ? 'active' : ''); ?>">Pending</a>
        <a href="<?php echo e(route('returns.admin', ['status' => 'approved'])); ?>" class="order-tab <?php echo e($statusFilter === 'approved' ? 'active' : ''); ?>">Approved</a>
        <a href="<?php echo e(route('returns.admin', ['status' => 'rejected'])); ?>" class="order-tab <?php echo e($statusFilter === 'rejected' ? 'active' : ''); ?>">Rejected</a>
    </div>

    <div class="table-wrap">
        <table class="orders-table">
            <thead><tr><th>ID</th><th>Product</th><th>Customer</th><th>Reason</th><th>Type</th><th>Amount</th><th>Status</th><th class="col-actions">Actions</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><code><?php echo e($return->return_refund_id); ?></code></td>
                    <td><?php echo e(optional($return->orderItem)->product->product_name ?? '—'); ?></td>
                    <td><?php echo e(optional(optional($return->orderItem)->order)->user->full_name ?? '—'); ?></td>
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo e($return->return_reason); ?>"><?php echo e($return->return_reason); ?></td>
                    <td><?php echo e(ucfirst($return->return_type)); ?></td>
                    <td><strong>₱<?php echo e(number_format((float)$return->refund_amount, 2)); ?></strong></td>
                    <td>
                        <?php if($return->refund_status === 'pending'): ?>
                            <span class="status-badge" style="background:#fef3c7; color:#d97706;">Pending</span>
                        <?php elseif($return->refund_status === 'approved'): ?>
                            <span class="status-badge" style="background:#dcfce7; color:#16a34a;">Approved</span>
                        <?php else: ?>
                            <span class="status-badge" style="background:#fee2e2; color:#dc2626;">Rejected</span>
                        <?php endif; ?>
                    </td>
                    <td class="col-actions">
                        <?php if($return->refund_status === 'pending'): ?>
                            <form method="POST" action="<?php echo e(route('returns.approve', $return->id)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="action-btn" title="Approve" style="color:#16a34a;" onclick="return confirm('Approve this return request?')">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('returns.reject', $return->id)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="action-btn" title="Reject" style="color:#dc2626;" onclick="return confirm('Reject this return request?')">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                                </button>
                            </form>
                        <?php else: ?>
                            <span style="font-size: 12px; color: #999;"><?php echo e(ucfirst($return->refund_status)); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center empty-orders">No return requests found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="mt-4"><?php echo e($returns->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/returns_admin.blade.php ENDPATH**/ ?>