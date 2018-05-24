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
            <div class="card-header">{{ __('Sửa nhà cung cấp') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('provider.update',$provider->MaNCC) }}" name="update">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{$provider->MaNCC}}">
                    @csrf

                    <div class="form-group row">
                        <label for="MaNCC" class="col-md-4 col-form-label text-md-right">Mã nhà cung cấp<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaNCC" type="text" class="form-control" name="MaNCC" value="{{$provider->MaNCC}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenNCC" class="col-md-4 col-form-label text-md-right">Tên nhà cung cấp<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenNCC" type="text" class="form-control" name="TenNCC" value="{{$provider->TenNCC}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DiaChi" class="col-md-4 col-form-label text-md-right">Địa chỉ nhà cung cấp<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="DiaChi" type="text" class="form-control" name="DiaChi" value="{{$provider->DiaChi}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sdtNCC" class="col-md-4 col-form-label text-md-right">Số điện thoại<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="sdtNCC" type="text" class="form-control" name="sdtNCC" value="{{$provider->SDT}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fax" class="col-md-4 col-form-label text-md-right">Fax</label>

                        <div class="col-md-6">
                            <input id="fax" type="text" class="form-control" name="fax" value="{{$provider->Fax}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="emailNCC" class="col-md-4 col-form-label text-md-right">Email<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="emailNCC" type="email" class="form-control" name="emailNCC" value="{{$provider->Email}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ghiChu" class="col-md-4 col-form-label text-md-right">Ghi chú</label>

                        <div class="col-md-6">
                            <textarea id="ghiChu" class="form-control" name="ghiChu">{{$provider->GhiChu}}</textarea>
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Sửa') }}
                            </button>
                            <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-back">
                                {{ __('Quay lại') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop