<div class="form-group mb-3">
    <label for="filterStatus">Lọc theo trạng thái:</label>
    <select id="filterStatus" class="form-control form-control-sm w-25">
        <option value="Tất cả">Tất cả</option>
        <option value="Hoàn thành">Hoàn thành</option>
        <option value="Đang thực hiện">Đang thực hiện</option>
        <option value="Chờ duyệt">Chờ duyệt</option>
    </select>
</div>
<table class="table table-bordered table-striped table-sm">
    <thead class="thead-dark">
        <tr>
            <th>STT</th>
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
        @php
            $detais = [
                ['ten' => 'Nghiên cứu AI trong y tế', 'batdau' => '2025-01-15', 'ketthuc' => '2025-06-30', 'thoigian' => '5.5 tháng', 'gioquydoi' => 120, 'namhoc' => '2024-2025', 'trangthai' => 'Hoàn thành'],
                ['ten' => 'Ứng dụng Machine Learning vào giáo dục', 'batdau' => '2025-02-01', 'ketthuc' => '2025-08-15', 'thoigian' => '6.5 tháng', 'gioquydoi' => 140, 'namhoc' => '2024-2025', 'trangthai' => 'Đang thực hiện'],
                ['ten' => 'Hệ thống quản lý nông nghiệp thông minh', 'batdau' => '2025-03-10', 'ketthuc' => '2025-09-30', 'thoigian' => '6.5 tháng', 'gioquydoi' => 130, 'namhoc' => '2024-2025', 'trangthai' => 'Chờ duyệt'],
            ];
        @endphp

        @foreach ($detais as $index => $detai)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detai['ten'] }}</td>
                <td>{{ \Carbon\Carbon::parse($detai['batdau'])->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($detai['ketthuc'])->format('d/m/Y') }}</td>
                <td>{{ $detai['thoigian'] }}</td>
                <td>{{ $detai['gioquydoi'] }}</td>
                <td>{{ $detai['namhoc'] }}</td>
                <td>
                    @if ($detai['trangthai'] == 'Hoàn thành')
                        <span class="badge badge-success">{{ $detai['trangthai'] }}</span>
                    @elseif ($detai['trangthai'] == 'Đang thực hiện')
                        <span class="badge badge-warning">{{ $detai['trangthai'] }}</span>
                    @else
                        <span class="badge badge-secondary">{{ $detai['trangthai'] }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>