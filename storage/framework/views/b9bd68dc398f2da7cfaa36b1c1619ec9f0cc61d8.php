

<?php $__env->startSection('title', 'Shopping Cart - Pet Markt-PH'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    body.user-dashboard { background: #fdf5ec; }
    /* ========== PAGE WRAPPER ========== */
    .cart-page { width: 100%; padding: 32px 2rem 60px; }
    .cart-heading { font-size: 26px; font-weight: 800; color: #222; margin: 0 0 4px; }
    .cart-sub     { font-size: 13px; color: #888; margin: 0 0 24px; }

    /* ========== LAYOUT ========== */
    .cart-layout { display: flex; gap: 24px; align-items: flex-start; }
    .cart-items-col { flex: 1; min-width: 0; }
    .cart-summary-col { width: 290px; flex-shrink: 0; }

    /* ========== ITEM CARDS ========== */
    .cart-item-card {
        background: white; border-radius: 14px;
        padding: 0; margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
        display: flex; overflow: hidden;
    }
    .cart-item-img {
        width: 160px; height: 160px; flex-shrink: 0;
        object-fit: contain;
        background-color: #f9f9f9;
        padding: 10px; box-sizing: border-box;
    }
    .cart-item-body { flex: 1; padding: 18px 16px 14px; }
    .cart-item-name {
        font-size: 15px; font-weight: 700; color: #222; margin: 0 0 4px;
    }
    .cart-item-tag {
        display: inline-block; font-size: 11.5px; font-weight: 600;
        color: #3b7c42; background: #fff4ec; border-radius: 20px;
        padding: 2px 10px; margin-bottom: 6px;
    }
    .cart-item-details { font-size: 12.5px; color: #888; margin-bottom: 4px; }
    .cart-item-status-in   { font-size: 12px; color: #3DB868; font-weight: 600; }
    .cart-item-status-low  { font-size: 12px; color: #3b7c42; font-weight: 600; }
    .cart-item-wishlist    { font-size: 12px; color: #3b7c42; text-decoration: none; font-weight: 600; }
    .cart-item-wishlist:hover { text-decoration: underline; }

    /* Qty + price row */
    .cart-item-bottom {
        display: flex; align-items: center;
        justify-content: space-between; margin-top: 12px;
    }
    .qty-label { font-size: 12px; color: #888; margin-bottom: 4px; }
    .qty-control {
        display: flex; align-items: center; gap: 0;
        border: 1.5px solid #ddd; border-radius: 8px; overflow: hidden;
        width: fit-content;
    }
    .qty-btn {
        width: 32px; height: 32px; background: white; border: none;
        font-size: 18px; cursor: pointer; line-height: 1;
        color: #555; transition: background .15s;
    }
    .qty-btn:hover { background: #f5f5f5; }
    .qty-val {
        width: 32px; text-align: center;
        font-size: 14px; font-weight: 700; color: #222;
        border: none; outline: none;
    }
    .cart-item-price-col { text-align: right; margin-left: auto; margin-right: 20px; }
    .each-label  { font-size: 11.5px; color: #aaa; }
    .item-total  { font-size: 17px; font-weight: 800; color: #3b7c42; }
    .delete-btn  {
        background: #fee2e2; border: none; cursor: pointer;
        font-size: 15px; color: #ef4444; 
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        transition: all .2s;
    }
    .delete-btn:hover { background: #fecaca; color: #dc2626; }

    /* ========== ORDER SUMMARY ========== */
    .order-summary-card {
        background: white; border-radius: 14px;
        padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.07);
        position: sticky; top: 20px;
    }
    .summary-title { font-size: 16px; font-weight: 800; color: #222; margin: 0 0 20px; }
    .summary-row {
        display: flex; justify-content: space-between;
        align-items: center; font-size: 13.5px; color: #555;
        margin-bottom: 12px;
    }
    .summary-row.total {
        font-size: 16px; font-weight: 800; color: #222;
        border-top: 1px solid #eee; padding-top: 14px;
        margin-top: 4px;
    }
    .summary-row.total .total-val { color: #3b7c42; font-size: 20px; }
    .free-ship { color: #3DB868; font-weight: 700; font-size: 13px; }
    .promo-link {
        font-size: 12px; color: #888; cursor: pointer;
        display: block; margin-bottom: 18px;
    }
    .promo-link:hover { color: #3b7c42; }
    .btn-checkout {
        width: 100%; padding: 14px;
        background: #3b7c42; color: white;
        border: none; border-radius: 10px;
        font-size: 15px; font-weight: 800;
        cursor: pointer; transition: opacity .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-checkout:hover { opacity: .9; }

    /* Trust badges */
    .trust-badges {
        display: flex; justify-content: space-between;
        gap: 6px; margin-top: 14px; text-align: center;
    }
    .trust-badge { font-size: 10px; color: #888; display: flex; flex-direction: column; align-items: center; gap: 3px; }
    .trust-badge svg { width: 18px; height: 18px; color: #aaa; }

    /* Payment icons */
    .payment-icons { display: flex; justify-content: center; gap: 6px; margin-top: 12px; }
    .payment-icon {
        background: #f5f5f5; border-radius: 5px;
        padding: 4px 8px; font-size: 11px; font-weight: 700; color: #555;
    }

    /* ========== CONTINUE / CLEAR ========== */
    .cart-footer-row {
        display: flex; justify-content: space-between;
        align-items: center; margin-top: 16px;
    }
    .continue-link { 
        padding: 8px 20px; border-radius: 20px;
        font-size: 13px; color: #3b7c42; text-decoration: none; font-weight: 600; 
        background: #fff4ec; transition: all .2s;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .continue-link:hover { background: #ffe6d5; }
    .btn-clear-cart {
        padding: 8px 16px;
        border: 1.5px solid #ffcdd2; background: white;
        border-radius: 20px; font-size: 13px; color: #ef4444;
        cursor: pointer; transition: all .2s;
        display: inline-flex; align-items: center; justify-content: center; text-decoration: none;
    }
    .btn-clear-cart:hover { background: #fee2e2; border-color: #fca5a5; }

    /* ========== YOU MIGHT ALSO LIKE ========== */
    .ymal-section { margin-top: 48px; }
    .ymal-title { font-size: 22px; font-weight: 800; color: #222; text-align: center; margin-bottom: 24px; }
    .ymal-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
    .ymal-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.07); }
    .ymal-img   { width: 100%; height: 160px; object-fit: cover; }
    .ymal-body  { padding: 12px; }
    .ymal-name  { font-size: 13px; font-weight: 600; color: #222; margin: 0 0 4px; }
    .ymal-price { font-size: 14px; font-weight: 800; color: #3b7c42; }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .cart-page { padding: 16px 12px 100px; }
        .cart-heading { font-size: 20px; }
        .cart-sub { font-size: 12px; margin-bottom: 16px; }

        .cart-layout { flex-direction: column; gap: 16px; }
        .cart-summary-col { width: 100%; position: static; margin-top: 0; }

        /* Compact horizontal cart items */
        .cart-item-card {
            flex-direction: row;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 1px 6px rgba(0,0,0,.06);
        }
        .cart-item-img {
            width: 90px; height: 90px;
            flex-shrink: 0;
            border-radius: 10px 0 0 10px;
        }
        .cart-item-body { padding: 10px 12px 8px; }
        .cart-item-name { font-size: 13px; margin-bottom: 2px; }
        .cart-item-tag { font-size: 10px; padding: 1px 7px; margin-bottom: 3px; }
        .cart-item-details { font-size: 11px; margin-bottom: 2px; }
        .cart-item-status-in,
        .cart-item-status-low { font-size: 11px; }
        .cart-item-wishlist { font-size: 11px; }

        .cart-item-bottom {
            flex-direction: row;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
        }
        .qty-label { font-size: 0; margin: 0; height: 0; overflow: hidden; }
        .qty-control { border-width: 1px; }
        .qty-btn { width: 26px; height: 26px; font-size: 14px; }
        .qty-val { width: 26px; font-size: 12px; }
        .cart-item-price-col { text-align: right; margin-left: auto; margin-right: 12px; }
        .each-label { font-size: 10px; }
        .item-total { font-size: 14px; }
        .delete-btn { width: 34px; height: 34px; border-radius: 8px; }

        /* Order summary compact STICKY FOOTER */
        .order-summary-card { 
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #fff;
            padding: 12px 16px; 
            border-radius: 0; 
            z-index: 1000;
            box-shadow: 0 -4px 16px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .summary-title { display: none; }
        .summary-row:not(.total) { display: none; }
        .summary-row.total { 
            margin: 0; 
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 2px;
        }
        .summary-row.total > span:first-child { font-size: 11px; color: #555; }
        .summary-row.total .total-val { font-size: 18px; color: var(--ud-orange); }
        
        .btn-checkout { 
            width: auto; 
            margin: 0; 
            padding: 12px 20px; 
            border-radius: 6px; 
            font-size: 13px;
            background: var(--ud-orange);
            color: white;
            font-weight: 700;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }
        .trust-badges { display: none; }

        /* You might also like */
        .ymal-section { margin-top: 28px; }
        .ymal-title { font-size: 18px; margin-bottom: 16px; }
        .ymal-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .ymal-card { border-radius: 8px; }
        .ymal-img { height: 120px; }
        .ymal-body { padding: 8px; }
        .ymal-name { font-size: 12px; }
        .ymal-price { font-size: 13px; }

        /* Footer buttons */
        .cart-footer-row { margin-top: 10px; }
        .continue-link { font-size: 12px; }
        .btn-clear-cart { padding: 6px 14px; font-size: 12px; }
    }
    @media (max-width: 480px) {
        .cart-item-img { width: 75px; height: 75px; }
        .cart-item-name { font-size: 12px; }
        .item-total { font-size: 13px; }
        .ymal-img { height: 100px; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="cart-page">
    <?php if(session('error')): ?>
        <div style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 14px; font-weight: 600;">
            ⚠️ <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('message')): ?>
        <div style="background: #dcfce7; color: #16a34a; border: 1px solid #86efac; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 14px; font-weight: 600;">
            ✓ <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?>
    <h1 class="cart-heading">Shopping Cart</h1>
    <p class="cart-sub">(<?php echo e($cart->items->count()); ?> items in your cart)</p>

    <div class="cart-layout">
        
        <div class="cart-items-col">
            <?php if($cart->items->isNotEmpty()): ?>
            <div class="cart-select-all-row" style="background: white; padding: 12px 16px; border-radius: 12px; margin-bottom: 12px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <input type="checkbox" id="selectAllCheckbox" style="width: 18px; height: 18px; accent-color: var(--ud-orange); cursor: pointer;">
                <label for="selectAllCheckbox" style="font-weight: 700; color: #333; cursor: pointer; user-select: none;">Select All Items</label>
            </div>
            <?php endif; ?>
            
            <form id="checkoutForm" action="<?php echo e(route('checkout.init')); ?>" method="POST" style="display:none;">
                <?php echo csrf_field(); ?>
                <div id="checkoutItemsContainer"></div>
            </form>
            <?php $__empty_1 = true; $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="cart-item-card item-card-row" id="cart-item-<?php echo e($item->id); ?>" data-price="<?php echo e($item->unit_price); ?>" data-subtotal="<?php echo e($item->subtotal); ?>" data-id="<?php echo e($item->id); ?>">
                    <div style="display: flex; align-items: center; justify-content: center; width: 48px; background: #fff; border-right: 1px solid #f0f0f0;">
                        <input type="checkbox" class="item-checkbox" value="<?php echo e($item->id); ?>" style="width: 18px; height: 18px; accent-color: var(--ud-orange); cursor: pointer;">
                    </div>
                    <img class="cart-item-img"
                        src="<?php echo e($item->product->image_url); ?>"
                        alt="<?php echo e($item->product->product_name); ?>">
                    <div class="cart-item-body">
                        <h3 class="cart-item-name">
                            <?php echo e($item->product->product_name); ?>

                            <?php if($item->variant): ?>
                                <span style="font-weight: 500; color: #555;"> - <?php echo e($item->variant->variant_name); ?></span>
                            <?php endif; ?>
                        </h3>
                        <span class="cart-item-tag">🐕 <?php echo e($item->product->category->category_name ?? 'Pet'); ?></span>
                        <div class="cart-item-details"><?php echo e($item->product->short_description); ?></div>
                        <?php $itemStock = $item->variant ? $item->variant->variant_quantity : $item->product->stock; ?>
                        <?php if($itemStock > 4): ?>
                            <div class="cart-item-status-in">✓ In Stock (<?php echo e($itemStock); ?> available)</div>
                        <?php elseif($itemStock > 0): ?>
                            <div class="cart-item-status-low" style="color: #e67e22;">🔥 Only <?php echo e($itemStock); ?> left!</div>
                        <?php else: ?>
                            <div style="font-size: 12px; color: #ef4444; font-weight: 600;">✗ Out of Stock</div>
                        <?php endif; ?>
                        
                        <div class="cart-item-bottom">
                            <div>
                                <div class="qty-label">Qty</div>
                                <div class="qty-control">
                                    <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" style="display: flex; align-items: center;">
                                        <?php echo csrf_field(); ?>
                                        <button type="button" class="qty-btn" onclick="let v=this.form.quantity;if(+v.value>1){v.value=+v.value-1;this.form.submit();}">−</button>
                                        <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" class="qty-val" readonly>
                                        <button type="button" class="qty-btn" onclick="let v=this.form.quantity;let mx=<?php echo e($itemStock); ?>;if(+v.value<mx){v.value=+v.value+1;this.form.submit();}else{alert('Only '+mx+' unit(s) available.')}">+</button>
                                    </form>
                                </div>
                            </div>
                            <div class="cart-item-price-col">
                                <div class="each-label">
                                    ₱<?php echo e(number_format($item->unit_price, 2)); ?> each
                                    <?php if($item->product->is_sale_active && $item->unit_price < $item->product->price): ?>
                                        <span style="text-decoration: line-through; color: #bbb; margin-left: 4px;">₱<?php echo e(number_format($item->product->price, 2)); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="item-total">₱<?php echo e(number_format($item->subtotal, 2)); ?></div>
                            </div>
                            <a href="<?php echo e(route('cart.remove', $item->id)); ?>" class="delete-btn" title="Remove">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="cart-item-card" style="padding: 40px; justify-content: center; align-items: center; flex-direction: column;">
                    <p>Your cart is empty.</p>
                    <a href="<?php echo e(route('shop.all')); ?>" class="btn-checkout" style="width: auto; margin-top: 20px;">Continue Shopping</a>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($cart->items->isNotEmpty()): ?>
        <div class="cart-summary-col">
            <div class="order-summary-card">
                <h2 class="summary-title">Order Summary</h2>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="summarySubtotal">₱0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="free-ship">FREE</span>
                </div>
                <div class="summary-row total">
                    <span>Selected Total</span>
                    <span class="total-val" id="summaryTotal">₱0.00</span>
                </div>

                <button type="button" class="btn-checkout" onclick="submitCheckout()">
                    Proceed to Checkout (<span id="checkoutCount">0</span>)
                </button>

                <div class="trust-badges">
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Secure
                    </div>
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                        Quality
                    </div>
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        Fast
                    </div>
                </div>
            </div>
            
            <div class="cart-footer-row">
                <a href="<?php echo e(route('shop.all')); ?>" class="continue-link">← Continue Shopping</a>
                <a href="<?php echo e(route('cart.clear')); ?>" class="btn-clear-cart" style="text-decoration: none;">Clear Cart</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function updateCartTotals() {
        let total = 0;
        let count = 0;
        const boxes = document.querySelectorAll('.item-checkbox');
        let allChecked = true;
        let anyUnchecked = false;

        boxes.forEach(box => {
            const row = box.closest('.item-card-row');
            if (box.checked) {
                total += parseFloat(row.getAttribute('data-subtotal'));
                count++;
                row.style.border = '1px solid var(--ud-orange)';
                row.style.boxShadow = '0 4px 12px rgba(255,140,66,0.15)';
            } else {
                row.style.border = '1px solid transparent';
                row.style.boxShadow = '0 2px 10px rgba(0,0,0,0.03)';
                allChecked = false;
                anyUnchecked = true;
            }
        });

        // Update select all checkbox state
        const selectAllBox = document.getElementById('selectAllCheckbox');
        if (selectAllBox) {
            selectAllBox.checked = (boxes.length > 0 && allChecked);
        }

        const formatted = '₱' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('summarySubtotal').innerText = formatted;
        document.getElementById('summaryTotal').innerText = formatted;
        document.getElementById('checkoutCount').innerText = count;
    }

    function toggleSelectAll(source) {
        const boxes = document.querySelectorAll('.item-checkbox');
        boxes.forEach(box => {
            box.checked = source.checked;
        });
        updateCartTotals();
    }

    function submitCheckout() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Please select at least one item to checkout.');
            return;
        }

        const container = document.getElementById('checkoutItemsContainer');
        container.innerHTML = '';
        
        checkedBoxes.forEach(box => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = box.value;
            container.appendChild(input);
        });

        document.getElementById('checkoutForm').submit();
    }

    function saveChecks() {
        const checkedValues = [];
        const boxes = document.querySelectorAll('.item-checkbox:checked');
        boxes.forEach(box => checkedValues.push(box.value));
        localStorage.setItem('cart_checked_items', JSON.stringify(checkedValues));
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        const saved = JSON.parse(localStorage.getItem('cart_checked_items') || '[]');
        const boxes = document.querySelectorAll('.item-checkbox');
        
        boxes.forEach(box => {
            box.checked = saved.includes(box.value);
            box.addEventListener('change', () => {
                updateCartTotals();
                saveChecks();
            });
        });

        // Trigger the visual update + total calculation
        updateCartTotals();
    });

    const selectAllBox = document.getElementById('selectAllCheckbox');
    if (selectAllBox) {
        selectAllBox.addEventListener('change', function() {
            toggleSelectAll(this);
            saveChecks();
        });
    }
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/frontend/cart.blade.php ENDPATH**/ ?>