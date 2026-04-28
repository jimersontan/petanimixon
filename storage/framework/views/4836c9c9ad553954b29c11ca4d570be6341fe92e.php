<!-- ===== ADMIN LAYOUT: Main wrapper for all admin pages ===== -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - Pet Markt-PH Admin</title>
    <!-- CSRF Token: Used by AJAX requests for security -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>?v=1.0.1">
    <link rel="stylesheet" href="<?php echo e(asset('css/orders.css')); ?>">
    <!-- Select2: Searchable dropdown library -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Paste Upload: Shared styles for drag-and-drop + paste image zones -->
    <style>
        /* ===== PASTE UPLOAD ZONE ===== */
        .paste-upload-zone {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 20px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafbfc;
            position: relative;
        }
        .paste-upload-zone:hover,
        .paste-upload-zone.dragover {
            border-color: var(--ud-orange-dark);
            background: #fff7ed;
        }
        .paste-upload-zone.has-file {
            border-color: #22c55e;
            background: #f0fdf4;
        }
        .paste-upload-zone .upload-icon {
            width: 40px; height: 40px;
            margin: 0 auto 8px;
            color: #9ca3af;
            transition: color 0.3s;
        }
        .paste-upload-zone:hover .upload-icon,
        .paste-upload-zone.dragover .upload-icon { color: var(--ud-orange-dark); }
        .paste-upload-zone.has-file .upload-icon { color: #22c55e; }
        .paste-upload-zone .upload-title {
            font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 4px;
        }
        .paste-upload-zone .upload-hint {
            font-size: 11px; color: #9ca3af;
        }
        .paste-upload-zone .upload-hint kbd {
            background: #f3f4f6; border: 1px solid #e5e7eb;
            border-radius: 4px; padding: 1px 5px; font-size: 10px;
            font-family: inherit; color: #6b7280;
        }
        .paste-upload-zone .upload-preview {
            margin-top: 10px;
        }
        .paste-upload-zone .upload-preview img {
            max-height: 90px; max-width: 100%;
            border-radius: 8px; border: 2px solid #e5e7eb;
            object-fit: cover;
        }
        .paste-upload-zone .upload-filename {
            font-size: 11px; color: #16a34a; font-weight: 600;
            margin-top: 6px; word-break: break-all;
        }
        .paste-upload-zone .remove-file-btn {
            position: absolute; top: 8px; right: 8px;
            background: #fee2e2; border: none; color: #dc2626;
            width: 22px; height: 22px; border-radius: 50%;
            cursor: pointer; font-size: 12px; line-height: 22px;
            display: none; transition: all 0.2s;
        }
        .paste-upload-zone.has-file .remove-file-btn { display: block; }
        .paste-upload-zone .remove-file-btn:hover { background: #fca5a5; }
    </style>
    <!-- Page-specific styles injected here -->
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="dashboard-body">

    <!-- ===== HEADER SECTION ===== -->
    <?php echo $__env->make('partials.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- ===== END HEADER SECTION ===== -->

    <!-- ===== DASHBOARD LAYOUT: Sidebar + Main Content wrapper ===== -->
    <div class="dashboard-layout">

        <!-- Mobile Sidebar Overlay: Dark background when sidebar is open on mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- ===== SIDEBAR NAVIGATION ===== -->
        <!-- Left-side navigation menu with links to all admin pages -->
        <?php echo $__env->make('partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ===== END SIDEBAR NAVIGATION ===== -->

        <!-- ===== MAIN CONTENT AREA ===== -->
        <!-- This is where each page's content is injected via yield -->
        <main class="main-content">

            <!-- Flash Messages: Success and Error alerts -->
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <!-- End: Flash Messages -->

            <!-- Page Content: Injected by child views -->
            <?php echo $__env->yieldContent('content'); ?>

            <!-- Page Modals: Injected by child views using push modals -->
            <?php echo $__env->yieldPushContent('modals'); ?>
        </main>
        <!-- ===== END MAIN CONTENT AREA ===== -->

    </div>
    <!-- ===== END DASHBOARD LAYOUT ===== -->

    <!-- ===== SCRIPTS SECTION ===== -->
    <!-- jQuery: Required by Select2 and other plugins -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2: Searchable dropdown plugin -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Dashboard JS: Sidebar toggle, hamburger menu, global UI logic -->
    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
    <!-- Orders JS: Order-specific page interactions -->
    <script src="<?php echo e(asset('js/orders.js')); ?>"></script>
    <!-- Paste Upload: Shared JS for drag-and-drop + paste image zones -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.paste-upload-zone').forEach(function(zone) {
            const fileInput = zone.querySelector('input[type="file"]');
            const preview = zone.querySelector('.upload-preview');
            const titleEl = zone.querySelector('.upload-title');
            const hintEl = zone.querySelector('.upload-hint');
            const removeBtn = zone.querySelector('.remove-file-btn');
            const origTitle = titleEl ? titleEl.textContent : '';
            const origHint = hintEl ? hintEl.innerHTML : '';

            // Click zone to trigger file input
            zone.addEventListener('click', function(e) {
                if (e.target === removeBtn || e.target.closest('.remove-file-btn')) return;
                fileInput.click();
            });

            // File input change
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) showPreview(fileInput.files[0]);
            });

            // Drag events
            zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.classList.add('dragover'); });
            zone.addEventListener('dragleave', function() { zone.classList.remove('dragover'); });
            zone.addEventListener('drop', function(e) {
                e.preventDefault(); zone.classList.remove('dragover');
                if (e.dataTransfer.files.length > 0) {
                    const dt = new DataTransfer();
                    dt.items.add(e.dataTransfer.files[0]);
                    fileInput.files = dt.files;
                    showPreview(e.dataTransfer.files[0]);
                }
            });

            // Paste (Ctrl+V) — listen on the zone's closest modal or the document
            function handlePaste(e) {
                const items = e.clipboardData ? e.clipboardData.items : [];
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf('image') !== -1) {
                        e.preventDefault();
                        const file = items[i].getAsFile();
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        fileInput.files = dt.files;
                        showPreview(file);
                        break;
                    }
                }
            }
            // Attach paste to the closest modal or document
            const modal = zone.closest('.modal-body') || zone.closest('.modal') || zone.closest('form');
            if (modal) {
                modal.addEventListener('paste', handlePaste);
            } else {
                document.addEventListener('paste', handlePaste);
            }

            // Remove file
            if (removeBtn) {
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fileInput.value = '';
                    zone.classList.remove('has-file');
                    if (preview) preview.innerHTML = '';
                    if (titleEl) titleEl.textContent = origTitle;
                    if (hintEl) hintEl.innerHTML = origHint;
                });
            }

            // Show preview
            function showPreview(file) {
                zone.classList.add('has-file');
                if (titleEl) titleEl.textContent = '✓ Image ready';
                if (hintEl) hintEl.innerHTML = '';
                if (preview && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        preview.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">' +
                            '<div class="upload-filename">' + file.name + '</div>';
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    });
    </script>
    <!-- Page-specific scripts injected here -->
    <script src="<?php echo e(asset('js/animations.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <!-- ===== END SCRIPTS SECTION ===== -->

</body>
</html>
<!-- ===== END ADMIN LAYOUT ===== -->


<?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/layouts/admin.blade.php ENDPATH**/ ?>