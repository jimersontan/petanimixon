<?php
$file = 'resources/views/dashboard_admin.blade.php';
$lines = file($file);

$startIndex = -1;
$endIndex = -1;

for ($i = 0; $i < count($lines); $i++) {
    if (strpos($lines[$i], '<!-- Visitor Chart Box Placeholder -->') !== false) {
        $startIndex = $i;
    }
    if ($startIndex !== -1 && strpos($lines[$i], '<!-- Weekly Revenue Bar Chart -->') !== false) {
        $endIndex = $i - 1; // Previous line before weekly revenue
        break;
    }
}

if ($startIndex !== -1 && $endIndex !== -1) {
    // Remove old lines
    array_splice($lines, $startIndex, $endIndex - $startIndex);
    
    // Insert new content
    $replacement = <<<EOF
                    <!-- Order Status & Delivery Performance Widget -->
                    <div class="v2-card" style="padding-bottom:16px; margin-bottom: 20px;">
                        <!-- Top Half: Order Status -->
                        <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                            <div class="v2-card-header" style="margin-bottom:12px;">
                                <h2 class="v2-card-title">Order Status</h2>
                                <span style="font-size:12px; color:#6b7280; font-weight:600;">Total: {{ \$totalOrders }}</span>
                            </div>
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">Pending</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#fcd34d; width: {{ \$totalOrders ? (\$pendingOrdersCount / \$totalOrders) * 100 : 0 }}%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;">{{ \$pendingOrdersCount }}</div>
                                </div>
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">Processing</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#3b82f6; width: {{ \$totalOrders ? (\$processingCount / \$totalOrders) * 100 : 0 }}%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;">{{ \$processingCount }}</div>
                                </div>
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">In Transit</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#f97316; width: {{ \$totalOrders ? (\$transitCount / \$totalOrders) * 100 : 0 }}%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;">{{ \$transitCount }}</div>
                                </div>
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">Delivered</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#10b981; width: {{ \$totalOrders ? (\$completedCount / \$totalOrders) * 100 : 0 }}%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;">{{ \$completedCount }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Half: Delivery Performance -->
                        <div>
                            <div class="v2-card-header" style="margin-bottom:12px;">
                                <h2 class="v2-card-title">Delivery Performance</h2>
                                <span style="font-size:14px; cursor:pointer; color:#d1d5db;">ⓘ</span>
                            </div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                                <div style="background:#f8fafc; padding:12px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        Avg Time
                                    </div>
                                    <div style="font-size:18px; font-weight:800; color:#0f172a; margin-top:6px;">{{ \$avgDeliveryTime }} <span style="font-size:10px; font-weight:600; color:#64748b;">mins</span></div>
                                </div>
                                <div style="background:#f8fafc; padding:12px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        On-Time Rate
                                    </div>
                                    <div style="font-size:18px; font-weight:800; color:#10b981; margin-top:6px;">{{ \$onTimeRate }}%</div>
                                </div>
                                <div style="background:#f8fafc; padding:12px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                        Success
                                    </div>
                                    <div style="font-size:18px; font-weight:800; color:#10b981; margin-top:6px;">{{ \$successRate }}%</div>
                                </div>
                                <div style="background:#f8fafc; padding:12px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        Dispatch
                                    </div>
                                    <div style="font-size:18px; font-weight:800; color:#3b82f6; margin-top:6px;">{{ \$activeRiders }} <span style="font-size:10px; font-weight:600; color:#64748b;">riders</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

EOF;

    array_splice($lines, $startIndex, 0, [$replacement]);
    file_put_contents($file, implode("", $lines));
    echo "Splice successful!";
} else {
    echo "Failed to find delimiters. Start: \$startIndex, End: \$endIndex";
}
