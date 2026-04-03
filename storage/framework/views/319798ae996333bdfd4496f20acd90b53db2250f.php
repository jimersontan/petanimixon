<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Requests - Pet Animixon Admin</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/orders.css')); ?>"> <!-- reuse table styles -->
</head>
<body class="dashboard-body">
    <?php echo $__env->make('partials.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="dashboard-layout">
        <?php echo $__env->make('partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Admin Account Requests</h1>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Requested At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($req->name); ?></td>
                            <td><?php echo e($req->email); ?></td>
                            <td><?php echo e(ucfirst($req->status)); ?></td>
                            <td><?php echo e($req->created_at->format('Y-m-d H:i')); ?></td>
                            <td>
                                <?php if($req->status === 'pending'): ?>
                                    <form method="POST" action="<?php echo e(route('admin.requests.approve', $req->id)); ?>" style="display:inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="<?php echo e(route('admin.requests.decline', $req->id)); ?>" style="display:inline; margin-left:8px;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                    </form>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        </main>
    </div>

    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/admin_requests/index.blade.php ENDPATH**/ ?>