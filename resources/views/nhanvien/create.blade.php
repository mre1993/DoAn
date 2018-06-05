@extends('home')
@section('right-content')
    <div class="col-md-10" style="margin:auto">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('Thêm thông tin nhân viên') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('nhanvien.store') }}" name="create">
                    @csrf

                    <div class="form-group row">
                        <label for="MaNV" class="col-md-4 col-form-label text-md-right">Mã nhân viên<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaNV" type="text" class="form-control" name="MaNV" value="{{old('MaNV') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenNV" class="col-md-4 col-form-label text-md-right">Tên nhân viên<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenNV" type="text" class="form-control" name="TenNV" value="{{old('TenNV') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="GioiTinh" class="col-md-4 col-form-label text-md-right">Giới tính</label>

                        <div class="col-md-6">
                            <select style="height: 100%;"  name="GioiTinh" id="GioiTinh" class="form-control">
                                <option value="Nam"  {{ old('GioiTinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('GioiTinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ChucVu" class="col-md-4 col-form-label text-md-right">Chức vụ</label>

                        <div class="col-md-6">
                            <input id="ChucVu" type="text" class="form-control" name="ChucVu" value="{{old('ChucVu') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="SDT" class="col-md-4 col-form-label text-md-right">Số điện thoại</label>

                        <div class="col-md-6">
                            <input id="SDT" type="text" class="form-control" name="SDT" value="{{old('SDT') }}">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Thêm mới') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop