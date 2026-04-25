<?php
$fileModal = __DIR__ . '/resources/views/frontend/partials/product_modal_content.blade.php';
$contentModal = file_get_contents($fileModal);

// Search for the broken HTML part
$search = <<<EOD
                <div class="pd-qty-row">
                    <span class="pd-qty-label">Quantity</span>
                    <form action="{{ route('cart.add') }}" method="POST" class="pd-add-form pd-add-cart-form" style="margin: 0;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ \$product->id }}">
                        <div class="pd-qty-wrap">
                            <button type="button" class="pd-qty-btn" onclick="let v=this.nextElementSibling;v.value=Math.max(1,+v.value-1)">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ \$product->stock }}" class="pd-qty-input" readonly>
                            <button type="button" class="pd-qty-btn" onclick="let v=this.previousElementSibling;let mx=+(v.getAttribute('max')||999);v.value=Math.min(mx,+v.value+1)">+</button>
                        </div>
                </div>

                {{-- CTA Buttons Row --}}
                <div class="pd-cta-row">
                        <button type="submit" class="pd-btn pd-btn-cart" {{ \$product->stock < 1 ? 'disabled' : '' }}>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                            {{ \$product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                        </button>
                    </form>
EOD;

$replace = <<<EOD
                <div class="pd-qty-row">
                    <span class="pd-qty-label">Quantity</span>
                    <div class="pd-qty-wrap">
                        <button type="button" class="pd-qty-btn" onclick="let v=this.nextElementSibling;v.value=Math.max(1,+v.value-1);v.dispatchEvent(new Event('change'))">−</button>
                        <input type="number" value="1" min="1" max="{{ \$product->stock }}" class="pd-qty-input pd-main-qty" readonly>
                        <button type="button" class="pd-qty-btn" onclick="let v=this.previousElementSibling;let mx=+(v.getAttribute('max')||999);v.value=Math.min(mx,+v.value+1);v.dispatchEvent(new Event('change'))">+</button>
                    </div>
                </div>

                {{-- CTA Buttons Row --}}
                <div class="pd-cta-row">
                    <form action="{{ route('cart.add') }}" method="POST" class="pd-add-form pd-add-cart-form" style="margin: 0; flex: 1;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ \$product->id }}">
                        <input type="hidden" name="quantity" value="1" class="pd-cart-add-qty">
                        <button type="submit" class="pd-btn pd-btn-cart" {{ \$product->stock < 1 ? 'disabled' : '' }}>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                            {{ \$product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                        </button>
                    </form>
EOD;

$contentModal = str_replace($search, $replace, $contentModal);


// Also replace the old script logic
$searchScript = <<<EOD
                        <script>
                            (function() {
                                var qtyInput = document.querySelector('.pd-add-cart-form input[name="quantity"]');
                                var buyNowQty = document.querySelector('.pd-buy-now-form .pd-buy-now-qty');
                                if (!qtyInput || !buyNowQty) return;
                                var syncQty = function() { buyNowQty.value = qtyInput.value || 1; };
                                qtyInput.addEventListener('change', syncQty);
                                qtyInput.addEventListener('input', syncQty);
                            })();
                        </script>
EOD;

$replaceScript = <<<EOD
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
EOD;

$contentModal = str_replace($searchScript, $replaceScript, $contentModal);
file_put_contents($fileModal, $contentModal);
echo "Modal DOM Fixed.";
