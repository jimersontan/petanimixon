<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users - Pet Markt-PH Admin</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/orders.css')); ?>"> <!-- reuse whatever table styles exist -->
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
</head>
<body class="dashboard-body">
    <?php echo $__env->make('partials.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="dashboard-layout">
        <?php echo $__env->make('partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main class="main-content">
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
        </main>
    </div>

    <?php $__env->startPush('modals'); ?>
    <div class="modal-backdrop <?php echo e($errors->any() ? 'open' : ''); ?>" data-modal-id="add-admin-modal"></div>
    <div id="add-admin-modal" class="modal <?php echo e($errors->any() ? 'open' : ''); ?>" role="dialog" aria-modal="true" aria-labelledby="addAdminTitle" tabindex="-1">
        <div class="modal-header">
            <h2 id="addAdminTitle" class="modal-title">Add Admin</h2>
            <button type="button" class="modal-close" data-modal-close="add-admin-modal" aria-label="Close modal">&times;</button>
        </div>
        <div class="modal-body">
            <form method="post" action="<?php echo e(route('admin.users.store')); ?>" class="form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleKey => $roleLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($roleKey); ?>" <?php if(old('role') === $roleKey): ?> selected <?php endif; ?>><?php echo e($roleLabel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-close="add-admin-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
    <?php $__env->stopPush(); ?>

    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
</body>
</html>

<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/admin_users/index.blade.php ENDPATH**/ ?>