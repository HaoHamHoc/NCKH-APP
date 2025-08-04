@extends('layout.app')

@section('title', 'Đề tài cá nhân')

@section('content')
    <div class="main-content">
        <h2 class="mb-4">Đề tài cá nhân</h2>

        <div class="border-start border-4 border-primary ps-3 py-2 mb-3 bg-light fw-bold">
            Đề tài đang thực hiện
        </div>
        @if ($dieukien)
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Chủ nhiệm</th>
                        <th>Tên đề tài</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Thời gian thực hiện</th>
                        <th>Số giờ quy đổi</th>
                        <th>Năm học tính giờ</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $dsDetai->hotenCN}}</td>
                        <td>{{ $dsDetai->tendetai }}</td>
                        <td>{{ \Carbon\Carbon::parse($dsDetai->tgbatdau)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($dsDetai->tgketthuc)->format('d/m/Y') }}</td>
                        <td>{{ $dsDetai->sothang }} (Tháng)</td>
                        <td>{{ $dsDetai->sogiotg }}</td>
                        <td>{{ \Carbon\Carbon::parse($dsDetai->created_at)->year }}</td>
                        <td>
                            @if ($dsDetai->trangthai == 'Đã duyệt')
                                <span class="badge badge-success">{{ $dsDetai->trangthai }}</span>
                            @else
                                <span class="badge badge-secondary">{{ $dsDetai->trangthai }}</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="border-start border-4 border-primary ps-3 py-2 mb-3 bg-light fw-bold">
                Danh sách thành viên
            </div>
            @if ($thanhviens->count() > 0)
                <table class="table table-bordered table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Nhiệm vụ</th>
                            <th>Vai trò</th>
                            <th>Số giờ tham gia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($thanhviens as $index => $tv)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $tv->tenthanhvien ?? $tv->ThanhvienDT->hoten }}</td>
                                <td>{{ $tv->nhiemvu }}</td>
                                <td>{{ $tv->vaitro }}</td>
                                <td>{{ $tv->sogiothamgia }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">Không có thành viên nào.</div>
            @endif
            <div class="border-start border-4 border-primary ps-3 py-2 mb-3 bg-light fw-bold">
                Tiến độ thực hiện
            </div>
            @forelse ($tiendo as $td)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Công việc:</strong> {{ $td->ndcongviec }}
                            </div>
                            <div>
                                <span
                                    class="badge 
                                                                                                                                                                                                                                                    @if($td->trangthai == 'Hoàn thành') bg-success 
                                                                                                                                                                                                                                                    @elseif($td->trangthai == 'Đang thực hiện') bg-warning 
                                                                                                                                                                                                                                                    @else bg-secondary @endif">
                                    {{ $td->trangthai }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Thời gian: {{$td->thang}} | </strong> {{ \Carbon\Carbon::parse($td->tgbatdau)->format('d/m/Y') }}
                            -
                            {{ \Carbon\Carbon::parse($td->tgketthuc)->format('d/m/Y') }}
                        </p>
                        <h5>Kinh phí liên quan:</h5>
                        @if($td->Kinhphi->count() > 0)
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Chi tiết khoản chi</th>
                                        <th>Đơn vị tính</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($td->Kinhphi as $kp)
                                        <tr>
                                            <td>{{ $kp->ctkhoanchi }}</td>
                                            <td>{{ $kp->donvitinh }}</td>
                                            <td>{{ $kp->soluong }}</td>
                                            <td>{{ number_format($kp->dongia, 0, ',', '.') }}</td>
                                            <td>{{ number_format($kp->thanhtien, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm py-0 px-1 btn-outline-primary"><i class="fas fa-edit"></i>
                                                    Sửa</a>
                                                <button type="button" class="btn btn-sm py-0 px-1 btn-outline-danger"
                                                    onclick="if(confirm('Bạn có chắc muốn xoá?')){/* Xử lý xoá */}"><i
                                                        class="fas fa-trash"></i> Xoá</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">Không có kinh phí nào.</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Không có tiến độ nào.</div>
            @endforelse
        @else
            <div class="alert alert-info" role="alert">
                Bạn chưa đăng ký đề tài nào.
            </div>
        @endif
    </div>
@endsection