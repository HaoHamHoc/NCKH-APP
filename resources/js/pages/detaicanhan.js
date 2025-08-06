export function DeTaiCaNhan() {
    console.log('File detaicanhan.js đã được load và chạy!');
    // Hiện form khi bấm "Thêm kinh phí"
    document.querySelectorAll('.toggle-kinhphi-form').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const formContainer = document.getElementById(`form-${id}`);
            if (formContainer) {
                formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
            }
        });
    });
    // Ẩn form khi bấm "Huỷ"
    document.querySelectorAll('.btn-cancel').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const formContainer = document.getElementById(`form-${id}`);
            if (formContainer) {
                formContainer.style.display = 'none';
            }
        });
    });

    // Tự động tính thành tiền
    document.querySelectorAll('.form-kinhphi').forEach(form => {
        const soluongInput = form.querySelector('input[name="soluong"]');
        const dongiaInput = form.querySelector('input[name="dongia"]');
        const thanhtienInput = form.querySelector('input[name="thanhtien"]');

        function updateThanhTien() {
            const soluong = parseFloat(soluongInput.value) || 0;
            const dongia = parseFloat(dongiaInput.value) || 0;
            thanhtienInput.value = soluong * dongia;
        }
        soluongInput.addEventListener('input', updateThanhTien);
        dongiaInput.addEventListener('input', updateThanhTien);

        // Submit form bằng Fetch API
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const id = this.getAttribute('data-id');
            const formData = new FormData(this);
            const csrfToken = this.querySelector('input[name="_token"]')?.value;
            const msgBox = document.getElementById(`msg-${id}`);

            try {
                const res = await fetch(`/tiendo/${id}/themkinhphi`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await res.json();

                if (!res.ok) {
                    let errorHtml = '';
                    if (data.errors) {
                        for (const key in data.errors) {
                            errorHtml += `<div>${data.errors[key]}</div>`;
                        }
                    } else {
                        errorHtml = `<div>${data.message || 'Lỗi không xác định.'}</div>`;
                    }
                    msgBox.innerHTML = `<div class="alert alert-danger mt-2">${errorHtml}</div>`;
                    return;
                }

                // Thành công
                msgBox.innerHTML = `<div class="alert alert-success mt-2">${data.message}</div>`;
                alert('Thêm kinh phí thành công!');
                this.reset();
                document.getElementById(`form-${id}`).style.display = 'none';
                location.reload();

                // TODO: reload bảng nếu cần

            } catch (error) {
                msgBox.innerHTML = `<div class="alert alert-danger mt-2">Không thể gửi dữ liệu. Vui lòng thử lại.</div>`;
                alert('Thêm kinh phí thất bại!');
            }
        });
    });
}

// Hàm xoá kinh phí
window.deleteKinhPhi = async function (id_kinhphi, id_detai, id_tiendo) {
    if (!confirm('Bạn có chắc muốn xoá kinh phí này?')) return;
    try {
        const res = await fetch(`/detai/${id_detai}/tiendo/${id_tiendo}/kinhphi/${id_kinhphi}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            }
        });
        const data = await res.json();
        if (res.ok && data.success) {
            alert('Xoá kinh phí thành công!');
            location.reload();
        } else {
            alert(data.message || 'Xoá thất bại!');
        }
    } catch (error) {
        alert('Lỗi khi xoá kinh phí!');
    }
}
