<div id="globalOverlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15, 23, 42, 0.4); backdrop-filter:blur(4px); z-index:9998; opacity:0; transition:opacity 0.2s;"></div>

<div id="globalConfirmDeleteModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%) scale(0.95); background:#fff; width:400px; border-radius:16px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); z-index:9999; opacity:0; transition:all 0.2s;">
    <div style="padding:24px;">
        <div style="display:flex; justify-content:center; margin-bottom:16px;">
            <div style="width:56px; height:56px; border-radius:50%; background:#fef2f2; display:flex; align-items:center; justify-content:center;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/></svg>
            </div>
        </div>
        <h3 style="text-align:center; font-size:18px; font-weight:700; color:#0f172a; margin:0 0 8px 0;">Xác nhận xóa</h3>
        <p id="globalConfirmDeleteMessage" style="text-align:center; font-size:14px; color:#64748b; margin:0 0 24px 0;">Bạn có chắc chắn muốn xóa mục này?</p>
        
        <div style="display:flex; gap:12px;">
            <button type="button" id="globalConfirmDeleteCancel" style="flex:1; padding:10px 0; border-radius:10px; border:1px solid #e2e8f0; background:#fff; color:#64748b; font-weight:600; cursor:pointer;">Hủy bỏ</button>
            <button type="button" id="globalConfirmDeleteConfirm" style="flex:1; padding:10px 0; border-radius:10px; border:none; background:#ef4444; color:#fff; font-weight:600; cursor:pointer;">Tiến hành Xóa</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('globalOverlay');
        const modal = document.getElementById('globalConfirmDeleteModal');
        const msgEl = document.getElementById('globalConfirmDeleteMessage');
        const cancelBtn = document.getElementById('globalConfirmDeleteCancel');
        const confirmBtn = document.getElementById('globalConfirmDeleteConfirm');
        
        let targetForm = null;

        document.querySelectorAll('form[data-confirm-delete]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                targetForm = this;
                const customMsg = this.getAttribute('data-confirm-delete');
                if (customMsg && customMsg !== 'true') {
                    msgEl.textContent = customMsg;
                } else {
                    msgEl.textContent = 'Bạn có chắc chắn muốn xóa mục này? Hành động này không thể hoàn tác.';
                }
                
                overlay.style.display = 'block';
                modal.style.display = 'block';
                // Trigger reflow for animation
                void modal.offsetWidth; 
                overlay.style.opacity = '1';
                modal.style.opacity = '1';
                modal.style.transform = 'translate(-50%, -50%) scale(1)';
            });
        });

        function closeModal() {
            overlay.style.opacity = '0';
            modal.style.opacity = '0';
            modal.style.transform = 'translate(-50%, -50%) scale(0.95)';
            setTimeout(() => {
                overlay.style.display = 'none';
                modal.style.display = 'none';
                targetForm = null;
            }, 200);
        }

        cancelBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);

        confirmBtn.addEventListener('click', () => {
            if (targetForm) {
                // Submit the form programmatically bypassing the event listener
                targetForm.submit();
            }
        });
    });
</script>
