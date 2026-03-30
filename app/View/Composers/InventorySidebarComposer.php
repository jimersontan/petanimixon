<?php

namespace App\View\Composers;

use App\Models\Product;
use Illuminate\View\View;

class InventorySidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        // Only load on admin pages where the sidebar is shown
        if (auth()->check() && auth()->user()->isAdmin()) {
            // Get recent 10 products for sidebar (exclude drafts)
            $products = Product::with('variants')
                ->where('product_status', '!=', 'draft')
                ->orderBy('updated_at', 'desc')
                ->limit(10)
                ->get();

            // Calculate low stock count using a simple loop (avoids SQL aggregate issues)
            $lowStockCount = 0;
            $allProducts = Product::with('variants')
                ->where('product_status', '!=', 'draft')
                ->get();
            
            foreach ($allProducts as $product) {
                $totalStock = $product->variants->sum('stock') ?? 0;
                if ($totalStock <= 5) {
                    $lowStockCount++;
                }
            }

            // Calculate inventory statistics
            $stats = [
                'total_products' => Product::count(),
                'active_products' => Product::where('product_status', 'active')->count(),
                'low_stock' => $lowStockCount,
                'out_of_stock' => Product::where('product_status', 'out_of_stock')->count(),
            ];

            // Share data with the view
            $view->with([
                'sidebarProducts' => $products,
                'stats' => $stats,
            ]);
        }
    }
}
