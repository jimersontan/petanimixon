<?php $__env->startSection('title', 'Vouchers & Promos - PetMarkt-PH'); ?>

<?php $__env->startSection('content'); ?>
<div class="vouchers-container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    
    <div class="vouchers-header" style="text-align: center; margin-bottom: 50px;">
        <h1 style="font-size: 36px; color: #1a1a2e; margin-bottom: 12px; font-weight: 800;">Activate Your <span style="color: #ea580c;">Voucher</span></h1>
        <p style="font-size: 16px; color: #666; max-width: 600px; margin: 0 auto;">Enter your promo code below to unlock exclusive discounts on your next order. Activated vouchers are automatically applied at checkout! 🐾</p>
    </div>

    
    <div class="activation-card" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 24px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: center; margin-bottom: 60px;">
        <div style="margin-bottom: 30px;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ffedd5, #ff8a00); color: #fff; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; box-shadow: 0 8px 20px rgba(234, 88, 12, 0.2);">🏷️</div>
            <h3 style="font-size: 20px; color: #333; font-weight: 700;">Promo Code</h3>
        </div>

        <form id="voucherForm" onsubmit="activateVoucher(event)" style="max-width: 500px; margin: 0 auto;">
            <?php echo csrf_field(); ?>
            <div style="position: relative; margin-bottom: 24px;">
                <input type="text" id="voucherInput" placeholder="PASTE CODE HERE (e.g. PETLOVE15)" 
                    value="<?php echo e(session('active_voucher')); ?>"
                    style="width: 100%; padding: 18px 24px; font-size: 18px; font-weight: 700; text-transform: uppercase; border: 2px solid #e5e7eb; border-radius: 16px; outline: none; transition: all 0.3s; text-align: center; letter-spacing: 1px;">
                <div id="vInputFocus" style="position: absolute; inset: -4px; border-radius: 20px; border: 2px solid #ea580c; opacity: 0; pointer-events: none; transition: all 0.3s;"></div>
            </div>

            <button type="submit" id="submitBtn" class="ud-btn ud-btn-primary" style="width: 100%; padding: 16px; font-size: 18px; font-weight: 700; border-radius: 16px; box-shadow: 0 6px 20px rgba(234, 88, 12, 0.3); transition: all 0.3s;">
                <span id="btnText">Activate Voucher</span>
                <span id="btnSpinner" style="display: none;">
                    <svg class="animate-spin" viewBox="0 0 24 24" fill="none" width="20" height="20" style="margin-right: 8px;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" style="opacity: 0.25;"></circle>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" style="opacity: 0.75;"></path>
                    </svg>
                    Applying...
                </span>
            </button>
        </form>

        <div id="statusMsg" style="margin-top: 24px; font-weight: 600; font-size: 15px; min-height: 22px; display: none;"></div>
        
        <?php if(session('active_voucher')): ?>
            <div id="currentActive" style="margin-top: 16px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <span style="font-size: 13px; color: #16a34a; background: #dcfce7; padding: 4px 12px; border-radius: 20px; font-weight: 600;">ACTIVE: <?php echo e(session('active_voucher')); ?></span>
                <button onclick="clearVoucher()" style="background: none; border: none; color: #ef4444; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: underline;">Remove</button>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if($availableCoupons->count() > 0): ?>
    <div class="trending-vouchers">
        <h2 style="font-size: 24px; font-weight: 800; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            🔥 Trending Deals
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            <?php $__currentLoopData = $availableCoupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="voucher-card" style="background: #fff; border: 1px dashed #ea580c; border-radius: 16px; padding: 20px; transition: all 0.3s; position: relative; overflow: hidden; cursor: pointer;" onclick="copyCode('<?php echo e($coupon->coupon_code); ?>')">
                <div style="background: #fff7ed; position: absolute; top: -10px; right: -10px; width: 40px; height: 40px; border-radius: 50%;"></div>
                <div style="background: #fff7ed; position: absolute; bottom: -10px; left: -10px; width: 40px; height: 40px; border-radius: 50%;"></div>
                
                <div style="font-size: 13px; color: #ea580c; font-weight: 700; margin-bottom: 4px;"><?php echo e($coupon->coupon_name); ?></div>
                <div style="font-size: 22px; font-weight: 800; color: #1a1a2e; margin-bottom: 12px;">
                    <?php if($coupon->discount_type === 'percent'): ?>
                        <?php echo e((int)$coupon->discount_amount); ?>% OFF
                    <?php else: ?>
                        ₱<?php echo e(number_format($coupon->discount_amount)); ?> OFF
                    <?php endif; ?>
                </div>
                <div style="background: #fdf2f8; color: #ea580c; border: 1px solid #ffedd5; padding: 8px 12px; border-radius: 8px; font-family: monospace; font-size: 16px; font-weight: 700; text-align: center;">
                    <?php echo e($coupon->coupon_code); ?>

                </div>
                <p style="font-size: 11px; color: #888; margin-top: 10px; text-align: center;">Click to copy and paste above!</p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .voucher-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); background: #fffcf8; }
    #voucherInput:focus { border-color: #ea580c; box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1); }
    .animate-spin { animation: spin 1s linear infinite; }
    @keyframes  spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function activateVoucher(e) {
    if (e) e.preventDefault();
    
    const input = document.getElementById('voucherInput');
    const code = input.value.trim();
    if (!code) return;

    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    const statusMsg = document.getElementById('statusMsg');

    // Loading state
    btn.disabled = true;
    btnText.style.display = 'none';
    btnSpinner.style.display = 'inline-flex';
    statusMsg.style.display = 'none';

    fetch('<?php echo e(route("vouchers.activate")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ voucher_code: code })
    })
    .then(r => r.json())
    .then(data => {
        statusMsg.style.display = 'block';
        if (data.success) {
            statusMsg.style.color = '#16a34a';
            statusMsg.innerHTML = data.message;
            // Pulse success
            document.querySelector('.activation-card').style.boxShadow = '0 10px 40px rgba(22, 163, 74, 0.2)';
            setTimeout(() => {
                location.reload(); // Refresh to update "currently active"
            }, 1500);
        } else {
            statusMsg.style.color = '#dc2626';
            statusMsg.textContent = data.message;
            // Shake error
            input.style.borderColor = '#dc2626';
            setTimeout(() => { input.style.borderColor = '#e5e7eb'; }, 1000);
        }
    })
    .catch(() => {
        statusMsg.style.display = 'block';
        statusMsg.style.color = '#dc2626';
        statusMsg.textContent = 'Network error. Please try again.';
    })
    .finally(() => {
        btn.disabled = false;
        btnText.style.display = 'inline';
        btnSpinner.style.display = 'none';
    });
}

function copyCode(code) {
    const input = document.getElementById('voucherInput');
    input.value = code;
    input.focus();
    // visual feedback
    const card = event.currentTarget;
    card.style.background = '#ffedd5';
    setTimeout(() => { card.style.background = '#fff'; }, 300);
}

function clearVoucher() {
    // We could make a route to clear session, but for now just clear local input or just explain it
    // Actually let's just make it subtle
    fetch('<?php echo e(route("vouchers.activate")); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
        body: JSON.stringify({ voucher_code: '___CLEAR___' }) // Controller should handle this or just manual clear
    }).finally(() => { location.reload(); });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/frontend/vouchers.blade.php ENDPATH**/ ?>