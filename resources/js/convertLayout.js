document.getElementById('btn-table').onclick = function() {
    document.getElementById('view-table').style.display = '';
    document.getElementById('view-grid').style.display = 'none';
    this.classList.add('btn-primary');
    this.classList.remove('btn-outline-primary');
    document.getElementById('btn-grid').classList.remove('btn-secondary');
    document.getElementById('btn-grid').classList.add('btn-outline-secondary');
};
document.getElementById('btn-grid').onclick = function() {
    document.getElementById('view-table').style.display = 'none';
    document.getElementById('view-grid').style.display = '';
    this.classList.add('btn-secondary');
    this.classList.remove('btn-outline-secondary');
    document.getElementById('btn-table').classList.remove('btn-primary');
    document.getElementById('btn-table').classList.add('btn-outline-primary');
};
