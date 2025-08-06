@extends('layoutAdmin.app')

@section('content')
<div class="main-content container mt-4">
    <h1 class="mb-4">Sản phẩm nghiên cứu</h1>
    <div class="mb-3">
        <button id="btn-table" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-table"></i> Dạng bảng</button>
        <button id="btn-grid" class="btn btn-outline-secondary btn-sm"><i class="fas fa-th"></i> Dạng lưới</button>
    </div>
    <div id="view-table">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Loại sản phẩm</th>
                        <th scope="col">Năm</th>
                        <th scope="col">Tác giả</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sanphams as $i => $sp)
                    <tr>
                        <th scope="row">{{ $i + 1 }}</th>
                        <td>{{ $sp['ten'] }}</td>
                        <td>{{ $sp['loai'] }}</td>
                        <td>{{ $sp['nam'] }}</td>
                        <td>{{ $sp['tacgia'] }}</td>
                        <td><span class="badge {{ $sp['trangthai']['class'] }}">{{ $sp['trangthai']['label'] }}</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i> Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="view-grid" style="display:none;">
        <div class="row">
            @foreach($sanphams as $sp)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sp['ten'] }}</h5>
                        <p class="card-text mb-1"><strong>Loại:</strong> {{ $sp['loai'] }}</p>
                        <p class="card-text mb-1"><strong>Năm:</strong> {{ $sp['nam'] }}</p>
                        <p class="card-text mb-1"><strong>Tác giả:</strong> {{ $sp['tacgia'] }}</p>
                        <span class="badge {{ $sp['trangthai']['class'] }}">{{ $sp['trangthai']['label'] }}</span>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-end">
                        <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i> Sửa</a>
                        <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Xóa</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@push('scripts')
<script>
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
</script>
@endpush
@endsection
