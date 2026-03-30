

<?php $__env->startSection('title', 'Edit Account - Pet Animixon'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 600px; margin: 40px auto; padding: 0 20px;">
    <h1 style="font-size: 28px; margin-bottom: 30px; color: #333;">Edit Account</h1>

    <?php if($errors->any()): ?>
        <div style="background-color: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
            <p style="color: #c33; font-weight: bold; margin: 0 0 10px 0;">Please fix the following errors:</p>
            <ul style="margin: 0; padding-left: 20px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li style="color: #c33;"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div style="background-color: #efe; border: 1px solid #cfc; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
            <p style="color: #3c3; font-weight: bold; margin: 0;"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('profile.update')); ?>" style="display: flex; flex-direction: column; gap: 20px;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div>
            <label for="first_name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">First Name</label>
            <input 
                type="text" 
                id="first_name" 
                name="first_name" 
                value="<?php echo e(old('first_name', $user->first_name)); ?>"
                required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;"
            >
        </div>

        <div>
            <label for="last_name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Last Name</label>
            <input 
                type="text" 
                id="last_name" 
                name="last_name" 
                value="<?php echo e(old('last_name', $user->last_name)); ?>"
                required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;"
            >
        </div>

        <div>
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="<?php echo e(old('email', $user->email)); ?>"
                required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;"
            >
        </div>

        <div>
            <label for="phone_number" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Phone (Optional)</label>
            <input 
                type="text" 
                id="phone_number" 
                name="phone_number" 
                value="<?php echo e(old('phone_number', $user->phone_number ?? '')); ?>"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;"
            >
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 20px;">
            <h3 style="font-size: 18px; margin-bottom: 15px; color: #333;">Change Password (Leave blank to keep current)</h3>

            <div>
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">New Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;"
                >
            </div>

            <div style="margin-top: 15px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;"
                >
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 10px;">
            <button 
                type="submit" 
                style="flex: 1; padding: 12px 24px; background-color: var(--ud-orange, #FF8C42); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background-color 0.3s;"
            >
                Save Changes
            </button>
            <a 
                href="<?php echo e(route('home')); ?>" 
                style="flex: 1; padding: 12px 24px; background-color: #f0f0f0; color: #333; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center; transition: background-color 0.3s;"
            >
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
    button[type="submit"]:hover {
        background-color: #E67E2F !important;
    }

    a:hover[style*="background-color: #f0f0f0"] {
        background-color: #e0e0e0 !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/profile/edit.blade.php ENDPATH**/ ?>