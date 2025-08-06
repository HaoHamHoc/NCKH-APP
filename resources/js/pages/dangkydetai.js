export function DangKyDeTai() {
    // Lấy dữ liệu người dùng
    const userDataElement = document.getElementById('user-data');
    const userData = userDataElement ? JSON.parse(userDataElement.textContent) : null;

    if (userData) {
        document.getElementById('hovaten').value = userData.name;
        document.getElementById('Email').value = userData.email;
        // document.getElementById('id_nguoidung').value = userData.id;
    }

    // Elements
    const loaiDeTaiSelect = document.getElementById('loaidetai');
    const btnThemThanhVien = document.getElementById('btnThemThanhVien');
    const thanhVienContainer = document.getElementById('thanhVienContainer');
    const btnThemTienDo = document.getElementById('btnThemTienDo');
    const tienDoContainer = document.getElementById('tienDoContainer');
    const form = document.getElementById('dangKyDeTaiForm');

    // Tạo thông báo động
    const alertBox = document.createElement('div');
    alertBox.className = 'alert';
    alertBox.style.display = 'none';
    alertBox.style.margin = '20px 0';
    // Chèn alertBox vào trước nút đăng ký
    const submitBtn = form?.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.parentNode.insertBefore(alertBox, submitBtn);
    } else {
        form?.parentNode.insertBefore(alertBox, form);
    }

    // Hiển thị thông báo
    function showAlert(type, message) {
        alertBox.textContent = message;
        alertBox.className = `alert alert-${type}`;
        alertBox.style.display = 'block';

        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 20000);
    }

    // Variables
    let memberCount = 0;
    let progressCount = 0;

    // Update max values when topic type changes
    loaiDeTaiSelect?.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('maxSogio').textContent = selectedOption.dataset.sogio;
        document.getElementById('maxThanhVien').textContent = selectedOption.dataset.sotv;

        document.getElementById('Sogiotacgia').max = selectedOption.dataset.sogio;
    });

    // Add member
    btnThemThanhVien?.addEventListener('click', function () {
        const template = document.getElementById('thanhVienTemplate').content.cloneNode(true);
        const inputs = template.querySelectorAll('[name]');

        inputs.forEach(input => {
            input.name = input.name.replace('[]', `[${memberCount}]`);
        });

        thanhVienContainer.appendChild(template);
        memberCount++;
        checkMaxMembers();
    });

    // Remove member
    thanhVienContainer?.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-xoa-thanhvien')) {
            e.target.closest('.thanh-vien-item').remove();
            checkMaxMembers();
        }
    });

    // Add progress
    btnThemTienDo?.addEventListener('click', function () {
        const template = document.getElementById('tienDoTemplate').content.cloneNode(true);
        const inputs = template.querySelectorAll('[name]');

        inputs.forEach(input => {
            input.name = input.name.replace('[]', `[${progressCount}]`);
        });

        tienDoContainer.appendChild(template);
        progressCount++;
    });
    tienDoContainer?.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-xoa-tiendo')) {
            e.target.closest('.tien-do-item').remove();
        }
    });
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-them-kinhphi')) {
            const container = e.target.closest('.kinh-phi-section').querySelector('.kinh-phi-container');
            const template = document.getElementById('kinhPhiTemplate').content.cloneNode(true);
            const parentIndex = Array.from(document.querySelectorAll('.tien-do-item')).indexOf(e.target.closest('.tien-do-item'));
            const costIndex = container.querySelectorAll('.kinh-phi-item').length;
            const inputs = template.querySelectorAll('[name]');
            inputs.forEach(input => {
                input.name = input.name.replace('[]', `[${parentIndex}]`).replace('[]', `[${costIndex}]`);
            });
            container.appendChild(template);
        }
    });

    // Remove cost
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-xoa-kinhphi')) {
            e.target.closest('.kinh-phi-item').remove();
        }
    });
    // Calculate cost total
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('soluong-kinhphi') || e.target.classList.contains('dongia-kinhphi')) {
            const row = e.target.closest('.kinh-phi-item');
            const quantity = parseFloat(row.querySelector('.soluong-kinhphi').value) || 0;
            const price = parseFloat(row.querySelector('.dongia-kinhphi').value) || 0;
            row.querySelector('.thanhtien-kinhphi').value = quantity * price;
        }
    });

    // Form submission with AJAX
    form?.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Validate form
        if (!validateForm()) {
            return;
        }

        // Hiển thị trạng thái loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';

        try {
            const formData = new FormData(form);
            const response = await fetch('/detai/dangkydetai', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Có lỗi xảy ra khi gửi dữ liệu');
            }
            if (data.success === false) {
                showAlert('danger', data.message);
            }
            // Hiển thị thông báo thành công
            showAlert('success', data.message || 'Đăng ký đề tài thành công!');

            // Reset form
            form.reset();

            // Xóa các thành viên và tiến độ đã thêm
            thanhVienContainer.innerHTML = '';
            tienDoContainer.innerHTML = '';

            // Reset counters
            memberCount = 0;
            progressCount = 0;

            // Thêm lại thành viên và tiến độ mặc định
            btnThemThanhVien.click();
            btnThemTienDo.click();

        } catch (error) {
            console.error('Error:', error);
            showAlert('danger', error.message || 'Lỗi khi đăng ký đề tài');
        } finally {
            // Khôi phục trạng thái nút submit
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    // Validate form
    function validateForm() {
        let isValid = true;

        // Reset validation
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        // Validate các trường bắt buộc
        form.querySelectorAll('[required]').forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            }
        });

        // Validate loại đề tài
        if (!loaiDeTaiSelect?.value) {
            loaiDeTaiSelect.classList.add('is-invalid');
            isValid = false;
        }

        // Validate số giờ và thành viên
        if (!checkMaxMembers() || !validateTotalHours()) {
            isValid = false;
        }

        if (!isValid) {
            showAlert('danger', 'Vui lòng kiểm tra lại thông tin đăng ký');
        }

        return isValid;
    }

    // Check max members
    function checkMaxMembers() {
        const selectedOption = loaiDeTaiSelect?.options[loaiDeTaiSelect.selectedIndex];
        if (!selectedOption) return true;

        const maxMembers = parseInt(selectedOption.dataset.sotv) || 0;
        const currentMembers = document.querySelectorAll('.thanh-vien-item').length;

        if (maxMembers > 0 && currentMembers >= maxMembers) {
            btnThemThanhVien.disabled = true;
            return true;
        } else {
            btnThemThanhVien.disabled = false;
            return true;
        }
    }

    // Validate total hours
    function validateTotalHours() {
        const selectedOption = loaiDeTaiSelect?.options[loaiDeTaiSelect.selectedIndex];
        if (!selectedOption) return true;

        const maxHours = parseInt(selectedOption.dataset.sogio) || 0;
        const authorHours = parseInt(document.getElementById('Sogiotacgia').value) || 0;

        if (authorHours > maxHours) {
            document.getElementById('Sogiotacgia').classList.add('is-invalid');
            return false;
        }

        let totalMemberHours = 0;
        document.querySelectorAll('.sogio-thanhvien').forEach(input => {
            totalMemberHours += parseInt(input.value) || 0;
        });

        if (totalMemberHours > maxHours) {
            showAlert('danger', 'Tổng số giờ của thành viên vượt quá giới hạn cho phép');
            return false;
        }

        return true;
    }

    // Initialize with one member and one progress
    if (btnThemThanhVien && btnThemTienDo) {
        btnThemThanhVien.click();
        btnThemTienDo.click();
    }
}