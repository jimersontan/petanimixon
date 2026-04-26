


<div class="pd-layout">
    
    <div class="pd-gallery">
        <img class="pd-main-img" src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>">
        <?php if($product->is_sale_active): ?>
        <div class="pd-badge-sale">
            <?php echo e($product->discount_type === 'percent' ? $product->discount_amount . '% OFF' : '₱' . number_format($product->discount_amount) . ' OFF'); ?>

        </div>
        <?php endif; ?>
    </div>

    
    <div class="pd-info">
        
        <div class="pd-category"><?php echo e($product->category->category_name ?? 'General'); ?></div>

        
        <h1 class="pd-name"><?php echo e($product->product_name); ?></h1>

        
        <div class="pd-rating-row">
            <span class="pd-stars" style="<?php echo e($reviewStats['count'] == 0 ? 'color: #d1d5db;' : ''); ?>">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php echo e($i <= round($reviewStats['average']) ? '★' : '☆'); ?>

                <?php endfor; ?>
            </span>
            <span class="pd-rating-num"><?php echo e($reviewStats['average']); ?></span>
            <span class="pd-divider">|</span>
            <span class="pd-rating-count"><?php echo e($reviewStats['count']); ?> <?php echo e(Str::plural('Rating', $reviewStats['count'])); ?></span>
            <span class="pd-divider">|</span>
            <span class="pd-sold"><?php echo e($product->total_sold); ?> Sold</span>
        </div>

        
        <div class="pd-price-block">
            <?php if($product->is_sale_active): ?>
                <span class="pd-price-current">₱<?php echo e(number_format($product->sale_price, 2)); ?></span>
                <span class="pd-price-original">₱<?php echo e(number_format($product->price, 2)); ?></span>
                <span class="pd-price-discount">
                    -<?php echo e($product->discount_type === 'percent' ? $product->discount_amount . '%' : '₱' . number_format($product->discount_amount)); ?>

                </span>
            <?php else: ?>
                <span class="pd-price-current">₱<?php echo e(number_format($product->price, 2)); ?></span>
            <?php endif; ?>
        </div>

        
        <?php if($product->short_description || $product->animal_description): ?>
        <p class="pd-desc"><?php echo e($product->short_description ?? $product->animal_description); ?></p>
        <?php endif; ?>

        
        <div class="pd-details-row">
            <?php if($product->brand_name): ?>
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Brand</span>
                <span class="pd-detail-value"><?php echo e($product->brand_name); ?></span>
            </div>
            <?php endif; ?>
            <?php if($product->animal_type): ?>
            <div class="pd-detail-chip">
                <span class="pd-detail-label">For</span>
                <span class="pd-detail-value"><?php echo e($product->animal_type); ?></span>
            </div>
            <?php endif; ?>
            <?php if($product->life_stage): ?>
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Life Stage</span>
                <span class="pd-detail-value"><?php echo e($product->life_stage); ?></span>
            </div>
            <?php endif; ?>
            <?php if($product->wet_or_dry): ?>
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Type</span>
                <span class="pd-detail-value"><?php echo e(ucfirst($product->wet_or_dry)); ?></span>
            </div>
            <?php endif; ?>
            <?php if($product->weight_in_grams): ?>
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Weight</span>
                <span class="pd-detail-value"><?php echo e($product->weight_in_grams >= 1000 ? ($product->weight_in_grams / 1000) . ' KG' : $product->weight_in_grams . ' g'); ?></span>
            </div>
            <?php endif; ?>
        </div>

        
        <hr class="pd-hr">

                
        <?php if($product->variants && $product->variants->count() > 0 && $product->variants->where('uom', '!=', null)->count() > 0): ?>
        <div class="pd-variants-section" style="margin-bottom: 20px;">
            <div style="font-size: 13px; font-weight: 600; color: #444; margin-bottom: 8px;">Select Variant</div>
            <div class="pd-variant-chips" style="display: flex; flex-wrap: wrap; gap: 10px;">
                <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($variant->uom): ?>
                    <button type="button" 
                        class="pd-variant-chip <?php echo e($index === 0 ? 'active' : ''); ?>" 
                        data-id="<?php echo e($variant->id); ?>" 
                        data-price="<?php echo e($variant->variant_price > 0 ? $variant->variant_price : $product->sale_price); ?>" 
                        data-stock="<?php echo e($variant->variant_quantity); ?>"
                        style="padding: 6px 12px; border: 1.5px solid <?php echo e($index === 0 ? 'var(--ud-orange)' : '#ddd'); ?>; border-radius: 6px; background: <?php echo e($index === 0 ? '#FFF7ED' : '#fff'); ?>; color: <?php echo e($index === 0 ? 'var(--ud-orange)' : '#333'); ?>; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        <?php echo e($variant->variant_name); ?>

                    </button>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <?php endif; ?>

        <div id="dynamic-stock-wrapper">
        <?php if($product->stock > 10): ?>
            <div class="pd-stock-badge in">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                In Stock
                <span class="pd-stock-count">(<?php echo e($product->stock); ?> available)</span>
            </div>
        <?php elseif($product->stock > 0): ?>
            <div class="pd-stock-badge low">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                Only <span class="pd-stock-count"><?php echo e($product->stock); ?></span> left — order soon!
            </div>
        <?php else: ?>
            <div class="pd-stock-badge out">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                Out of Stock
            </div>
        <?php endif; ?>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
            <div class="pd-actions">
                
                <div class="pd-qty-row">
                    <span class="pd-qty-label">Quantity</span>
                    <div class="pd-qty-wrap">
                        <button type="button" class="pd-qty-btn" onclick="let v=this.nextElementSibling;v.value=Math.max(1,+v.value-1);v.dispatchEvent(new Event('change'))">−</button>
                        <input type="number" value="1" min="1" max="<?php echo e($product->stock); ?>" class="pd-qty-input pd-main-qty" readonly>
                        <button type="button" class="pd-qty-btn" onclick="let v=this.previousElementSibling;let mx=+(v.getAttribute('max')||999);v.value=Math.min(mx,+v.value+1);v.dispatchEvent(new Event('change'))">+</button>
                    </div>
                </div>

                
                <div class="pd-cta-row">
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="pd-add-form pd-add-cart-form" style="margin: 0; flex: 1;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input type="hidden" name="quantity" value="1" class="pd-cart-add-qty">
                        <button type="submit" class="pd-btn pd-btn-cart" <?php echo e($product->stock < 1 ? 'disabled' : ''); ?>>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                            <?php echo e($product->stock < 1 ? 'Out of Stock' : 'Add to Cart'); ?>

                        </button>
                    </form>

                    <?php if($product->stock > 0): ?>
                        <form action="<?php echo e(route('cart.buy-now')); ?>" method="POST" class="pd-add-form pd-buy-now-form" style="margin: 0; flex: 1;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1" class="pd-buy-now-qty">
                            <button type="submit" class="pd-btn pd-btn-buy">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                Buy Now
                            </button>
                        </form>
                        <script>
                            (function() {
                                var mainQty = document.querySelector('.pd-main-qty');
                                var cartAddQty = document.querySelector('.pd-cart-add-qty');
                                var buyNowQty = document.querySelector('.pd-buy-now-form .pd-buy-now-qty');
                                if (!mainQty) return;
                                var syncQty = function() { 
                                    if(buyNowQty) buyNowQty.value = mainQty.value || 1; 
                                    if(cartAddQty) cartAddQty.value = mainQty.value || 1;
                                };
                                mainQty.addEventListener('change', syncQty);
                                mainQty.addEventListener('input', syncQty);
                            })();
                        </script>
                    <?php endif; ?>

                    
                    <form action="<?php echo e(route('wishlist.toggle')); ?>" method="POST" style="margin: 0;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <button type="submit" class="pd-btn pd-btn-wish <?php echo e((Auth::check() && \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists()) ? 'active' : ''); ?>" title="Toggle Wishlist">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="<?php echo e((Auth::check() && \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists()) ? 'currentColor' : 'none'); ?>" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="pd-actions">
                <div class="pd-cta-row">
                    <a href="<?php echo e(route('login')); ?>" class="pd-btn pd-btn-cart" style="text-decoration: none; text-align: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                        Add to Cart
                    </a>
                    <?php if($product->stock > 0): ?>
                    <a href="<?php echo e(route('login')); ?>" class="pd-btn pd-btn-buy" style="text-decoration: none; text-align: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Buy Now
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('login')); ?>" class="pd-btn pd-btn-wish" title="Add to Wishlist" style="text-decoration: none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="pd-trust-row">
            <div class="pd-trust-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3DB868" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Secure Payment</span>
            </div>
            <div class="pd-trust-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><rect x="1" y="3" width="22" height="18" rx="2"/><path d="M1 9h22"/></svg>
                <span>Free Returns</span>
            </div>
            <div class="pd-trust-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--ud-orange)" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 12 16 16 16 8"/><path d="M1 16h15"/></svg>
                <span>Fast Delivery</span>
            </div>
        </div>
    </div>
