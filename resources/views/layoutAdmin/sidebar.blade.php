<div class="sidebar col-md-3 col-lg-2 d-md-block">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link " href="">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-book"></i>Quản lý Đề tài
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="">
                    <i class="fas fa-users"></i>Quản lý Nghiên cứu viên
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-file-alt"></i>Báo cáo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link 
                    href="">
                    <i class=" fas fa-tags"></i>Danh mục
                </a>
            </li>
            @can('manage-users')
                <li class="nav-item">
                    <a class="nav-link" href="">
                        <i class="fas fa-user-shield"></i>Quản lý Người dùng
                    </a>
                </li>
            @endcan
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
        </ul>
    </div>
</div>