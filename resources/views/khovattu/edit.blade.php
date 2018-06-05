@extends('home')
@section('right-content')
    <div class="col-md-8" style="margin:auto">
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
            <div class="card-header">{{ __('Sửa thông tin kho vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('khovattu.update',$item->MaKVT) }}" name="update">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{$item->MaKVT}}">
                    @csrf

                    <div class="form-group row">
                        <label for="MaKVT" class="col-md-4 col-form-label text-md-right">Mã kho vật tư<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaKVT" type="text" class="form-control" name="MaKVT" value="{{$item->MaKVT}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenKVT" class="col-md-4 col-form-label text-md-right">Tên kho<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenKVT" type="text" class="form-control" name="TenKVT" value="{{$item->TenKVT}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DiaChi" class="col-md-4 col-form-label text-md-right">Địa chỉ<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="DiaChi" type="text" class="form-control" name="DiaChi" value="{{$item->DiaChi}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="SDT" class="col-md-4 col-form-label text-md-right">Số điện thoại<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="SDT" type="text" class="form-control" name="SDT" value="{{$item->SDT}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Fax" class="col-md-4 col-form-label text-md-right">Fax</label>

                        <div class="col-md-6">
                            <input id="Fax" type="text" class="form-control" name="Fax" value="{{$item->Fax}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ThuKho" class="col-md-4 col-form-label text-md-right">Thủ kho</label>

                        <div class="col-md-6">
                            <input id="ThuKho" type="text" class="form-control" name="ThuKho" value="{{$item->ThuKho}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="GhiChu" class="col-md-4 col-form-label text-md-right">Ghi chú</label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="GhiChu" id="GhiChu">
                                {{$item->GhiChu}}
                            </textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Sửa') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop