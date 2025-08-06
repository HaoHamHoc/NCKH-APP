@extends('layoutAdmin.app')

@section('content')
<div class="main-content container mt-4">
    <h1 class="mb-4">Quản lý tài khoản</h1>
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
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Đơn vị công tác</th>
                        <th scope="col">Quyền</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taikhoans as $i => $user)
                    <tr>
                        <th scope="row">{{ $i + 1 }}</th>
                        <td>
                            <span class="view-mode">{{ $user->hovaten ?? '' }}</span>
                            <input type="text" class="form-control form-control-sm edit-mode d-none" name="hovaten" value="{{ $user->hovaten ?? '' }}">
                        </td>
                        <td>
                            <span class="view-mode">{{ $user->email }}</span>
                            <input type="email" class="form-control form-control-sm edit-mode d-none" name="email" value="{{ $user->email }}">
                        </td>
                        <td>
                            <span class="view-mode">{{ $user->dvcongtac ?? '' }}</span>
                            <input type="text" class="form-control form-control-sm edit-mode d-none" name="dvcongtac" value="{{ $user->dvcongtac ?? '' }}">
                        </td>
                        <td>
                            <span class="view-mode">{{ ucfirst($user->permission) }}</span>
                            <select class="form-select form-select-sm edit-mode d-none" name="permission">
                                <option value="user" {{ $user->permission == 'user' ? 'selected' : '' }}>User</option>
                                <option value="manager" {{ $user->permission == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="admin" {{ $user->permission == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="btn btn-sm btn-primary me-1 btn-edit-row" title="Sửa"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('deleteTaiKhoan') }}" method="POST" class="d-inline delete-user-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                            <form action="{{ route('updateTaiKhoan') }}" method="POST" class="edit-actions d-none m-0 p-0 d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <input type="hidden" name="hovaten">
                                <input type="hidden" name="email">
                                <input type="hidden" name="dvcongtac">
                                <input type="hidden" name="permission">
                                <button type="submit" class="btn btn-sm btn-success me-1">Lưu</button>
                                <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit">Hủy</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="view-grid" style="display:none;">
        <div class="row">
            @foreach($taikhoans as $user)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <form action="{{ route('updateTaiKhoan')}}" method="POST" class="card-edit-form h-100 d-flex flex-column">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="card-body flex-grow-1">
                            <h5 class="card-title">
                                <span class="view-mode">{{ $user->hovaten ?? $user->name }}</span>
                                <input type="text" class="form-control form-control-sm edit-mode d-none" name="hovaten" value="{{ $user->hovaten ?? $user->name }}">
                            </h5>
                            <p class="card-text mb-1">
                                <strong>Email:</strong>
                                <span class="view-mode">{{ $user->email }}</span>
                                <input type="email" class="form-control form-control-sm edit-mode d-none" name="email" value="{{ $user->email }}">
                            </p>
                            <p class="card-text mb-1">
                                <strong>Đơn vị công tác:</strong>
                                <span class="view-mode">{{ $user->dvcongtac ?? '-' }}</span>
                                <input type="text" class="form-control form-control-sm edit-mode d-none" name="dvcongtac" value="{{ $user->dvcongtac ?? '' }}">
                            </p>
                            <div>
                                <label class="form-label"><strong>Quyền:</strong></label>
                                <span class="view-mode">{{ ucfirst($user->permission) }}</span>
                                <select name="permission" class="form-select form-select-sm w-auto d-inline-block edit-mode d-none">
                                    <option value="user" {{ $user->permission == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="manager" {{ $user->permission == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="admin" {{ $user->permission == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-end">
                            <div class="action-buttons">
                                <a href="#" class="btn btn-sm btn-primary me-1 btn-edit-card" title="Sửa"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('deleteTaiKhoan') }}" method="POST" class="d-inline delete-user-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                            <div class="edit-actions d-none">
                                <button type="submit" class="btn btn-sm btn-success me-1">Lưu</button>
                                <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit">Hủy</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bảng
    document.querySelectorAll('.btn-edit-row').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const tr = btn.closest('tr');
            tr.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
            tr.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
            tr.querySelector('.action-buttons').classList.add('d-none');
            tr.querySelector('.edit-actions').classList.remove('d-none');
        });
    });
    document.querySelectorAll('.btn-cancel-edit').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const tr = btn.closest('tr') || btn.closest('.card-edit-form');
            tr.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
            tr.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
            tr.querySelector('.action-buttons').classList.remove('d-none');
            tr.querySelector('.edit-actions').classList.add('d-none');
        });
    });
    document.querySelectorAll('.edit-actions').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const tr = form.closest('tr');
            if (tr) {
                form.querySelector('input[name="hovaten"]').value = tr.querySelector('input[name="hovaten"]').value;
                form.querySelector('input[name="email"]').value = tr.querySelector('input[name="email"]').value;
                form.querySelector('input[name="dvcongtac"]').value = tr.querySelector('input[name="dvcongtac"]').value;
                form.querySelector('input[name="permission"]').value = tr.querySelector('select[name="permission"]').value;
            }
            setTimeout(function() {
                if (tr) {
                    tr.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
                    tr.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                    tr.querySelector('.action-buttons').classList.remove('d-none');
                    tr.querySelector('.edit-actions').classList.add('d-none');
                } else {
                    // Card
                    const cardForm = form.closest('.card-edit-form');
                    cardForm.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
                    cardForm.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                    cardForm.querySelector('.action-buttons').classList.remove('d-none');
                    cardForm.querySelector('.edit-actions').classList.add('d-none');
                }
            }, 300);
        });
    });
    // Card
    document.querySelectorAll('.btn-edit-card').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const cardForm = btn.closest('.card-edit-form');
            cardForm.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
            cardForm.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
            cardForm.querySelector('.action-buttons').classList.add('d-none');
            cardForm.querySelector('.edit-actions').classList.remove('d-none');
        });
    });
});
</script>

@vite(['resources/js/convertLayout.js'])
