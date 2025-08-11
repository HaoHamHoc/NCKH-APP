document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin page JS loaded successfully');
    
    // Lưu layout vào localStorage khi chuyển đổi
    const btnTable = document.getElementById('btn-table');
    const btnGrid = document.getElementById('btn-grid');
    
    if (btnTable) {
        btnTable.onclick = function() {
            localStorage.setItem('layout', 'table');
            window.location.search = '?layout=table';
        };
    }
    
    if (btnGrid) {
        btnGrid.onclick = function() {
            localStorage.setItem('layout', 'grid');
            window.location.search = '?layout=grid';
        };
    }
    
    // Nếu không có parameter, tự động lấy từ localStorage
    const params = new URLSearchParams(window.location.search);
    if (!params.has('layout')) {
        const layout = localStorage.getItem('layout');
        if (layout === 'grid' || layout === 'table') {
            window.location.search = '?layout=' + layout;
        }
    }

    // Bảng
    const editButtons = document.querySelectorAll('.btn-edit-row');
    console.log('Found edit buttons:', editButtons.length);
    
    editButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            console.log('Edit button clicked');
            e.preventDefault();
            const tr = btn.closest('tr');
            if (tr) {
                tr.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
                tr.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
                tr.querySelector('.action-buttons').classList.add('d-none');
                tr.querySelector('.edit-actions').classList.remove('d-none');
            }
        });
    });
    
    const cancelButtons = document.querySelectorAll('.btn-cancel-edit');
    console.log('Found cancel buttons:', cancelButtons.length);
    
    cancelButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            console.log('Cancel button clicked');
            e.preventDefault();
            const tr = btn.closest('tr') || btn.closest('.card-edit-form');
            if (tr) {
                tr.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
                tr.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                tr.querySelector('.action-buttons').classList.remove('d-none');
                tr.querySelector('.edit-actions').classList.add('d-none');
            }
        });
    });
    
    const editForms = document.querySelectorAll('form.edit-actions');
    console.log('Found edit forms:', editForms.length);
    
    editForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            console.log('Edit form submitted');
            const tr = form.closest('tr');
            if (tr) {
                e.preventDefault();
                // Lấy tất cả input/select/textarea trong hàng (tr) trừ các input hidden và trừ các phần tử nằm trong form
                const editInputs = Array.from(tr.querySelectorAll('input[name], select[name], textarea[name]'))
                    .filter(function(el) {
                        const isHiddenType = el.tagName === 'INPUT' && el.type === 'hidden';
                        const insideForm = !!el.closest('form');
                        return !isHiddenType && !insideForm;
                    });
                console.log('Found edit inputs:', editInputs.length);
                
                // Gán giá trị vào hidden inputs trong form; nếu chưa có thì tạo mới
                editInputs.forEach(function(input) {
                    const fieldName = input.name;
                    let hiddenInput = form.querySelector(`input[name="${fieldName}"]`);
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = fieldName;
                        form.appendChild(hiddenInput);
                    }
                    hiddenInput.value = input.value;
                    console.log('Copied field:', fieldName, '=', input.value);
                });
                // Submit chương trình sau khi gán xong
                form.submit();
                return;
            }
            // Card: không cần xử lý vì inputs nằm trong form
        });
    });
    
    // Card
    const editCardButtons = document.querySelectorAll('.btn-edit-card');
    console.log('Found edit card buttons:', editCardButtons.length);
    
    editCardButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            console.log('Edit card button clicked');
            e.preventDefault();
            const cardForm = btn.closest('.card-edit-form');
            if (cardForm) {
                cardForm.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
                cardForm.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
                cardForm.querySelector('.action-buttons').classList.add('d-none');
                cardForm.querySelector('.edit-actions').classList.remove('d-none');
            }
        });
    });
});
