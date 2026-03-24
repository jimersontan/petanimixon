import os, glob, re

target_replacement = r'''<a href="{{ route('products.readonly') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}" data-page="products">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3zm2 2h2v6H5v-6zm4 0h2v6H9v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6z"/></svg></span>
                    <span class="nav-label">Products</span>
                </a>
                <a href="{{ route('inventory.admin') }}" class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}" data-page="inventory">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg></span>
                    <span class="nav-label">Inventory</span>
                </a>'''

files = glob.glob('resources/views/*_admin.blade.php') + glob.glob('resources/views/layouts/admin.blade.php') + glob.glob('resources/views/orders.blade.php') + ['resources/views/products_readonly.blade.php']

# This regex matches the entire <a> tag for Products
pattern = re.compile(r'<a href="\{\{\s*route\(\'products\.admin\'\)\s*\}\}".*?data-page="products">.*?<\/a>', re.DOTALL)

for f in files:
    if not os.path.exists(f): continue
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    
    new_content, count = pattern.subn(target_replacement, content)
    
    if count > 0:
        with open(f, 'w', encoding='utf-8') as file:
            file.write(new_content)
        print(f'Updated {f}')
