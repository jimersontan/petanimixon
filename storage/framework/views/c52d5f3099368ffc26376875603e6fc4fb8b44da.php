<?php $__env->startSection('title', 'Edit Account - Pet Markt-PH'); ?>

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

    <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Profile Picture Section -->
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 10px;">
            <div style="position: relative; width: 120px; height: 120px; margin-bottom: 10px; border-radius: 50%; overflow: hidden; border: 3px solid var(--ud-orange, var(--ud-orange-dark)); background-color: #ffedd5;">
                <img id="profile_image_preview" src="<?php echo e($user->profile_picture_url); ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); padding: 5px; text-align: center;">
                    <label for="profile_picture" style="cursor: pointer; color: white; font-size: 13px; font-weight: bold; width: 100%; display: block; margin:0;">Change</label>
                </div>
            </div>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;" onchange="previewProfileImage(event)">
            <p style="font-size: 12px; color: #666; margin: 0;">Upload a square image (max 2MB)</p>
        </div>

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

        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label for="date_of_birth" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Birthday</label>
                <input 
                    type="date" 
                    id="date_of_birth" 
                    name="date_of_birth" 
                    value="<?php echo e(old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '')); ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;"
                >
            </div>
            <div style="flex: 1;">
                <label for="gender" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Gender</label>
                <select id="gender" name="gender" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box;">
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo e(old('gender', $user->gender) === 'Male' ? 'selected' : ''); ?>>Male</option>
                    <option value="Female" <?php echo e(old('gender', $user->gender) === 'Female' ? 'selected' : ''); ?>>Female</option>
                    <option value="Other" <?php echo e(old('gender', $user->gender) === 'Other' ? 'selected' : ''); ?>>Other</option>
                    <option value="Prefer not to say" <?php echo e(old('gender', $user->gender) === 'Prefer not to say' ? 'selected' : ''); ?>>Prefer not to say</option>
                </select>
            </div>
        </div>

        <div>
            <label for="address" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Address</label>
            <textarea 
                id="address" 
                name="address" 
                rows="2"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box; resize: vertical;"
            ><?php echo e(old('address', $user->address)); ?></textarea>
        </div>

        <div>
            <label for="bio" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Bio</label>
            <textarea 
                id="bio" 
                name="bio" 
                rows="3"
                placeholder="Tell us a little about yourself and your pets!"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box; resize: vertical;"
            ><?php echo e(old('bio', $user->bio)); ?></textarea>
        </div>

        
        <?php $currentTheme = old('color_theme', $user->color_theme ?? 'citrus_tail'); ?>
        <div class="theme-picker-section">
            <label class="theme-picker-label">🎨 Color Theme</label>
            <p class="theme-picker-subtitle">Change how Pet Markt-PH looks for you — takes effect immediately!</p>
            <div class="theme-picker-grid">
                <!-- 1. Meadow & Honey -->
                <label class="theme-swatch <?php echo e($currentTheme === 'meadow_honey' ? 'selected' : ''); ?>" style="--swatch-primary: #10B981; --swatch-glow: rgba(16,185,129,0.2);" onclick="selectTheme(this, 'meadow_honey')">
                    <input type="radio" name="color_theme" value="meadow_honey" <?php echo e($currentTheme === 'meadow_honey' ? 'checked' : ''); ?>>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #10B981;"></span>
                        <span class="swatch-dot" style="background: #F59E0B;"></span>
                        <span class="swatch-dot" style="background: #14B8A6;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #10B981;"></span>
                        <span style="background: #F59E0B;"></span>
                    </div>
                    <span class="swatch-name">Meadow & Honey</span>
                    <span style="font-size: 10px; background: #ECFDF5; color: #059669; padding: 2px 6px; border-radius: 10px; font-weight: 600;">Natural</span>
                </label>

                <!-- 2. Sunny Paws -->
                <label class="theme-swatch <?php echo e($currentTheme === 'sunny_paws' ? 'selected' : ''); ?>" style="--swatch-primary: #F43F5E; --swatch-glow: rgba(244,63,94,0.2);" onclick="selectTheme(this, 'sunny_paws')">
                    <input type="radio" name="color_theme" value="sunny_paws" <?php echo e($currentTheme === 'sunny_paws' ? 'checked' : ''); ?>>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #F43F5E;"></span>
                        <span class="swatch-dot" style="background: #FBBF24;"></span>
                        <span class="swatch-dot" style="background: #F97316;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #F43F5E;"></span>
                        <span style="background: #FBBF24;"></span>
                    </div>
                    <span class="swatch-name">Sunny Paws</span>
                    <span style="font-size: 10px; background: #FFF1F2; color: #E11D48; padding: 2px 6px; border-radius: 10px; font-weight: 600;">Energetic</span>
                </label>

                <!-- 3. Ocean Breeze -->
                <label class="theme-swatch <?php echo e($currentTheme === 'ocean_breeze' ? 'selected' : ''); ?>" style="--swatch-primary: #0EA5E9; --swatch-glow: rgba(14,165,233,0.2);" onclick="selectTheme(this, 'ocean_breeze')">
                    <input type="radio" name="color_theme" value="ocean_breeze" <?php echo e($currentTheme === 'ocean_breeze' ? 'checked' : ''); ?>>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #38BDF8;"></span>
                        <span class="swatch-dot" style="background: #6EE7B7;"></span>
                        <span class="swatch-dot" style="background: #0EA5E9;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #0EA5E9;"></span>
                        <span style="background: #2DD4BF;"></span>
                    </div>
                    <span class="swatch-name">Ocean Breeze</span>
                    <span style="font-size: 10px; background: #F0F9FF; color: #0284C7; padding: 2px 6px; border-radius: 10px; font-weight: 600;">Fresh & Clean</span>
                </label>

                <!-- 4. Citrus Tail -->
                <label class="theme-swatch <?php echo e($currentTheme === 'citrus_tail' ? 'selected' : ''); ?>" style="--swatch-primary: #F97316; --swatch-glow: rgba(249,115,22,0.2);" onclick="selectTheme(this, 'citrus_tail')">
                    <input type="radio" name="color_theme" value="citrus_tail" <?php echo e($currentTheme === 'citrus_tail' ? 'checked' : ''); ?>>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #F97316;"></span>
                        <span class="swatch-dot" style="background: #FBBF24;"></span>
                        <span class="swatch-dot" style="background: #EA580C;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #F97316;"></span>
                        <span style="background: #FBBF24;"></span>
                    </div>
                    <span class="swatch-name">Citrus Tail</span>
                    <span style="font-size: 10px; background: #FFF7ED; color: #C2410C; padding: 2px 6px; border-radius: 10px; font-weight: 600;">Warm & Bright</span>
                </label>

                <!-- 5. Lavender Sky -->
                <label class="theme-swatch <?php echo e($currentTheme === 'lavender_sky' ? 'selected' : ''); ?>" style="--swatch-primary: #8B5CF6; --swatch-glow: rgba(139,92,246,0.2);" onclick="selectTheme(this, 'lavender_sky')">
                    <input type="radio" name="color_theme" value="lavender_sky" <?php echo e($currentTheme === 'lavender_sky' ? 'checked' : ''); ?>>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #A78BFA;"></span>
                        <span class="swatch-dot" style="background: #60A5FA;"></span>
                        <span class="swatch-dot" style="background: #818CF8;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #8B5CF6;"></span>
                        <span style="background: #60A5FA;"></span>
                    </div>
                    <span class="swatch-name">Lavender Sky</span>
                    <span style="font-size: 10px; background: #F5F3FF; color: #6D28D9; padding: 2px 6px; border-radius: 10px; font-weight: 600;">Soft & Calm</span>
                </label>

                <!-- 6. Rosy Petal -->
                <label class="theme-swatch <?php echo e($currentTheme === 'rosy_petal' ? 'selected' : ''); ?>" style="--swatch-primary: #EC4899; --swatch-glow: rgba(236,72,153,0.2);" onclick="selectTheme(this, 'rosy_petal')">
                    <input type="radio" name="color_theme" value="rosy_petal" <?php echo e($currentTheme === 'rosy_petal' ? 'checked' : ''); ?>>
                    <div class="swatch-colors">
                        <span class="swatch-dot" style="background: #F43F5E;"></span>
                        <span class="swatch-dot" style="background: #F472B6;"></span>
                        <span class="swatch-dot" style="background: #FDA4AF;"></span>
                    </div>
                    <div class="swatch-preview">
                        <span style="background: #EC4899;"></span>
                        <span style="background: #FBCFE8;"></span>
                    </div>
                    <span class="swatch-name">Rosy Petal</span>
                    <span style="font-size: 10px; background: #FDF2F8; color: #BE185D; padding: 2px 6px; border-radius: 10px; font-weight: 600;">Cute & Cozy</span>
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
                style="flex: 1; padding: 12px 24px; background-color: var(--ud-orange, #3b7c42); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
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

    function previewProfileImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profile_image_preview');
            output.src = reader.result;
        };
        if(event.target.files[0]){
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/profile/edit.blade.php ENDPATH**/ ?>