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
            <div class="card-header">{{ __('Sửa loại vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('theloai.update',$loai->MaLoaiVT) }}" name="update">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{$loai->MaLoaiVT}}">
                    @csrf

                    <div class="form-group row">
                        <label for="MaLoaiVT" class="col-md-4 col-form-label text-md-right">Mã loại vật tư<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaLoaiVT" type="text" class="form-control" name="MaLoaiVT" value="{{$loai->MaLoaiVT}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenLoaiVT" class="col-md-4 col-form-label text-md-right">Tên loại vật tư<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenLoaiVT" type="text" class="form-control" name="TenLoaiVT" value="{{$loai->TenLoaiVT}}">
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