</div>


<div class="rv-section">
    <h2>Customer Reviews</h2>

    
    <div class="rv-summary">
        <div class="rv-avg">
            <div class="rv-avg-num"><?php echo e($reviewStats['average']); ?></div>
            <div class="rv-avg-stars" style="<?php echo e($reviewStats['count'] == 0 ? 'color: #d1d5db;' : ''); ?>">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php echo e($i <= round($reviewStats['average']) ? '★' : '☆'); ?>

                <?php endfor; ?>
            </div>
            <div class="rv-avg-count"><?php echo e($reviewStats['count']); ?> <?php echo e(Str::plural('review', $reviewStats['count'])); ?></div>
        </div>
        <div class="rv-bars">
            <?php $__currentLoopData = $reviewStats['distribution']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rv-bar-row">
                <span class="rv-bar-label"><?php echo e($star); ?></span>
                <span class="rv-bar-star">★</span>
                <div class="rv-bar-track">
                    <div class="rv-bar-fill" style="width: <?php echo e($reviewStats['count'] > 0 ? ($count / $reviewStats['count'] * 100) : 0); ?>%"></div>
                </div>
                <span class="rv-bar-count"><?php echo e($count); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="rv-list">
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="rv-card" id="review-<?php echo e($review->id); ?>">
            <div class="rv-card-header">
                <div class="rv-avatar"><?php echo e(strtoupper(substr($review->user->name ?? 'U', 0, 1))); ?></div>
                <div>
                    <div class="rv-user-name"><?php echo e($review->user->name ?? 'Anonymous'); ?></div>
                </div>
                <span class="rv-date"><?php echo e($review->created_at->diffForHumans()); ?></span>
            </div>
            <div class="rv-card-stars">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php echo e($i <= $review->rating ? '★' : '☆'); ?>

                <?php endfor; ?>
            </div>
            <?php if($review->comment): ?>
            <div class="rv-card-text"><?php echo e($review->comment); ?></div>
            <?php endif; ?>

            
            <?php if(!empty($review->image_urls)): ?>
            <div class="rv-card-images">
                <?php $__currentLoopData = $review->image_urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img class="rv-card-img" src="<?php echo e($imgUrl); ?>" alt="Review photo" onclick="window.openLightbox('<?php echo e($imgUrl); ?>')">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            
            <div class="rv-actions">
                <?php if(auth()->guard()->check()): ?>
                <button type="button" class="rv-like-btn <?php echo e($review->isLikedBy(Auth::id()) ? 'liked' : ''); ?>" onclick="window.toggleLike(<?php echo e($review->id); ?>, this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <span><?php echo e($review->likes->count()); ?></span>
                </button>
                <button type="button" class="rv-reply-toggle" onclick="window.toggleReplyForm(<?php echo e($review->id); ?>)">💬 Reply (<?php echo e($review->replies->count()); ?>)</button>
                <?php else: ?>
                <span style="font-size:13px;color:#888;">❤️ <?php echo e($review->likes->count()); ?> · 💬 <?php echo e($review->replies->count()); ?></span>
                <?php endif; ?>
            </div>

            
            <div class="rv-replies" id="replies-<?php echo e($review->id); ?>" style="<?php echo e($review->replies->count() > 0 ? '' : 'display:none;'); ?>">
                <?php $__currentLoopData = $review->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rv-reply">
                    <span class="rv-reply-name"><?php echo e($reply->user->name ?? 'User'); ?></span>
                    <span class="rv-reply-date">· <?php echo e($reply->created_at->diffForHumans()); ?></span>
                    <div class="rv-reply-text"><?php echo e($reply->reply); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(auth()->guard()->check()): ?>
                <form class="rv-reply-form" action="<?php echo e(route('review.reply', $review->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="text" name="reply" class="rv-reply-input" placeholder="Write a reply..." required>
                    <button type="submit" class="rv-reply-submit">Reply</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="rv-no-reviews">No reviews yet. Be the first to review this product! 🐾</div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/frontend/partials/product_modal_content.blade.php ENDPATH**/ ?>