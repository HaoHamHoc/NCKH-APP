@extends('layout.app')

@section('title', 'Đăng ký đề tài NCKH')
@vite(['resources/css/trangdangkydetai.css', 'resources/js/pages/dangkydetai.js'])
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Đăng ký đề tài NCKH</h2>
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin đề tài</h5>
                </div>
                <div class="card-body">
                    <form id="dangKyDeTaiForm">
                        @csrf
                        <!-- Thông tin chủ nhiệm đề tài -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Thông tin chủ nhiệm đề tài</h5>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hovaten">Họ và tên</label>
                                    <input type="text" class="form-control" id="hovaten" name="hovaten" required>
                                    <div class="invalid-feedback">Vui lòng nhập họ tên</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Donvi">Đơn vị công tác</label>
                                    <input type="text" class="form-control" id="Donvi" name="Donvi" required>
                                    <div class="invalid-feedback">Vui lòng nhập đơn vị</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Sodienthoai">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="Sodienthoai" name="Sodienthoai" required>
                                    <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="email" class="form-control" id="Email" name="Email" required>
                                    <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                                </div>
                            </div>
                        </div>
                        <!-- Thông tin đề tài -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Thông tin đề tài</h5>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="tendetai">Tên đề tài</label>
                                    <input type="text" class="form-control" id="tendetai" name="tendetai" required>
                                    <div class="invalid-feedback">Vui lòng nhập tên đề tài</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="loaidetai">Loại đề tài</label>
                                    <select class="form-control" id="loaidetai" name="loaidetai" required>
                                        <option value="">-- Chọn loại đề tài --</option>
                                        @foreach($loaiDeTai as $loai)
                                            <option value="{{ $loai->id_loaidt }}" data-sogio="{{ $loai->sogioTGtoida }}"
                                                data-sotv="{{ $loai->soTVtoida }}">
                                                {{ $loai->tenloaidetai}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Vui lòng chọn loại đề tài</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linhvuc">Lĩnh vực nghiên cứu</label>
                                    <select class="form-control" id="linhvuc" name="linhvuc" required>
                                        <option value="">-- Chọn lĩnh vực --</option>
                                        @foreach($linhVuc as $lv)
                                            <option value="{{ $lv->id_lvnc }}">{{ $lv->tenlvnc }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Vui lòng chọn lĩnh vực</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="TGbatdau">Thời gian bắt đầu</label>
                                    <input type="date" class="form-control" id="TGbatdau" name="TGbatdau">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="TGketthuc">Thời gian kết thúc</label>
                                    <input type="date" class="form-control" id="TGketthuc" name="TGketthuc">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Sogiotacgia">Số giờ tác giả</label>
                                    <input type="number" class="form-control" id="Sogiotacgia" name="Sogiotacgia" min="0"
                                        required>
                                    <small class="form-text text-muted">Tối đa: <span id="maxSogio">0</span> giờ</small>
                                    <div class="invalid-feedback">Vui lòng nhập số giờ hợp lệ</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Trangthai">Trạng thái</label>
                                    <select class="form-control" id="Trangthai" name="Trangthai" required>
                                        <option value="Chờ duyệt" selected>Chờ duyệt</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Thành viên tham gia -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Thành viên tham gia
                                    <button type="button" class="btn btn-sm btn-success float-right" id="btnThemThanhVien">
                                        <i class="fas fa-plus"></i> Thêm thành viên
                                    </button>
                                </h5>
                                <small class="text-muted">Số thành viên tối đa: <span id="maxThanhVien">0</span></small>
                            </div>
                            <div class="col-md-12">
                                <div id="thanhVienContainer">
                                    <!-- Dynamic member fields will be added here -->
                                </div>
                            </div>
                        </div>

                        <!-- Tiến độ thực hiện -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Tiến độ thực hiện
                                    <button type="button" class="btn btn-sm btn-success float-right" id="btnThemTienDo">
                                        <i class="fas fa-plus"></i> Thêm tiến độ
                                    </button>
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div id="tienDoContainer">
                                    <!-- Dynamic progress fields will be added here -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary" id="btn-submit">
                                    <span id="submit-text">Đăng ký đề tài</span>
                                    <span id="submit-spinner" class="spinner-border spinner-border-sm"
                                        style="display: none;"></span>
                                </button>
                                <button type="reset" class="btn btn-secondary">Nhập lại</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Template for member row -->
    <template id="thanhVienTemplate">
        <div class="card mb-3 thanh-vien-item">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Tên thành viên</label>
                            <input type="text" class="form-control" name="thanhvien[][tenthanhvien]" required>
                            <div class="invalid-feedback">Vui lòng nhập tên thành viên</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nhiệm vụ</label>
                            <input type="text" class="form-control" name="thanhvien[][nhiemvu]" required>
                            <div class="invalid-feedback">Vui lòng nhập nhiệm vụ</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Số giờ tham gia</label>
                            <input type="number" class="form-control sogio-thanhvien" name="thanhvien[][sogio]" min="0"
                                required>
                            <div class="invalid-feedback">Vui lòng nhập số giờ</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Vai trò</label>
                            <select class="form-control" name="thanhvien[][vaitro]">
                                <option value="Thành viên">Thành viên</option>
                                <option value="Cộng tác viên">Cộng tác viên</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn mt-1 btn-sm btn-outline-danger py-0 px-1 btn-xoa-thanhvien">
                    <i class="fas fa-trash"></i> Xóa thành viên
                </button>
            </div>
        </div>
    </template>

    <!-- Template for progress row -->
    <template id="tienDoTemplate">
        <div class="card mb-3 tien-do-item">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Nội dung công việc</label>
                            <input type="text" class="form-control" name="tiendo[][ndcongviec]" required>
                            <div class="invalid-feedback">Vui lòng nhập nội dung</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Người thực hiện</label>
                            <input type="text" class="form-control" name="tiendo[][nguoithuchien]" required>
                            <div class="invalid-feedback">Vui lòng nhập người thực hiện</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tháng thực hiện</label>
                            <input type="month" class="form-control" name="tiendo[][thang]" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="tiendo[][trangthai]">
                                <option value="Chưa Thực hiện">Chưa Thực hiện</option>
                                <option value="Đang thực hiện">Đang thực hiện</option>
                                <option value="Đã thực hiện">Đã thực hiện</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Thời gian bắt đầu</label>
                            <input type="date" class="form-control" name="tiendo[][Tgbatdaucv]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Thời gian kết thúc</label>
                            <input type="date" class="form-control" name="tiendo[][Tgketthuccv]">
                        </div>
                    </div>
                </div>

                <!-- Kinh phí -->
                <div class="kinh-phi-section">
                    <h6>Kinh phí
                        <button type="button" class="btn mt-1 btn-sm btn-outline-primary btn-them-kinhphi">
                            <i class="fas fa-plus"></i> Thêm kinh phí
                        </button>
                    </h6>
                    <div class="kinh-phi-container">
                        <!-- Dynamic cost fields will be added here -->
                    </div>
                </div>

                <button type="button" class="btn mt-1 btn-sm btn-outline-danger py-0 px-1 btn-xoa-tiendo">
                    <i class="fas fa-trash"></i> Xóa tiến độ
                </button>
            </div>
        </div>
    </template>

    <!-- Template for cost row -->
    <template id="kinhPhiTemplate">
        <div class="row mb-2 kinh-phi-item">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nội dung chi</label>
                    <input type="text" class="form-control" name="tiendo[][kinhphi][][noidungchi]" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Đơn vị tính</label>
                    <input type="text" class="form-control" name="tiendo[][kinhphi][][DVT]" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số lượng</label>
                    <input type="number" class="form-control soluong-kinhphi" name="tiendo[][kinhphi][][Soluong]" min="0"
                        step="1" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Đơn giá</label>
                    <input type="number" class="form-control dongia-kinhphi" name="tiendo[][kinhphi][][dongia]" min="0"
                        required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Thành tiền</label>
                    <input type="number" class="form-control thanhtien-kinhphi" name="tiendo[][kinhphi][][thanhtien]"
                        readonly>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button type="button" class="btn mt-1 btn-sm btn-outline-danger py-0 px-1 btn-xoa-kinhphi">
                    <i class="fas fa-trash"></i> Xóa kinh phí
                </button>
            </div>
        </div>
    </template>
    <script id="user-data" type="application/json">
                @auth                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   {!! json_encode([
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'id' => auth()->user()->id
                    ]) !!}
                @else
                    null
                @endauth
                </script>
@endsection