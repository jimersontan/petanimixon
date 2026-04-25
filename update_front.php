<?php
$fileModal = __DIR__ . '/resources/views/frontend/partials/product_modal_content.blade.php';
$contentModal = file_get_contents($fileModal);

// Regex to remove the script tag and its contents entirely
$contentModal = preg_replace('/<script>\s*\(function\(\) \{\s*const chips = document\.querySelectorAll\(\'\.pd-variant-chip\'\);.*?\}\)\(\);\s*<\/script>/s', '', $contentModal);
file_put_contents($fileModal, $contentModal);

$fileJs = __DIR__ . '/public/js/user_dashboard.js';
$contentJs = file_get_contents($fileJs);

// Append the new global function
$newFunction = <<<JS

window.initVariantSelection = function() {
    const chips = document.querySelectorAll('.pd-variant-chip');
    if (!chips || chips.length === 0) return;
    const forms = document.querySelectorAll('.pd-add-form');
    const priceCurrent = document.querySelector('.pd-price-current');
    const stockBadgeText = document.querySelector('.pd-stock-count, .pd-stock-badge');
    
    // Add hidden variant_id inputs to forms if not present
    let activeVariantId = null;
    forms.forEach(f => {
        if (!f.querySelector('.pd-variant-id-input')) {
            const inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = 'variant_id';
            inp.className = 'pd-variant-id-input';
            f.appendChild(inp);
        }
    });
    
    function updateSelectedVariant(chip) {
        if (!chip) return;
        activeVariantId = chip.getAttribute('data-id');
        const price = parseFloat(chip.getAttribute('data-price') || 0).toFixed(2);
        const stock = parseInt(chip.getAttribute('data-stock') || 0, 10);
        
        // Update styling
        chips.forEach(c => {
            c.style.borderColor = '#ddd';
            c.style.background = '#fff';
            c.style.color = '#333';
        });
        chip.style.borderColor = '#FF8C42';
        chip.style.background = '#FFF7ED';
        chip.style.color = '#FF8C42';
        
        // Update forms
        document.querySelectorAll('.pd-variant-id-input').forEach(inp => {
            inp.value = activeVariantId;
        });
        
        // Update price display
        if (priceCurrent && !isNaN(price)) {
            priceCurrent.textContent = '₱' + price;
        }
        
        // Update stock display and limits
        const qtyInputs = document.querySelectorAll('.pd-qty-input');
        qtyInputs.forEach(qi => {
            qi.max = stock;
            if (parseInt(qi.value, 10) > stock) qi.value = stock;
            if (stock === 0) qi.value = 1; // Default
        });
        
        const buyBtns = document.querySelectorAll('.pd-btn-cart, .pd-btn-buy');
        if (stock > 0) {
            buyBtns.forEach(b => { 
                b.disabled = false;
                if (b.classList.contains('pd-btn-cart')) {
                    b.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg> Add to Cart';
                }
            });
            if (stockBadgeText && stockBadgeText.classList.contains('pd-stock-count')) {
                stockBadgeText.textContent = '(' + stock + ' available)';
            }
        } else {
            buyBtns.forEach(b => { 
                b.disabled = true;
                if (b.classList.contains('pd-btn-cart')) {
                    b.innerHTML = 'Out of Stock';
                }
            });
            if (stockBadgeText && stockBadgeText.classList.contains('pd-stock-count')) {
                stockBadgeText.textContent = '(Out of Stock)';
            }
        }
    }
    
    chips.forEach(chip => {
        chip.addEventListener('click', () => updateSelectedVariant(chip));
    });
    
    // Init select
    if (chips.length > 0) {
        updateSelectedVariant(chips[0]);
    }
};
JS;

if (strpos($contentJs, 'window.initVariantSelection') === false) {
    $contentJs .= $newFunction;
}

// Inject call in fetch block
$searchFetch = "content.innerHTML = html;";
$replaceFetch = "content.innerHTML = html;\n            if (typeof window.initVariantSelection === 'function') window.initVariantSelection();";

$contentJs = str_replace($searchFetch, $replaceFetch, $contentJs);
file_put_contents($fileJs, $contentJs);

echo "Updated scripts.";
