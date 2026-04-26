

<?php $__env->startSection('title', 'Customers'); ?>

<?php $__env->startSection('content'); ?>
            <div class="content-header">
                <div>
                    <h1 class="page-title">Customers</h1>
                    <p class="page-subtitle">Manage and track your customer base</p>
                </div>
                <div class="date-filter">
                    <form method="get" action="<?php echo e(route('customers.admin')); ?>" class="date-filter-form" id="customersDateForm">
                        <select name="days" id="customersDateRange" class="filter-select" aria-label="Date range">
                            <option value="7" <?php echo e(($days ?? 30) == 7 ? 'selected' : ''); ?>>Last 7 days</option>
                            <option value="30" <?php echo e(($days ?? 30) == 30 ? 'selected' : ''); ?>>Last 30 days</option>
                            <option value="90" <?php echo e(($days ?? 30) == 90 ? 'selected' : ''); ?>>Last 90 days</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Summary cards -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['total_customers'] ?? 0)); ?></div>
                        <div class="metric-label">Total Customers</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-pending">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['new_this_month'] ?? 0)); ?></div>
                        <div class="metric-label">New This Month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-completed">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['active_customers'] ?? 0)); ?></div>
                        <div class="metric-label">Active</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">₱<?php echo e(number_format($stats['avg_clv'] ?? 0)); ?></div>
                        <div class="metric-label">Avg CLV</div>
                    </div>
                </div>
            </div>

            <!-- Customers table -->
            <div class="card orders-table-card">
                <div class="orders-section-header">
                    <h2 class="card-title">All Customers</h2>
                    <div class="orders-actions">
                        <button type="button" class="btn-secondary btn-export">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                            Export
                        </button>
                    </div>
                </div>

                <div class="order-status-tabs" role="tablist">
                    <button type="button" class="order-tab active" data-status="all" role="tab" aria-selected="true">All</button>
                    <button type="button" class="order-tab" data-status="active" role="tab">Active</button>
                    <button type="button" class="order-tab" data-status="inactive" role="tab">Inactive</button>
                    <button type="button" class="order-tab" data-status="vip" role="tab">VIP</button>
                </div>

                <div class="table-wrap">
                    <table class="orders-table" id="customersTable">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Registered</th>
                                <th>Status</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $statusBadge = [
                                    'active' => 'badge-paid',
                                    'inactive' => 'badge-failed',
                                    'vip' => 'badge-processing',
                                ];
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = ($customers ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php /** @var \App\Models\User $customer */ ?>
                            <tr data-status="<?php echo e($customer->account_status ?? 'active'); ?>">
                                <td>
                                    <div class="customer-cell"><?php echo e(trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: '—'); ?></div>
                                    <div class="customer-email">ID: #<?php echo e($customer->id); ?></div>
                                </td>
                                <td><?php echo e($customer->email ?? '—'); ?></td>
                                <td><?php echo e($customer->phone_number ?? '—'); ?></td>
                                <td><?php echo e($customer->orders_count ?? 0); ?></td>
                                <td><?php echo e(isset($customer->total_spent) ? '₱' . number_format($customer->total_spent, 2) : '₱0.00'); ?></td>
                                <td><?php echo e(optional($customer->created_at)->format('M j, Y') ?? '—'); ?></td>
                                <td>
                                    <?php $status = $customer->account_status ?? 'active'; ?>
                                    <span class="badge <?php echo e($statusBadge[$status] ?? 'badge-pending'); ?>"><?php echo e(strtoupper($status)); ?></span>
                                </td>
                                <td class="col-actions">
                                    <button type="button" class="action-btn" title="View Details" aria-label="View customer" onclick="openCustomerModal(<?php echo e($customer->id); ?>)">
                                        <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/></svg>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center empty-orders">No customers found yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(isset($customers) && $customers instanceof \Illuminate\Pagination\LengthAwarePaginator && $customers->hasPages()): ?>
                <div class="orders-pagination">
                    <?php echo e($customers->links()); ?>

                </div>
                <?php endif; ?>
            </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
    <!-- Customer Details Modal -->
    <div class="modal-backdrop" id="customerModalBackdrop"></div>
    <div id="customerModal" class="modal" style="max-width: 600px; width: 95%;" role="dialog" aria-modal="true" tabindex="-1">
        <div class="modal-header">
            <h2 class="modal-title">Customer Details</h2>
            <button type="button" class="modal-close" onclick="closeCustomerModal()" aria-label="Close modal">&times;</button>
        </div>
        <div class="modal-body" id="customerModalBody" style="padding-top: 10px;">
            <div style="text-align: center; color: #6b7280; padding: 20px;">Loading customer details...</div>
        </div>
        <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
            <button type="button" class="btn-secondary" onclick="closeCustomerModal()">Close</button>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function openCustomerModal(id) {
            const modal = document.getElementById('customerModal');
            const backdrop = document.getElementById('customerModalBackdrop');
            const body = document.getElementById('customerModalBody');
            
            modal.classList.add('open');
            backdrop.classList.add('open');
            
            body.innerHTML = '<div style="text-align: center; color: #6b7280; padding: 20px;">Loading customer details...</div>';
            
            fetch(`/admin/api/customers/${id}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                let html = `
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--ud-orange-dark); color: white; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold;">
                            ${(data.first_name?.[0] || '') + (data.last_name?.[0] || '') || 'C'}
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 18px; color: #1f2937;">${data.first_name || ''} ${data.last_name || ''}</h3>
                            <div style="color: #6b7280; font-size: 14px;">${data.email}</div>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div style="background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Contact</div>
                            <div style="font-size: 14px; color: #1f2937;">${data.phone_number || 'No phone'}</div>
                        </div>
                        <div style="background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Status</div>
                            <div style="font-size: 14px; color: #1f2937; text-transform: capitalize;">${data.account_status || 'Active'}</div>
                        </div>
                    </div>
                    
                    <h4 style="margin: 0 0 12px 0; font-size: 15px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">Shipping Address</h4>
                    <div style="font-size: 14px; color: #4b5563; margin-bottom: 24px; line-height: 1.5;">
                        ${data.full_address || '<ul><li>No address provided.</li></ul>'}
                    </div>
                    
                    <h4 style="margin: 0 0 12px 0; font-size: 15px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">Recent Orders</h4>
                `;
                
                if (data.recent_orders && data.recent_orders.length > 0) {
                    html += '<table class="orders-table" style="margin-top: 0;"><thead><tr><th>Order ID</th><th>Date</th><th>Status</th><th>Total</th></tr></thead><tbody>';
                    data.recent_orders.forEach(order => {
                        html += `
                            <tr>
                                <td>#${order.id}</td>
                                <td>${new Date(order.created_at).toLocaleDateString()}</td>
                                <td><span class="badge ${order.status === 'delivered' ? 'badge-paid' : (order.status === 'cancelled' ? 'badge-failed' : 'badge-pending')}">${order.status}</span></td>
                                <td>₱${parseFloat(order.total_amount).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    html += '</tbody></table>';
                } else {
                    html += '<div style="color: #6b7280; font-size: 14px;">No recent orders.</div>';
                }
                
                body.innerHTML = html;
            })
            .catch(err => {
                body.innerHTML = '<div style="text-align: center; color: #ef4444; padding: 20px;">Failed to load customer details.</div>';
            });
        }
        
        function closeCustomerModal() {
            document.getElementById('customerModal').classList.remove('open');
            document.getElementById('customerModalBackdrop').classList.remove('open');
        }
    </script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/customers_admin.blade.php ENDPATH**/ ?>