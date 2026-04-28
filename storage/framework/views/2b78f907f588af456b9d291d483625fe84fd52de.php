

<?php $__env->startSection('title', 'Shopping Cart - Pet Markt-PH'); ?>
<?php $__env->startSection('hide-global-header-mobile', true); ?>

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
    .cart-summary-col { width: 340px; flex-shrink: 0; }

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
        background: white; border-radius: 20px;
        padding: 28px; box-shadow: 0 10px 40px rgba(0,0,0,.08);
        border: 1px solid #f0f0f0;
        position: sticky; top: 20px;
    }
    .summary-title { font-size: 18px; font-weight: 800; color: #1e293b; margin: 0 0 24px; }
    .summary-row {
        display: flex; justify-content: space-between;
        align-items: center; font-size: 14px; color: #64748b;
        margin-bottom: 16px; font-weight: 500;
    }
    .summary-row.total {
        font-size: 16px; font-weight: 700; color: #1e293b;
        border-top: 2px dashed #e2e8f0; padding-top: 20px;
        margin-top: 8px; margin-bottom: 24px;
    }
    .summary-row.total .total-val { color: #ff8a00; font-size: 24px; font-weight: 900; }
    .free-ship { color: #10b981; font-weight: 700; font-size: 13px; background: #d1fae5; padding: 4px 10px; border-radius: 20px; }
    
    .btn-checkout {
        width: 100%; padding: 16px 12px; text-transform: uppercase;
        background: linear-gradient(135deg, #ff8a00, #e65100); color: white;
        border: none; border-radius: 14px; box-shadow: 0 6px 20px rgba(230,81,0,0.3);
        font-size: 14px; font-weight: 800; letter-spacing: 0.5px;
        cursor: pointer; transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap;
    }
    .btn-checkout:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(230,81,0,0.4); }
    .btn-checkout span.count-badge {
        background: rgba(255,255,255,0.25); padding: 2px 8px; border-radius: 10px; font-size: 14px;
    }

    /* Trust badges */
    .trust-badges {
        display: flex; justify-content: space-between;
        gap: 8px; margin-top: 24px; text-align: center;
        background: #f8fafc; padding: 16px 12px; border-radius: 14px; border: 1px solid #f1f5f9;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }
    .trust-badge { font-size: 11px; font-weight: 700; color: #64748b; display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .trust-badge svg { width: 22px; height: 22px; color: #ff8a00; }

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

    /* Mobile styles are managed securely by mobile.css — Removed local overrides */
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Mobile Standalone Header -->
<div class="cart-mobile-header">
    <a href="<?php echo e(route('shop.all')); ?>" aria-label="Back" class="mob-back-btn">
        <svg width="24" height="24" fill="none" stroke="#333" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="mob-header-title">My Cart (<?php echo e($cart->items->count()); ?>)</h2>
    <?php if($cart->items->isNotEmpty()): ?>
    <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="mob-clear-cart" onsubmit="return confirm('Clear your entire cart?')">
        <?php echo csrf_field(); ?>
        <button type="submit" aria-label="Clear Cart" class="mob-trash-btn">
            <svg width="22" height="22" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/></svg>
        </button>
    </form>
    <?php else: ?>
    <div style="width:24px"></div>
    <?php endif; ?>
</div>

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
    
    <div class="hide-on-mobile">
        <h1 class="cart-heading">Shopping Cart</h1>
        <p class="cart-sub">(<?php echo e($cart->items->count()); ?> items in your cart)</p>
    </div>

    <div class="cart-layout">
        
        <div class="cart-items-col">
            <?php if($cart->items->isNotEmpty()): ?>
            <div class="cart-select-all-row">
                <div style="display:flex; align-items:center; gap: 12px;">
                    <input type="checkbox" id="selectAllCheckbox" style="cursor: pointer;">
                    <label for="selectAllCheckbox" style="font-weight: 700; color: #333; cursor: pointer; user-select: none;">Select All Items</label>
                </div>
                <button type="button" class="btn-delete-selected hide-on-desktop" onclick="deleteSelectedMob()">Delete Selected</button>
            </div>
            <?php endif; ?>
            
            <form id="checkoutForm" action="<?php echo e(route('checkout.init')); ?>" method="POST" style="display:none;">
                <?php echo csrf_field(); ?>
                <div id="checkoutItemsContainer"></div>
            </form>
            <?php $__empty_1 = true; $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="cart-item-card item-card-row" id="cart-item-<?php echo e($item->id); ?>" data-price="<?php echo e($item->unit_price); ?>" data-subtotal="<?php echo e($item->subtotal); ?>" data-id="<?php echo e($item->id); ?>">
                    <div style="display: flex; align-items: center; justify-content: center; width: 44px; flex-shrink: 0;">
                        <input type="checkbox" class="item-checkbox" value="<?php echo e($item->id); ?>" style="cursor: pointer;">
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
                        
                        <div class="cart-item-status-row">
                            <?php $itemStock = $item->variant ? $item->variant->variant_quantity : $item->product->stock; ?>
                            <?php if($itemStock > 4): ?>
                                <div class="cart-item-status-in">✓ In Stock</div>
                            <?php elseif($itemStock > 0): ?>
                                <div class="cart-item-status-low" style="color: #e67e22;">🔥 Only <?php echo e($itemStock); ?> left!</div>
                            <?php else: ?>
                                <div style="font-size: 11px; color: #ef4444; font-weight: 600;">✗ Out of Stock</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="cart-item-bottom">
                            <div class="qty-control">
                                <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" style="display: flex; align-items: center;">
                                    <?php echo csrf_field(); ?>
                                    <button type="button" class="qty-btn" onclick="let v=this.form.quantity;if(+v.value>1){v.value=+v.value-1;this.form.submit();}">−</button>
                                    <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" class="qty-val" readonly>
                                    <button type="button" class="qty-btn" onclick="let v=this.form.quantity;let mx=<?php echo e($itemStock); ?>;if(+v.value<mx){v.value=+v.value+1;this.form.submit();}else{alert('Only '+mx+' unit(s) available.')}">+</button>
                                </form>
                            </div>
                            
                            <div class="cart-item-price-col">
                                <?php if($item->product->is_sale_active && $item->unit_price < $item->product->price): ?>
                                    <div class="item-original-price">₱<?php echo e(number_format($item->product->price, 2)); ?></div>
                                <?php endif; ?>
                                <div class="item-sale-price">₱<?php echo e(number_format($item->subtotal, 2)); ?></div>
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
                    <span id="summarySubtotal" class="summary-subtotal-val">₱0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="free-ship">TBD</span>
                </div>
                
                <hr style="border-top:1px dashed #e2e8f0; margin: 16px 0;" class="summary-hr">
                
                <div class="summary-row total">
                     <span>Total</span>
                     <span class="total-val" id="summaryTotal">₱0.00</span>
                </div>
                
                <button type="button" class="btn-checkout" onclick="submitCheckout()">
                    Proceed to Checkout (<span class="count-badge" id="checkoutCount">0</span>) <span class="hide-on-mobile">&mdash;</span> <span id="checkoutTotalVal" class="hide-on-mobile">₱0.00</span>
                </button>
                
                <div class="mob-continue-shopping-wrap hide-on-desktop">
                    <a href="<?php echo e(route('shop.all')); ?>" class="mob-continue-link">← Continue Shopping</a>
                </div>
                
                <div class="trust-badges hide-on-mobile">
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        SSL Secure
                    </div>
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Top Quality
                    </div>
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Fast Delivery
                    </div>
                </div>
            </div>
            <div class="cart-footer-row hide-on-mobile">
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
        
        const countBadgeDesktop = document.getElementById('checkoutCountBadge');
        if(countBadgeDesktop) countBadgeDesktop.innerText = count;
        
        const totalVal = document.getElementById('checkoutTotalVal');
        if(totalVal) totalVal.innerText = formatted;
    }

    function deleteSelectedMob() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Please select items to delete.');
            return;
        }
        if (confirm('Delete ' + checkedBoxes.length + ' selected item(s)?')) {
            alert('Bulk delete route to be configured.');
        }
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



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/frontend/cart.blade.php ENDPATH**/ ?>