import './bootstrap';
import { DangKyDeTai } from './pages/dangkydetai.js';
import { DeTaiCaNhan } from './pages/detaicanhan.js';
import { TrangChu } from './pages/trangchu.js';
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('dangKyDeTaiForm')) {
        DangKyDeTai();
    }
    if (document.getElementById('trangdetaicanhan')) {
        DeTaiCaNhan();
    }
    if (document.getElementById('trang-chu')) {
        TrangChu();
    }
});
