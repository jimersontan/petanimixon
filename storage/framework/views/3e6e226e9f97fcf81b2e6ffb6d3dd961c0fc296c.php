<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin - Pet Animixon Admin</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
</head>
<body class="dashboard-body">
    <?php echo $__env->make('partials.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="dashboard-layout">
        <?php echo $__env->make('partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Add New Admin</h1>
            </div>

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
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </main>
    </div>
    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views\admin_users\create.blade.php ENDPATH**/ ?>