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
            <div class="card-header">{{ __('Thêm vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{route('vattu.update',$item->MaVT)}}" name="update">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{$item->MaVT}}">
                    @csrf

                    <div class="form-group row">
                        <label for="MaVT" class="col-md-4 col-form-label text-md-right">Mã vật tư<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaVT" type="text" class="form-control" name="MaVT" value="{{$item->MaVT}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenVT" class="col-md-4 col-form-label text-md-right">Tên vật tư<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenVT" type="text" class="form-control" name="TenVT" value="{{$item->TenVT}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DVT" class="col-md-4 col-form-label text-md-right">Đơn vị tính</label>

                        <div class="col-md-6">
                            <select  style="width: 50%;height: 100%;" id="DVT" name="DVT" class="form-control" >
                            @foreach($DVT as $dvt)
                                <option name="DVT" value="{{ $dvt }}"  @if( ucfirst ($item->DVT) === $dvt) selected='selected' @endif> {{ $dvt }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="MaNCC" class="col-md-4 col-form-label text-md-right">Nhà cung cấp</label>

                        <div class="col-md-6">
                            <select style="width: 50%;height: 100%;" class="form-control"  name="MaNCC" id="MaNCC">
                                @foreach($NCC as $item1)
                                    <option value="{{ $item1->MaNCC }}" @if( $item->NhaCungCap->TenNCC=== $item1->TenNCC) selected='selected' @endif> {{ $item1->TenNCC }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="MaLoaiVT" class="col-md-4 col-form-label text-md-right">Loại vật tư</label>

                        <div class="col-md-6">
                            <select style="width: 50%;height: 100%;"  name="MaLoaiVT" id="MaLoaiVT" class="form-control">
                                @foreach($MaLoaiVT as $item2)
                                    <option value="{{ $item2->MaLoaiVT }}" @if( $item->LoaiVatTu->TenLoaiVT=== $item2->TenLoaiVT) selected='selected' @endif> {{ $item2->TenLoaiVT }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="DonGia" class="col-md-4 col-form-label text-md-right">DonGia<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="DonGia" type="text" class="form-control" name="DonGia" value="{{$item->DonGia}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="MoTa" class="col-md-4 col-form-label text-md-right">Mô tả</label>

                        <div class="col-md-6">
                            <textarea id="MoTa" class="form-control" name="MoTa">{{$item->MoTa}}</textarea>
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