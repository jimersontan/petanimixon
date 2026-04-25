<?php
$file = 'resources/views/analytics_admin.blade.php';
$content = file_get_contents($file);

// Replace title with flexbox + select
$searchHTML = '<h2 class="card-title">Revenue Overview</h2>';
$replaceHTML = <<<EOF
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                        <h2 class="card-title" style="margin-bottom:0;">Revenue Overview</h2>
                        <select id="revenueChartFilter" class="filter-select" style="padding:4px 8px; font-size:12px; border-radius:4px; border:1px solid #d1d5db; background:#fff; cursor:pointer;" onchange="updateRevenueChart(this.value)">
                            <option value="daily">Weekly</option>
                            <option value="3days">3 Days Ago</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
EOF;

// Replace Javascript block
$searchJS_start = '// Revenue Trend Chart (Reuse the Dashboard API data)';
// Let's replace the whole fetch to the end of the script tag
// We'll just splice it exactly

$content = str_replace($searchHTML, $replaceHTML, $content);

$jsReplacement = <<<EOF
            // Revenue Trend Chart Logic
            let revenueChartInstance = null;

            window.updateRevenueChart = function(type = 'daily') {
                fetch('/admin/api/dashboard-chart?type=' + type)
                    .then(res => res.json())
                    .then(data => {
                        const ctx = document.getElementById('analyticsRevenueChart');
                        if (!ctx) return;
                        
                        // Destroy existing chart if it exists
                        if (revenueChartInstance) {
                            revenueChartInstance.destroy();
                        }
                        
                        const chartCtx = ctx.getContext('2d');
                        
                        const gradient = chartCtx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(249, 115, 22, 0.2)');
                        gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

                        revenueChartInstance = new Chart(chartCtx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Revenue (k ₱)',
                                    data: data.data,
                                    borderColor: '#f97316',
                                    backgroundColor: gradient,
                                    borderWidth: 3,
                                    pointBackgroundColor: '#fff',
                                    pointBorderColor: '#f97316',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    fill: true,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#1f2937',
                                        titleFont: { family: 'Inter', size: 13 },
                                        bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                                        padding: 12,
                                        displayColors: false,
                                        callbacks: {
                                            label: function(context) {
                                                return '₱' + (context.raw * 1000).toLocaleString();
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: { color: '#f3f4f6', drawBorder: false },
                                        ticks: { color: '#6b7280', font: { family: 'Inter' } }
                                    },
                                    x: {
                                        grid: { display: false, drawBorder: false },
                                        ticks: { color: '#6b7280', font: { family: 'Inter' } }
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index',
                                },
                            }
                        });
                    })
                    .catch(err => {
                        if (document.getElementById('analyticsRevenueChart') && !revenueChartInstance) {
                            document.getElementById('analyticsRevenueChart').parentElement.innerHTML = '<div class="empty-chart">No revenue data available yet.</div>';
                        }
                    });
            };

            // Init the default graph upon loading
            updateRevenueChart('daily');
        });
    </script>
EOF;

// Use preg_replace to wipe out the old fetch logic and inject the function approach
$pattern = '/\/\/\s*Revenue Trend Chart.*?\s*\}\);\s*<\/script>/s';
$content = preg_replace($pattern, $jsReplacement, $content);

file_put_contents($file, $content);
echo "Chart updated with dropbox successfully!";
