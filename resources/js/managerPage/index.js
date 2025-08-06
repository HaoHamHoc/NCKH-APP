document.addEventListener('DOMContentLoaded', function() {
    // Lưu layout vào localStorage khi chuyển đổi
    document.getElementById('btn-table').onclick = function() {
        localStorage.setItem('layout', 'table');
        window.location.search = '?layout=table';
    };
    document.getElementById('btn-grid').onclick = function() {
        localStorage.setItem('layout', 'grid');
        window.location.search = '?layout=grid';
    };
    // Nếu không có parameter, tự động lấy từ localStorage
    const params = new URLSearchParams(window.location.search);
    if (!params.has('layout')) {
        const layout = localStorage.getItem('layout');
        if (layout === 'grid' || layout === 'table') {
            window.location.search = '?layout=' + layout;
        }
    }

    // Bảng
    document.querySelectorAll('.btn-edit-row').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const tr = btn.closest('tr');
            tr.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
            tr.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
            tr.querySelector('.action-buttons').classList.add('d-none');
            tr.querySelector('.edit-actions').classList.remove('d-none');
        });
    });
    document.querySelectorAll('.btn-cancel-edit').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const tr = btn.closest('tr') || btn.closest('.card-edit-form');
            tr.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
            tr.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
            tr.querySelector('.action-buttons').classList.remove('d-none');
            tr.querySelector('.edit-actions').classList.add('d-none');
        });
    });
    document.querySelectorAll('.edit-actions').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const tr = form.closest('tr');
            if (tr) {
                form.querySelector('input[name="hovaten"]').value = tr.querySelector('input[name="hovaten"]').value;
                form.querySelector('input[name="email"]').value = tr.querySelector('input[name="email"]').value;
                form.querySelector('input[name="dvcongtac"]').value = tr.querySelector('input[name="dvcongtac"]').value;
                form.querySelector('input[name="permission"]').value = tr.querySelector('select[name="permission"]').value;
            }
            setTimeout(function() {
                if (tr) {
                    tr.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
                    tr.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                    tr.querySelector('.action-buttons').classList.remove('d-none');
                    tr.querySelector('.edit-actions').classList.add('d-none');
                } else {
                    // Card
                    const cardForm = form.closest('.card-edit-form');
                    cardForm.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
                    cardForm.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                    cardForm.querySelector('.action-buttons').classList.remove('d-none');
                    cardForm.querySelector('.edit-actions').classList.add('d-none');
                }
            }, 300);
        });
    });
    // Card
    document.querySelectorAll('.btn-edit-card').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const cardForm = btn.closest('.card-edit-form');
            cardForm.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
            cardForm.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
            cardForm.querySelector('.action-buttons').classList.add('d-none');
            cardForm.querySelector('.edit-actions').classList.remove('d-none');
        });
    });
});
