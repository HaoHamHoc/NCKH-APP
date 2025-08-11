<div class="sidebar col-md-3 col-lg-2 d-md-block">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/trangquanly') ? 'active' : '' }}" href="/admin/trangquanly">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </li>
            
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Quản lý hệ thống</span>
            </h6>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('quanlyhethong/taikhoan*') ? 'active' : '' }}" href="/quanlyhethong/taikhoan">
                    <i class="fas fa-users"></i>Quản lý Tài khoản
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('quanlyhethong/loaidetai*') ? 'active' : '' }}" href="/quanlyhethong/loaidetai">
                    <i class="fas fa-tags"></i>Quản lý Loại đề tài
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('quanlyhethong/sogiotheonam*') ? 'active' : '' }}" href="/quanlyhethong/sogiotheonam">
                    <i class="fas fa-clock"></i>Quản lý Số giờ theo năm
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('quanlyhethong/linhvucnghiencuu*') ? 'active' : '' }}" href="/quanlyhethong/linhvucnghiencuu">
                    <i class="fas fa-flask"></i>Quản lý Lĩnh vực nghiên cứu
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('quanlyhethong/sanphamnghiencuu*') ? 'active' : '' }}" href="/quanlyhethong/sanphamnghiencuu">
                    <i class="fas fa-microscope"></i>Sản phẩm nghiên cứu
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Quản lý đề tài</span>
        </h6>
        
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('quanlydetai*') ? 'active' : '' }}" href="/quanlydetai">
                    <i class="fas fa-book"></i>Danh sách đề tài
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('detainckh*') ? 'active' : '' }}" href="/detainckh">
                    <i class="fas fa-search"></i>Tìm kiếm đề tài
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Công cụ</span>
        </h6>
        
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-alt"></i>Lịch trình
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-file-export"></i>Xuất dữ liệu
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i>Báo cáo thống kê
                </a>
            </li>
        </ul>
    </div>
</div>