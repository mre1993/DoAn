@extends('home')
@section('right-content')
    <div class="col-md-10">
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
            <div class="card-header">{{ __('Sửa phân xưởng') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('phanxuong.update',$factory->MaPX) }}" name="update">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{$factory->MaPX}}">
                    @csrf

                    <div class="form-group row">
                        <label for="MaPX" class="col-md-4 col-form-label text-md-right">Mã phân xưởng<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaPX" type="text" class="form-control" name="MaPX" value="{{$factory->MaPX}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenPX" class="col-md-4 col-form-label text-md-right">Tên phân xưởng<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenPX" type="text" class="form-control" name="TenPX" value="{{$factory->TenPX}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ghiChu" class="col-md-4 col-form-label text-md-right">Ghi chú</label>

                        <div class="col-md-6">
                            <textarea id="ghiChu" class="form-control" name="ghiChu">{{$factory->GhiChu}}</textarea>
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