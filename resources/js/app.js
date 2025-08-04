import './bootstrap';
import { initTopicRegistration } from './pages/dangkydetai.js';
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('dangKyDeTaiForm')) {
        initTopicRegistration();
    }
});
