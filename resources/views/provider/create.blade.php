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
            <div class="card-header">{{ __('Thêm nhà cung cấp') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('provider.store') }}" name="create">
                    @csrf

                    <div class="form-group row">
                        <label for="MaNCC" class="col-md-4 col-form-label text-md-right">Mã nhà cung cấp*</label>
                        *
                        <div class="col-md-6">
                            <input id="MaNCC" type="text" class="form-control" name="MaNCC">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenNCC" class="col-md-4 col-form-label text-md-right">Tên nhà cung cấp*</label>

                        <div class="col-md-6">
                            <input id="TenNCC" type="text" class="form-control" name="TenNCC">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DiaChi" class="col-md-4 col-form-label text-md-right">Địa chỉ nhà cung cấp*</label>

                        <div class="col-md-6">
                            <input id="DiaChi" type="text" class="form-control" name="DiaChi">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sdtNCC" class="col-md-4 col-form-label text-md-right">Số điện thoại*</label>

                        <div class="col-md-6">
                            <input id="sdtNCC" type="text" class="form-control" name="sdtNCC">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fax" class="col-md-4 col-form-label text-md-right">Fax</label>

                        <div class="col-md-6">
                            <input id="fax" type="text" class="form-control" name="fax">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="emailNCC" class="col-md-4 col-form-label text-md-right">Email*</label>

                        <div class="col-md-6">
                            <input id="emailNCC" type="email" class="form-control" name="emailNCC">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ghiChu" class="col-md-4 col-form-label text-md-right">Ghi chú</label>

                        <div class="col-md-6">
                            <textarea id="ghiChu" class="form-control" name="ghiChu"></textarea>
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