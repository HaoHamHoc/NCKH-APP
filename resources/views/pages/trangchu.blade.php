@extends('layout.app')
@section('title', 'Trang chủ')
@section('content')
    @vite(['resources/js/pages/trangchu.js'])
    <div class="main-content" id="trang-chu">
        <div class="page-header">
            <h2 class="header-title">Tìm kiếm đề tài nghiên cứu khoa học</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/detainckh" class="breadcrumb-item"><i class="anticon anticon-home"></i> Trang chủ</a>
                    <span class="breadcrumb-item active">Tìm kiếm đề tài</span>
                </nav>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="research_type">Loại đề tài</label>
                                <select class="form-control" id="research_type" name="research_type">
                                    @foreach ($loaiDeTai as $ldt)
                                        <option value="{{ $ldt->id_loaidt }}">{{ $ldt->tenloaidetai}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keyword">Từ khóa tìm kiếm</label>
                                <input type="text" class="form-control" id="keyword" name="keyword"
                                    placeholder="Nhập tên đề tài, mã đề tài, chủ nhiệm đề tài...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="d-block opacity-0">Tìm kiếm</label>
                            <button type="submit" class="btn btn-primary btn-tone">
                                <i class="anticon anticon-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="bangdetai"></div>
    </div>
@endsection