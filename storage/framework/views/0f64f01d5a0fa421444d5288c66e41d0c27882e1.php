<?php $__env->startSection('title', 'Edit Account - Pet Animixon'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/themes.css')); ?>">
<?php $__env->stopPush(); ?>

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

        
        <?php $currentTheme = old('color_theme', $user->color_theme ?? 'sunset_orange'); ?>
        <div class="theme-picker-section">
            <label class="theme-picker-label">🎨 Color Theme</label>
            <p class="theme-picker-subtitle">Change how Pet Animixon looks for you — takes effect immediately!</p>
            <div class="theme-picker-grid">
                <label class="theme-swatch <?php echo e($currentTheme === 'sunset_orange' ? 'selected' : ''); ?>" style="--swatch-primary: #FF8844; --swatch-glow: rgba(255,136,68,0.2);" onclick="selectTheme(this, 'sunset_orange')">
                    <input type="radio" name="color_theme" value="sunset_orange" <?php echo e($currentTheme === 'sunset_orange' ? 'checked' : ''); ?>>
                    <span class="swatch-icon">🍊</span>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #FF8844;"></span>
                        <span class="swatch-dot" style="background: #FF6B35;"></span>
                        <span class="swatch-dot" style="background: #fff; border-color: #eee;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #FF8844;"></span>
                        <span style="background: #FF6B35;"></span>
                        <span style="background: #FFF3E0;"></span>
                    </div>
                    <span class="swatch-name">Sunset Orange</span>
                </label>

                <label class="theme-swatch <?php echo e($currentTheme === 'golden_sunshine' ? 'selected' : ''); ?>" style="--swatch-primary: #E5A700; --swatch-glow: rgba(245,184,0,0.2);" onclick="selectTheme(this, 'golden_sunshine')">
                    <input type="radio" name="color_theme" value="golden_sunshine" <?php echo e($currentTheme === 'golden_sunshine' ? 'checked' : ''); ?>>
                    <span class="swatch-icon">🌻</span>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #F5B800;"></span>
                        <span class="swatch-dot" style="background: #3B82F6;"></span>
                        <span class="swatch-dot" style="background: #fff; border-color: #eee;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #F5B800;"></span>
                        <span style="background: #3B82F6;"></span>
                        <span style="background: #FFFDE7;"></span>
                    </div>
                    <span class="swatch-name">Golden Sunshine</span>
                </label>

                <label class="theme-swatch <?php echo e($currentTheme === 'nature_fresh' ? 'selected' : ''); ?>" style="--swatch-primary: #22C55E; --swatch-glow: rgba(34,197,94,0.2);" onclick="selectTheme(this, 'nature_fresh')">
                    <input type="radio" name="color_theme" value="nature_fresh" <?php echo e($currentTheme === 'nature_fresh' ? 'checked' : ''); ?>>
                    <span class="swatch-icon">🌿</span>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #22C55E;"></span>
                        <span class="swatch-dot" style="background: #EAB308;"></span>
                        <span class="swatch-dot" style="background: #fff; border-color: #eee;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #22C55E;"></span>
                        <span style="background: #EAB308;"></span>
                        <span style="background: #F0FDF4;"></span>
                    </div>
                    <span class="swatch-name">Nature Fresh</span>
                </label>

                <label class="theme-swatch <?php echo e($currentTheme === 'sakura_bloom' ? 'selected' : ''); ?>" style="--swatch-primary: #3B82F6; --swatch-glow: rgba(59,130,246,0.2);" onclick="selectTheme(this, 'sakura_bloom')">
                    <input type="radio" name="color_theme" value="sakura_bloom" <?php echo e($currentTheme === 'sakura_bloom' ? 'checked' : ''); ?>>
                    <span class="swatch-icon">🌸</span>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #3B82F6;"></span>
                        <span class="swatch-dot" style="background: #EC4899;"></span>
                        <span class="swatch-dot" style="background: #fff; border-color: #eee;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #3B82F6;"></span>
                        <span style="background: #EC4899;"></span>
                        <span style="background: #EFF6FF;"></span>
                    </div>
                    <span class="swatch-name">Sakura Bloom</span>
                </label>

                <label class="theme-swatch <?php echo e($currentTheme === 'cosmic_violet' ? 'selected' : ''); ?>" style="--swatch-primary: #8B5CF6; --swatch-glow: rgba(139,92,246,0.2);" onclick="selectTheme(this, 'cosmic_violet')">
                    <input type="radio" name="color_theme" value="cosmic_violet" <?php echo e($currentTheme === 'cosmic_violet' ? 'checked' : ''); ?>>
                    <span class="swatch-icon">🔮</span>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #8B5CF6;"></span>
                        <span class="swatch-dot" style="background: #EC4899;"></span>
                        <span class="swatch-dot" style="background: #fff; border-color: #eee;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #8B5CF6;"></span>
                        <span style="background: #EC4899;"></span>
                        <span style="background: #F5F3FF;"></span>
                    </div>
                    <span class="swatch-name">Cosmic Violet</span>
                </label>
            </div>
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
                style="flex: 1; padding: 12px 24px; background-color: var(--ud-orange, #FF8C42); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
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
        opacity: 0.9;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
    function selectTheme(el, value) {
        document.querySelectorAll('.theme-swatch').forEach(s => s.classList.remove('selected'));
        el.classList.add('selected');
        el.querySelector('input[type="radio"]').checked = true;
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/profile/edit.blade.php ENDPATH**/ ?>