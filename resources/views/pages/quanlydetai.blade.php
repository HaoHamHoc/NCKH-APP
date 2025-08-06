@extends('layout.app')

@section('title', 'Đề tài đã thực hiện')

@section('content')
    <div class="main-content">
        <h2 class="mb-4">Đề tài đã thực hiện</h2>
        <div class="border-start border-4 border-danger ps-3 py-2 mb-3 bg-light fw-bold">
            Đề tài chờ duyệt
        </div>
        @if(isset($detai_choduyet) && count($detai_choduyet) > 0)
            <table class="table table-bordered table-sm mb-3">
                <thead>
                    <tr>
                        <th>Tên đề tài</th>
                        <th>Chủ nhiệm</th>
                        <th>Thời hạn</th>
                        <th>Ngày đăng ký</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detai_choduyet as $dt)
                        <tr>
                            <td>{{ $dt->tendetai }}</td>
                            <td>{{ $dt->hotenCN }}</td>
                            <td>{{ $dt->sothang }} tháng</td>
                            <td>Ngày đăng ký</td>
                            <td>
                                @if($dt->trangthai == 'Chờ duyệt')
                                    <span class="badge bg-secondary">{{ $dt->trangthai }}</span>
                                @elseif($dt->trangthai == 'Không duyệt')
                                    <span class="badge bg-danger">{{ $dt->trangthai }}</span>
                                @else
                                    <span class="badge bg-success">{{ $dt->trangthai }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">Không có đề tài nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="mb-3 text-secondary">Không có đề tài nào chờ duyệt.</div>
        @endif
        <div class="border-start border-4 border-primary ps-3 py-2 mb-3 bg-light fw-bold">
            Đề tài đã nghiệm thu
        </div>
        @if(isset($detai_nghiemthu) && count($detai_nghiemthu) > 0)
            <table class="table table-bordered table-sm mb-3">
                <thead>
                    <tr>
                        <th>Tên đề tài</th>
                        <th>Chủ nhiệm</th>
                        <th>Nghiệm thu</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detai_nghiemthu as $dt)
                        <tr>
                            <td><a href="#" class="link-primary" style="text-decoration:none;">{{ $dt->tendetai }}</a></td>
                            <td>{{ $dt->hotenCN }}</td>
                            <td>
                                @if($dt->tgnghiemthu)
                                    {{ \Carbon\Carbon::parse($dt->tgnghiemthu)->format('m-Y') }}
                                @endif
                            </td>
                            <td>
                                @if($dt->trangthai == 'Chờ duyệt')
                                    <span class="badge bg-secondary">{{ $dt->trangthai }}</span>
                                @elseif($dt->trangthai == 'Không duyệt')
                                    <span class="badge bg-danger">{{ $dt->trangthai }}</span>
                                @else
                                    <span class="badge bg-success">{{ $dt->trangthai }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">Không có đề tài nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="mb-3 text-secondary">Không có đề tài nào đã nghiệm thu.</div>
        @endif
        <div class="border-start border-4 border-success ps-3 py-2 mb-3 bg-light fw-bold">
            Đề tài tham gia
        </div>
        @if(isset($detai_thanhvien) && count($detai_thanhvien) > 0)
            <table class="table table-bordered table-sm mb-3">
                <thead>
                    <tr>
                        <th>Tên đề tài</th>
                        <th>Chủ nhiệm</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detai_thanhvien as $dt)
                        <tr>
                            <td><a href="#" class="link-primary" style="text-decoration:none;">{{ $dt->tendetai }}</a></td>
                            <td>{{ $dt->hotenCN }}</td>
                            <td>
                                <span class="badge bg-success">{{ $dt->trangthai }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">Không có đề tài nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="mb-3 text-secondary">Không có đề tài nào bạn tham gia.</div>
        @endif
    </div>
@endsection