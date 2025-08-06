export function TrangChu() {
    const searchBtn = document.getElementById('search-btn');
    const keywordInput = document.getElementById('keyword');
    const researchTypeSelect = document.getElementById('research_type');
    const resultsContainer = document.getElementById('results-container');
    const resultsBody = document.getElementById('results-body');
    const paginationLinks = document.getElementById('pagination-links');

    // Xử lý sự kiện click nút tìm kiếm
    // searchBtn.addEventListener('click', searchResearch);

    // Xử lý sự kiện nhấn Enter trong ô tìm kiếm
    keywordInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            searchResearch();
        }
    });
    researchTypeSelect.addEventListener('change', function () {
        const idloai = this.value;
        const bangdetai = document.getElementById('bangdetai');
        bangdetai.innerHTML = '<div class="text-center"><i class="anticon anticon-loading"></i> Đang tải...</div>';
        fetch(`/detai/${idloai}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
            .then(async response => {
                if (!response.ok) {
                    let message = 'Có lỗi xảy ra khi tải dữ liệu';
                    try {
                        const data = await response.json();
                        if (data.message) message = data.message;
                    } catch { }
                    throw new Error(message);
                }
                return response.text();
            })
            .then(html => {
                bangdetai.innerHTML = html;
            })
            .catch(error => {
                bangdetai.innerHTML = `<div class="text-center text-secondary">${error.message}</div>`;
            });
    });

    // Hàm thực hiện tìm kiếm bằng AJAX
    function searchResearch() {
        const researchType = researchTypeSelect.value;
        const keyword = keywordInput.value;

        // Tạo URL với các tham số tìm kiếm
        const url = new URL('{{ route("research.search") }}');
        const params = new URLSearchParams();

        if (researchType) params.append('research_type', researchType);
        if (keyword) params.append('keyword', keyword);

        url.search = params.toString();

        // Hiển thị loading
        resultsBody.innerHTML = '<tr><td colspan="7" class="text-center"><i class="anticon anticon-loading"></i> Đang tải...</td></tr>';
        resultsContainer.style.display = 'block';

        // Gửi request AJAX
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.html) {
                    resultsBody.innerHTML = data.html;
                    paginationLinks.innerHTML = data.pagination || '';
                } else {
                    resultsBody.innerHTML = '<tr><td colspan="7" class="text-center">Không tìm thấy kết quả nào</td></tr>';
                    paginationLinks.innerHTML = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultsBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Có lỗi xảy ra khi tải dữ liệu</td></tr>';
                paginationLinks.innerHTML = '';
            });
    }

    // Xử lý phân trang AJAX
    document.addEventListener('click', function (e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;

            // Hiển thị loading
            resultsBody.innerHTML = '<tr><td colspan="7" class="text-center"><i class="anticon anticon-loading"></i> Đang tải...</td></tr>';

            // Gửi request AJAX cho phân trang
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.html) {
                        resultsBody.innerHTML = data.html;
                        paginationLinks.innerHTML = data.pagination || '';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultsBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Có lỗi xảy ra khi tải dữ liệu</td></tr>';
                    paginationLinks.innerHTML = '';
                });
        }
    });
}