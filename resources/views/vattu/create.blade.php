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
            <div class="card-header">{{ __('Thêm vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('vattu.store') }}" name="create">
                    @csrf

                    <div class="form-group row">
                        <label for="MaVT" class="col-md-4 col-form-label text-md-right">Mã vật tư<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaVT" type="text" class="form-control" name="MaVT" value="{{old('MaVT')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenVT" class="col-md-4 col-form-label text-md-right">Tên vật tư<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenVT" type="text" class="form-control" name="TenVT" value="{{old('TenVT')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DVT" class="col-md-4 col-form-label text-md-right">Đơn vị tính</label>

                        <div class="col-md-6">
                            <select style="width: 50%;height: 100%;"  name="DVT" id="DVT" class="form-control">
                                @foreach($DVT as $dvt)
                                    <option value="{{ $dvt }}" {{ old('DVT') == $dvt ? 'selected' : '' }}> {{ $dvt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="MaNCC" class="col-md-4 col-form-label text-md-right">Nhà cung cấp</label>

                        <div class="col-md-6">
                            <select style="width: 50%;height: 100%;"  name="MaNCC" id="MaNCC" class="form-control">
                                @foreach($NCC as $item1)
                                    <option value="{{ $item1->MaNCC }}"  {{ old('MaNCC') == $item1->MaNCC ? 'selected' : '' }}> {{ $item1->TenNCC }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DonGia" class="col-md-4 col-form-label text-md-right">Đơn giá<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="DonGia" type="text" class="form-control" name="DonGia" value="{{old('DonGia')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="MoTa" class="col-md-4 col-form-label text-md-right">Mô tả</label>

                        <div class="col-md-6">
                            <textarea id="MoTa" class="form-control" name="MoTa">{{old('MoTa')}}</textarea>
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