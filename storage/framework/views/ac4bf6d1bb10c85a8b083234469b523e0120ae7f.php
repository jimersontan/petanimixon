

<?php $__env->startSection('title', 'Admin Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
                <h1 class="page-title">Admin Users</h1>
                <div class="actions">
                    <button type="button" class="btn btn-primary" data-modal-open="add-admin-modal">Add Admin</button>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $currentUser = auth()->user();
                            $canEdit = $currentUser->isMainAdmin() || ($currentUser->isSupervisor() && $admin->adminRole() === 'staff_admin');
                        ?>
                        <tr>
                            <td><?php echo e($admin->name); ?></td>
                            <td><?php echo e($admin->email); ?></td>
                            <td><?php echo e(ucwords(str_replace('_', ' ', $admin->adminProfile->admin_type ?? 'staff_admin'))); ?></td>
                            <td>
                                <?php if($canEdit): ?>
                                    <a href="<?php echo e(route('admin.users.edit', $admin->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <?php else: ?>
                                    <span class="btn btn-sm btn-secondary disabled" title="Not allowed">Locked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/admin_users/index.blade.php ENDPATH**/ ?>