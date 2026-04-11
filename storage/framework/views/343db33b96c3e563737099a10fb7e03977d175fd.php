<?php $__env->startSection('title', 'Product Q&A'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-header">
    <h1 class="page-title">Product Q&A</h1>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg></div>
        <div class="metric-content"><div class="metric-value"><?php echo e($stats['total']); ?></div><div class="metric-label">Total Questions</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#fef3c7; color:#d97706;"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm-.5-3h1v1h-1zm0-10h1v8h-1z"/></svg></div>
        <div class="metric-content"><div class="metric-value"><?php echo e($stats['unanswered']); ?></div><div class="metric-label">Unanswered</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
        <div class="metric-content"><div class="metric-value"><?php echo e($stats['answered']); ?></div><div class="metric-label">Answered</div></div>
    </div>
</div>

<div class="card orders-table-card">
    <div class="orders-section-header"><h2 class="card-title">Questions</h2></div>
    <div class="order-status-tabs" role="tablist">
        <a href="<?php echo e(route('qa.admin', ['filter' => 'unanswered'])); ?>" class="order-tab <?php echo e($filter === 'unanswered' ? 'active' : ''); ?>">Unanswered</a>
        <a href="<?php echo e(route('qa.admin', ['filter' => 'answered'])); ?>" class="order-tab <?php echo e($filter === 'answered' ? 'active' : ''); ?>">Answered</a>
        <a href="<?php echo e(route('qa.admin', ['filter' => 'all'])); ?>" class="order-tab <?php echo e($filter === 'all' ? 'active' : ''); ?>">All</a>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px; padding: 20px 0;">
        <?php $__empty_1 = true; $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <div>
                    <div style="font-weight: 700; color: #1a1a2e; margin-bottom: 4px;">
                        <?php echo e($question->user->full_name ?? 'Customer'); ?>

                        <span style="color: #999; font-weight: 400; font-size: 13px;">asked about</span>
                        <a href="<?php echo e(route('product.show', $question->product_id)); ?>" style="color: #ea580c; text-decoration: none; font-weight: 600;"><?php echo e($question->product->product_name ?? 'Product #'.$question->product_id); ?></a>
                    </div>
                    <div style="font-size: 12px; color: #999;"><?php echo e($question->created_at->diffForHumans()); ?></div>
                </div>
                <?php if($question->answer_text): ?>
                    <span class="status-badge" style="background:#dcfce7; color:#16a34a;">Answered</span>
                <?php else: ?>
                    <span class="status-badge" style="background:#fef3c7; color:#d97706;">Pending</span>
                <?php endif; ?>
            </div>

            <div style="background: #f9fafb; border-radius: 8px; padding: 14px; margin-bottom: 12px;">
                <div style="font-size: 13px; color: #666; margin-bottom: 4px; font-weight: 600;">❓ Question:</div>
                <p style="margin: 0; color: #333;"><?php echo e($question->question_text); ?></p>
            </div>

            <?php if($question->answer_text): ?>
                <div style="background: #f0fdf4; border-radius: 8px; padding: 14px; border-left: 3px solid #16a34a;">
                    <div style="font-size: 13px; color: #16a34a; margin-bottom: 4px; font-weight: 600;">✅ Answer:</div>
                    <p style="margin: 0; color: #333;"><?php echo e($question->answer_text); ?></p>
                </div>
            <?php else: ?>
                <form method="POST" action="<?php echo e(route('qa.answer', $question->id)); ?>" style="display: flex; gap: 8px;">
                    <?php echo csrf_field(); ?>
                    <input type="text" name="answer_text" class="form-control" placeholder="Type your answer..." required style="flex: 1;">
                    <button type="submit" class="btn-primary" style="white-space: nowrap;">Post Answer</button>
                </form>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="text-align: center; padding: 40px; color: #999;">
            <div style="font-size: 48px; margin-bottom: 12px;">💬</div>
            <p>No <?php echo e($filter === 'unanswered' ? 'unanswered ' : ''); ?>questions found.</p>
        </div>
        <?php endif; ?>
    </div>

    <div class="mt-4"><?php echo e($questions->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/qa_admin.blade.php ENDPATH**/ ?>