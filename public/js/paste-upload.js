/**
 * Image Paste Upload – Admin
 * Adds clipboard-paste support to any image upload zone.
 *
 * Usage:
 *   Wrap your <input type="file"> inside:
 *     <div class="paste-upload-zone" data-input="<inputId>">
 *       <input type="file" id="<inputId>" ...>
 *       <div class="paste-preview" id="<inputId>Preview"></div>
 *     </div>
 *
 *   The script will:
 *     1. Listen for paste (Ctrl+V) when the zone is focused / hovered
 *     2. Accept image drops (drag & drop)
 *     3. Show an instant preview
 *     4. Inject the pasted file into the <input type="file"> via DataTransfer
 */
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.paste-upload-zone').forEach(initZone);
    });

    function initZone(zone) {
        const inputId = zone.dataset.input;
        const fileInput = document.getElementById(inputId);
        const previewEl = document.getElementById(inputId + 'Preview');
        if (!fileInput) return;

        // Make the zone focusable so it can receive paste events
        zone.setAttribute('tabindex', '0');

        /* ── Paste (Ctrl+V) ─────────────────────── */
        zone.addEventListener('paste', function (e) {
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (const item of items) {
                if (item.type.startsWith('image/')) {
                    e.preventDefault();
                    const file = item.getAsFile();
                    setFile(fileInput, file, previewEl);
                    return;
                }
            }
        });

        /* ── Drag & Drop ────────────────────────── */
        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.classList.add('paste-drag-over');
        });
        zone.addEventListener('dragleave', function () {
            zone.classList.remove('paste-drag-over');
        });
        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('paste-drag-over');
            const files = e.dataTransfer.files;
            if (files.length && files[0].type.startsWith('image/')) {
                setFile(fileInput, files[0], previewEl);
            }
        });

        /* ── Normal file input change → preview ── */
        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files[0]) {
                showPreview(fileInput.files[0], previewEl);
            }
        });

        /* ── Click hint area to trigger file input */
        const hint = zone.querySelector('.paste-hint');
        if (hint) {
            hint.addEventListener('click', function () { fileInput.click(); });
        }
    }

    function setFile(input, file, previewEl) {
        // Use DataTransfer to programmatically set the file input value
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        // Trigger change so any other listeners fire
        input.dispatchEvent(new Event('change', { bubbles: true }));
        showPreview(file, previewEl);
    }

    function showPreview(file, previewEl) {
        if (!previewEl) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            previewEl.innerHTML =
                '<div class="paste-preview-inner">' +
                '<img src="' + e.target.result + '" alt="Preview">' +
                '<button type="button" class="paste-remove-btn" title="Remove image">✕</button>' +
                '<span class="paste-file-name">' + escHtml(file.name) + '</span>' +
                '</div>';
            const removeBtn = previewEl.querySelector('.paste-remove-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    // Clear file input and preview
                    const zone = previewEl.closest('.paste-upload-zone');
                    const inputId = zone ? zone.dataset.input : null;
                    const input = inputId ? document.getElementById(inputId) : null;
                    if (input) { input.value = ''; }
                    previewEl.innerHTML = '';
                });
            }
        };
        reader.readAsDataURL(file);
    }

    function escHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }
})();
