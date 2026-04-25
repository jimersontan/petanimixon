<?php
$file = 'resources/views/dashboard_admin.blade.php';
$content = file_get_contents($file);

$content = str_replace(
    '<span class="v2-stat-number">{{ $totalOrders * 3 + 124 }}</span>',
    '<span class="v2-stat-number">{{ $totalProducts }}</span>',
    $content
);

$salesColsOld = <<<EOF
                        <div class="v2-sales-cols">
                            <div class="v2-sales-col">
                                <div class="v2-sc-title">Lead</div>
                                <div class="v2-sc-amount">₱20,010</div>
                                <div class="v2-sc-deals">{{ \$totalOrders * 2 }} Deals</div>
                                <svg class="v2-svg-wave v2-wave-1" viewBox="0 0 200 60" preserveAspectRatio="none">
                                  <path d="M0,30 C50,60 150,0 200,30 L200,60 L0,60 Z" />
                                </svg>
                            </div>
                            <div class="v2-sales-col" style="background: rgba(1, 77, 135, 0.02)">
                                <div class="v2-sc-title">Proposal</div>
                                <div class="v2-sc-amount">₱17,210</div>
                                <div class="v2-sc-deals">{{ \$totalOrders + 12 }} Deals</div>
                                <svg class="v2-svg-wave v2-wave-2" viewBox="0 0 200 60" preserveAspectRatio="none">
                                  <path d="M0,40 C60,40 120,5 200,30 L200,60 L0,60 Z" />
                                </svg>
                            </div>
                            <div class="v2-sales-col">
                                <div class="v2-sc-title">Sales</div>
                                <div class="v2-sc-amount">₱9,210</div>
                                <div class="v2-sc-deals">{{ \$totalOrders }} Deals</div>
                                <svg class="v2-svg-wave v2-wave-3" fill-opacity="0.6" viewBox="0 0 200 60" preserveAspectRatio="none">
                                  <path d="M0,20 C80,20 100,50 200,45 L200,60 L0,60 Z" />
                                </svg>
                            </div>
                            <div class="v2-sales-col">
                                <div class="v2-sc-title">Contract sent</div>
                                <div class="v2-sc-amount">₱8,210</div>
                                <div class="v2-sc-deals">{{ \$totalOrders - 1 }} Deals</div>
                                <svg class="v2-svg-wave v2-wave-4" fill-opacity="0.8" viewBox="0 0 200 60" preserveAspectRatio="none">
                                  <path d="M0,50 C100,60 120,10 200,40 L200,60 L0,60 Z" />
                                </svg>
                            </div>
                        </div>
EOF;

// Since whitespace may differ, let's use preg_replace for each block instead

$content = preg_replace('/<div class="v2-sc-title">Lead<\/div>.*?<div class="v2-sc-amount">.*?<\/div>.*?<div class="v2-sc-deals">.*?<\/div>/s',
    '<div class="v2-sc-title">Pending Orders</div>
                                <div class="v2-sc-amount">₱{{ number_format($pendingOrdersRevenue, 0) }}</div>
                                <div class="v2-sc-deals">{{ $pendingOrdersCount }} Orders</div>', $content);

$content = preg_replace('/<div class="v2-sc-title">Proposal<\/div>.*?<div class="v2-sc-amount">.*?<\/div>.*?<div class="v2-sc-deals">.*?<\/div>/s',
    '<div class="v2-sc-title">Processing</div>
                                <div class="v2-sc-amount">₱{{ number_format($processingRevenue, 0) }}</div>
                                <div class="v2-sc-deals">{{ $processingCount }} Orders</div>', $content);

$content = preg_replace('/<div class="v2-sc-title">Sales<\/div>.*?<div class="v2-sc-amount">.*?<\/div>.*?<div class="v2-sc-deals">.*?<\/div>/s',
    '<div class="v2-sc-title">In Transit</div>
                                <div class="v2-sc-amount">₱{{ number_format($transitRevenue, 0) }}</div>
                                <div class="v2-sc-deals">{{ $transitCount }} Orders</div>', $content);

$content = preg_replace('/<div class="v2-sc-title">Contract sent<\/div>.*?<div class="v2-sc-amount">.*?<\/div>.*?<div class="v2-sc-deals">.*?<\/div>/s',
    '<div class="v2-sc-title">Completed (Paid)</div>
                                <div class="v2-sc-amount">₱{{ number_format($completedRevenue, 0) }}</div>
                                <div class="v2-sc-deals">{{ $completedCount }} Orders</div>', $content);

// Fix Top selling product table count
$content = str_replace('15 Product', '{{ count($topProducts) }} Product(s)', $content);

// Fix price variables in table
$content = preg_replace('/<td class="v2-td-amount">.*?₱121\), 0\) }}<\/td>/s',
    '<td class="v2-td-amount">₱{{ number_format((float)($tp->total_sold * $tp->price), 0) }}</td>', $content);

$content = preg_replace('/<td style="font-weight:600; color:#6b7280;">.*?₱121\.00<\/td>/s',
    '<td style="font-weight:600; color:#6b7280;">₱{{ number_format($tp->price, 2) }}</td>', $content);

file_put_contents($file, $content);
echo "Replaced strings successfully.\n";
