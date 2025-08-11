@extends('layoutAdmin.app')

@section('content')
<div class="main-content container mt-4">
    <h1 class="mb-4">{{ ucfirst($type) }}</h1>
    <div class="mb-3 d-flex align-items-center">
        <button id="btn-table" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-table"></i> Dạng bảng</button>
        <button id="btn-grid" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-th"></i> Dạng lưới</button>
        @if($allowAdd)
            <button class="btn btn-success btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#modalAdd"><i class="fas fa-plus"></i> Thêm mới</button>
        @endif
    </div>

    <!-- Modal thêm mới -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route($addRoute) }}" method="{{ $addMethod ?? 'POST' }}">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="modalAddLabel">Thêm mới {{ $title ?? $type }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @foreach($columns as $col)
                <div class="mb-3">
                  <label class="form-label">{{ $col['label'] }}</label>
                  @if($col['type'] === 'longtext')
                    <textarea class="form-control" name="{{ $col['key'] }}"></textarea>
                  @elseif($col['type'] === 'number')
                    <input type="number" class="form-control" name="{{ $col['key'] }}" required>
                  @elseif($col['type'] === 'select' && !empty($col['options']))
                    <select class="form-control" name="{{ $col['key'] }}" required>
                      @foreach($col['options'] as $optValue => $optLabel)
                        <option value="{{ $optValue }}">{{ $optLabel }}</option>
                      @endforeach
                    </select>
                  @else
                    <input type="text" class="form-control" name="{{ $col['key'] }}" required>
                  @endif
                </div>
              @endforeach
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              <button type="submit" class="btn btn-success">Thêm mới</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div id="view-table" style="display: {{ $layout == 'table' ? '' : 'none' }};">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" style="background-color: #1565c0; color: #fff;">#</th>
                        @foreach($columns as $col)
                        <th scope="col" class="text-center" style="background-color: #1565c0; color: #fff;">{{ $col['label'] }}</th>
                        @endforeach
                        @if(!empty($updateRoute) || !empty($deleteRoute))
                            <th scope="col" class="text-center" style="background-color: #1565c0; color: #fff;">Thao tác</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i => $item)
                    <tr>
                        <th scope="row">{{ $i + 1 }}</th>
                        @foreach($columns as $col)
                        <td>
                            <span class="view-mode">{{ $item[$col['key']] ?? 'Không' }}</span>
                            @if($col['type'] === 'longtext')
                                <textarea class="form-control form-control-sm edit-mode d-none" name="{{ $col['key'] }}">{{ $item[$col['key']] ?? '' }}</textarea>
                            @elseif($col['type'] === 'select' && !empty($col['options']))
                                <select class="form-control form-control-sm edit-mode d-none" name="{{ $col['key'] }}">
                                    @foreach($col['options'] as $optValue => $optLabel)
                                        <option value="{{ $optValue }}" @if(($item[$col['key']] ?? '') == $optValue) selected @endif>{{ $optLabel }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="{{ $col['type'] ?? 'text' }}" class="form-control form-control-sm edit-mode d-none" name="{{ $col['key'] }}" value="{{ $item[$col['key']] ?? '' }}">
                            @endif
                        </td>
                        @endforeach
                        @if(!empty($updateRoute) || !empty($deleteRoute))
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2 action-buttons">
                                @if(!empty($updateRoute))
                                    <a href="#" class="btn btn-sm btn-primary btn-edit-row" title="Sửa"><i class="fas fa-edit"></i></a>
                                @endif
                                @if(!empty($deleteRoute))
                                    <form action="{{ route($deleteRoute) }}" method="POST" class="d-inline delete-item-form m-0" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item[$primaryKey] }}">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                @endif
                                {{-- Thêm các nút khác tại đây nếu cần --}}
                            </div>
                            @if(!empty($updateRoute))
                                <form action="{{ route($updateRoute) }}" method="POST" class="edit-actions d-none m-0 p-0 d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item[$primaryKey] }}">
                                    @foreach($columns as $col)
                                    <input type="hidden" name="{{ $col['key'] }}">
                                    @endforeach
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                                        <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit">Hủy</button>
                                    </div>
                                </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="view-grid" style="display: {{ $layout == 'grid' ? '' : 'none' }};">
        <div class="row">
            @foreach($items as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if(!empty($updateRoute))
                        <form action="{{ route($updateRoute) }}" method="POST" class="card-edit-form h-100 d-flex flex-column">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item[$primaryKey] }}">
                            <div class="card-body flex-grow-1">
                                @foreach($columns as $col)
                                <div class="mb-2">
                                    <strong>{{ $col['label'] }}:</strong>
                                <span class="view-mode">{{ $item[$col['key']] ?? 'Không' }}</span>
                                @if($col['type'] === 'longtext')
                                    <textarea class="form-control form-control-sm edit-mode d-none" name="{{ $col['key'] }}">{{ $item[$col['key']] ?? '' }}</textarea>
                                @elseif($col['type'] === 'select' && !empty($col['options']))
                                    <select class="form-control form-control-sm edit-mode d-none" name="{{ $col['key'] }}">
                                        @foreach($col['options'] as $optValue => $optLabel)
                                            <option value="{{ $optValue }}" @if(($item[$col['key']] ?? '') == $optValue) selected @endif>{{ $optLabel }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="{{ $col['type'] ?? 'text' }}" class="form-control form-control-sm edit-mode d-none" name="{{ $col['key'] }}" value="{{ $item[$col['key']] ?? '' }}">
                                @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="card-footer bg-white border-0 d-flex justify-content-end">
                                <div class="action-buttons">
                                    <a href="#" class="btn btn-sm btn-primary me-1 btn-edit-card" title="Sửa"><i class="fas fa-edit"></i></a>
                                    @if(!empty($deleteRoute))
                                        <form action="{{ route($deleteRoute) }}" method="POST" class="d-inline delete-item-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item[$primaryKey] }}">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endif
                                </div>
                                <div class="edit-actions d-none">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                                        <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit">Hủy</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="card-body flex-grow-1">
                            @foreach($columns as $col)
                            <div class="mb-2">
                                <strong>{{ $col['label'] }}:</strong>
                                <span class="view-mode">{{ $item[$col['key']] ?? 'Không' }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-end">
                            <div class="action-buttons">
                                @if(!empty($deleteRoute))
                                    <form action="{{ route($deleteRoute) }}" method="POST" class="d-inline delete-item-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item[$primaryKey] }}">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
// Test JavaScript trực tiếp
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inline JS loaded successfully');
    
    // Test layout buttons
    const btnTable = document.getElementById('btn-table');
    const btnGrid = document.getElementById('btn-grid');
    
    if (btnTable) {
        console.log('Table button found');
        btnTable.addEventListener('click', function() {
            console.log('Table button clicked');
            localStorage.setItem('layout', 'table');
            window.location.search = '?layout=table';
        });
    }
    
    if (btnGrid) {
        console.log('Grid button found');
        btnGrid.addEventListener('click', function() {
            console.log('Grid button clicked');
            localStorage.setItem('layout', 'grid');
            window.location.search = '?layout=grid';
        });
    }
    
    // Test edit buttons
    const editButtons = document.querySelectorAll('.btn-edit-row');
    console.log('Found edit buttons:', editButtons.length);
    
    editButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            console.log('Edit button clicked');
            e.preventDefault();
            const tr = btn.closest('tr');
            if (tr) {
                tr.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
                tr.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
                tr.querySelector('.action-buttons').classList.add('d-none');
                tr.querySelector('.edit-actions').classList.remove('d-none');
            }
        });
    });
    
    // Test cancel buttons
    const cancelButtons = document.querySelectorAll('.btn-cancel-edit');
    console.log('Found cancel buttons:', cancelButtons.length);
    
    cancelButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            console.log('Cancel button clicked');
            e.preventDefault();
            const tr = btn.closest('tr') || btn.closest('.card-edit-form');
            if (tr) {
                tr.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
                tr.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                tr.querySelector('.action-buttons').classList.remove('d-none');
                tr.querySelector('.edit-actions').classList.add('d-none');
            }
        });
    });
    
    // Test edit forms
    const editForms = document.querySelectorAll('form.edit-actions');
    console.log('Found edit forms:', editForms.length);
    
    editForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            console.log('Edit form submitted');
            const tr = form.closest('tr');
            if (tr) {
                e.preventDefault();
                const editInputs = Array.from(tr.querySelectorAll('input[name], select[name], textarea[name]'))
                    .filter(function(el) {
                        const isHiddenType = el.tagName === 'INPUT' && el.type === 'hidden';
                        const insideForm = !!el.closest('form');
                        return !isHiddenType && !insideForm;
                    });
                console.log('Found edit inputs:', editInputs.length);
                
                editInputs.forEach(function(input) {
                    const fieldName = input.name;
                    let hiddenInput = form.querySelector(`input[name="${fieldName}"]`);
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = fieldName;
                        form.appendChild(hiddenInput);
                    }
                    hiddenInput.value = input.value;
                    console.log('Copied field:', fieldName, '=', input.value);
                });
                form.submit();
                return;
            }
        });
    });
});
</script>
@endsection

@vite(['resources/js/adminPage/index.js'])
