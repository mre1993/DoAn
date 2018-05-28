@extends('home')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-8" style="margin:auto">
        <div class="card">
            <div class="card-header">{{ __('Thêm kho vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('khovattu.store') }}" name="create">
                    @csrf

                    <div class="form-group row">
                        <label for="MaKVT" class="col-md-4 col-form-label text-md-right">Mã kho<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaKVT" type="text" class="form-control" name="MaKVT">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenKVT" class="col-md-4 col-form-label text-md-right">Tên kho<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenKVT" type="text" class="form-control" name="TenKVT">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DiaChi" class="col-md-4 col-form-label text-md-right">Địa chỉ<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="DiaChi" type="text" class="form-control" name="DiaChi">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="SDT" class="col-md-4 col-form-label text-md-right">Số điện thoại<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="SDT" type="text" class="form-control" name="SDT">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Fax" class="col-md-4 col-form-label text-md-right">Fax</label>

                        <div class="col-md-6">
                            <input id="Fax" type="text" class="form-control" name="Fax">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ThuKho" class="col-md-4 col-form-label text-md-right">Thủ kho</label>

                        <div class="col-md-6">
                            <input id="ThuKho" type="text" class="form-control" name="ThuKho">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="GhiChu" class="col-md-4 col-form-label text-md-right">Ghi chú</label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="GhiChu" id="GhiChu">
                            </textarea>
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