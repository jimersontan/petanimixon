
<div class="pd-layout">
    <div class="pd-gallery">
        <img class="pd-main-img" src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>">
    </div>
    <div class="pd-info">
        <div class="pd-category"><?php echo e($product->category->category_name ?? 'General'); ?></div>
        <h1 class="pd-name"><?php echo e($product->product_name); ?></h1>

        <div class="pd-rating-row">
            <span class="pd-stars">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php echo e($i <= round($reviewStats['average']) ? '★' : '☆'); ?>

                <?php endfor; ?>
            </span>
            <span class="pd-rating-num"><?php echo e($reviewStats['average']); ?></span>
            <span class="pd-rating-count">(<?php echo e($reviewStats['count']); ?> <?php echo e(Str::plural('review', $reviewStats['count'])); ?>)</span>
            <span class="pd-sold"><?php echo e($product->total_sold); ?> sold</span>
        </div>

        <div class="pd-price">₱<?php echo e(number_format($product->price, 2)); ?></div>

        <p class="pd-desc"><?php echo e($product->short_description ?? $product->animal_description); ?></p>

        <?php if($product->stock > 0): ?>
            <div class="pd-stock">✓ In Stock (<?php echo e($product->stock); ?> available)</div>
        <?php else: ?>
            <div class="pd-stock out">✕ Out of Stock</div>
        <?php endif; ?>

        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="pd-add-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
            <div class="pd-qty-wrap">
                <button type="button" class="pd-qty-btn" onclick="let v=this.nextElementSibling;v.value=Math.max(1,+v.value-1)">−</button>
                <input type="number" name="quantity" value="1" min="1" class="pd-qty-input" readonly>
                <button type="button" class="pd-qty-btn" onclick="let v=this.previousElementSibling;v.value=+v.value+1">+</button>
            </div>
            <button type="submit" class="pd-add-btn">🛒 Add to Cart</button>
        </form>
    </div>
</div>


<div class="rv-section">
    <h2>⭐ Customer Reviews</h2>

    
    <div class="rv-summary">
        <div class="rv-avg">
            <div class="rv-avg-num"><?php echo e($reviewStats['average']); ?></div>
            <div class="rv-avg-stars">
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

    
    <?php if(auth()->guard()->check()): ?>
    <div class="rv-write">
        <h3>Write a Review</h3>
        <form action="<?php echo e(route('review.store', $product->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="rv-star-input">
                <?php for($i = 5; $i >= 1; $i--): ?>
                <input type="radio" name="rating" id="modal-star<?php echo e($i); ?>" value="<?php echo e($i); ?>" <?php echo e($i == 5 ? 'checked' : ''); ?>>
                <label for="modal-star<?php echo e($i); ?>">★</label>
                <?php endfor; ?>
            </div>
            <textarea name="comment" class="rv-textarea" placeholder="Share your experience with this product..."></textarea>
            <div class="rv-img-upload">
                <label class="rv-img-label">📷 Add photos (max 4)</label>
                <input type="file" name="review_images[]" multiple accept="image/*" onchange="window.previewImages(this)" style="font-size:13px;">
                <div class="rv-img-preview" id="imgPreview"></div>
            </div>
            <button type="submit" class="rv-submit">Submit Review</button>
        </form>
    </div>
    <?php else: ?>
    <div class="rv-login-cta">
        <a href="<?php echo e(route('login')); ?>">Log in</a> to write a review
    </div>
    <?php endif; ?>

    
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
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views\frontend\partials\product_modal_content.blade.php ENDPATH**/ ?>