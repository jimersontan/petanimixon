

<?php $__env->startSection('title', 'Riders Management'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/rider.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
                <h1 class="page-title">Riders Management</h1>
                <button type="button" class="btn-rider-primary" id="btnCreateRider" onclick="document.getElementById('createRiderModal').style.display='flex'">
                    + Add Rider
                </button>
            </div>

            <!-- Stats -->
            <div class="rider-stats-grid" style="margin-bottom: 24px;">
                <div class="rider-stat-card">
                    <div class="rider-stat-icon green">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value"><?php echo e($totalRiders ?? 0); ?></div>
                        <div class="rider-stat-label">Total Riders</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value"><?php echo e($activeRiders ?? 0); ?></div>
                        <div class="rider-stat-label">Active Riders</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 10h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value"><?php echo e($deliveriesToday ?? 0); ?></div>
                        <div class="rider-stat-label">Deliveries Today</div>
                    </div>
                </div>
            </div>

            <!-- Riders Table -->
            <div class="rider-card">
                <div class="rider-card-header">
                    <h2>🛵 All Riders</h2>
                </div>
                <div class="rider-table-wrap">
                    <table class="rider-table">
                        <thead>
                            <tr>
                                <th>Rider</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Deliveries</th>
                                <th>Active</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $riders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php /** @var \App\Models\User $rider */ ?>
                            <tr>
                                <td>
                                    <div class="rider-name-cell"><?php echo e($rider->full_name); ?></div>
                                </td>
                                <td>
                                    <div class="rider-email-cell"><?php echo e($rider->email); ?></div>
                                </td>
                                <td><?php echo e($rider->phone_number ?? '—'); ?></td>
                                <td>
                                    <span class="rider-badge-status rider-badge-<?php echo e($rider->account_status); ?>">
                                        <?php echo e(ucfirst($rider->account_status)); ?>

                                    </span>
                                </td>
                                <td><strong><?php echo e($rider->total_deliveries ?? 0); ?></strong></td>
                                <td><?php echo e($rider->active_deliveries ?? 0); ?></td>
                                <td><?php echo e($rider->created_at->format('M j, Y')); ?></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="<?php echo e(route('riders.edit', $rider->id)); ?>" class="btn-rider-secondary btn-rider-sm">Edit</a>
                                        <form action="<?php echo e(route('riders.toggle', $rider->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn-rider-sm <?php echo e($rider->account_status === 'active' ? 'btn-rider-warning' : 'btn-rider-success'); ?>"
                                                onclick="return confirm('<?php echo e($rider->account_status === 'active' ? 'Deactivate' : 'Activate'); ?> this rider?')">
                                                <?php echo e($rider->account_status === 'active' ? 'Deactivate' : 'Activate'); ?>

                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px 20px; color: var(--rider-text-muted);">
                                    <div style="font-size: 2rem; margin-bottom: 8px;">🛵</div>
                                    <strong>No riders yet.</strong><br>
                                    Click "Add Rider" to create the first delivery rider account.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(isset($riders) && $riders->hasPages()): ?>
                <div class="rider-pagination">
                    <?php echo e($riders->links()); ?>

                </div>
                <?php endif; ?>
            </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- ===== CREATE RIDER MODAL ===== -->
    <div class="rider-modal-overlay" id="createRiderModal" style="display: none;">
        <div class="rider-modal">
            <div class="rider-modal-header">
                <h2>🛵 Create New Rider</h2>
                <button type="button" class="rider-modal-close" onclick="document.getElementById('createRiderModal').style.display='none'">&times;</button>
            </div>
            <form action="<?php echo e(route('riders.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="rider-modal-body">
                    <?php if($errors->any()): ?>
                        <div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; border: 1px solid #fecaca;">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <div class="rider-form-row">
                        <div class="rider-form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo e(old('first_name')); ?>" required placeholder="Juan">
                        </div>
                        <div class="rider-form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo e(old('last_name')); ?>" required placeholder="Dela Cruz">
                        </div>
                    </div>
                    <div class="rider-form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="rider@email.com">
                    </div>
                    <div class="rider-form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="<?php echo e(old('phone_number')); ?>" placeholder="09XX-XXX-XXXX">
                    </div>
                    <div class="rider-form-row">
                        <div class="rider-form-group">
                            <label for="password">Password *</label>
                            <input type="password" id="password" name="password" required placeholder="Min 6 characters">
                        </div>
                        <div class="rider-form-group">
                            <label for="password_confirmation">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                        </div>
                    </div>
                </div>
                <div class="rider-modal-footer">
                    <button type="button" class="btn-rider-secondary" onclick="document.getElementById('createRiderModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-rider-primary">Create Rider 🛵</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== EDIT RIDER MODAL ===== -->
    <?php if(isset($showEditModal) && isset($editRider)): ?>
    <div class="rider-modal-overlay" id="editRiderModal" style="display: flex;">
        <div class="rider-modal">
            <div class="rider-modal-header">
                <h2>✏️ Edit Rider</h2>
                <a href="<?php echo e(route('riders.admin')); ?>" class="rider-modal-close">&times;</a>
            </div>
            <form action="<?php echo e(route('riders.update', $editRider->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="rider-modal-body">
                    <div class="rider-form-row">
                        <div class="rider-form-group">
                            <label for="edit_first_name">First Name *</label>
                            <input type="text" id="edit_first_name" name="first_name" value="<?php echo e($editRider->first_name); ?>" required>
                        </div>
                        <div class="rider-form-group">
                            <label for="edit_last_name">Last Name *</label>
                            <input type="text" id="edit_last_name" name="last_name" value="<?php echo e($editRider->last_name); ?>" required>
                        </div>
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_email">Email Address *</label>
                        <input type="email" id="edit_email" name="email" value="<?php echo e($editRider->email); ?>" required>
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_phone_number">Phone Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number" value="<?php echo e($editRider->phone_number); ?>">
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_password">New Password (leave blank to keep current)</label>
                        <input type="password" id="edit_password" name="password" placeholder="Leave blank to keep current">
                    </div>
                </div>
                <div class="rider-modal-footer">
                    <a href="<?php echo e(route('riders.admin')); ?>" class="btn-rider-secondary">Cancel</a>
                    <button type="submit" class="btn-rider-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
        // Auto-show create modal if there are errors and we were creating
        <?php if($errors->any() && !isset($showEditModal)): ?>
            document.getElementById('createRiderModal').style.display = 'flex';
        <?php endif; ?>

        // Close modals on overlay click
        document.querySelectorAll('.rider-modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.style.display = 'none';
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/riders_admin.blade.php ENDPATH**/ ?>