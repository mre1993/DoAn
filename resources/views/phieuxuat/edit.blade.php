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
            <div class="card-header">{{ __('Sửa thông tin nhân viên') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('nhanvien.update',$item->MaNV) }}" name="update">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{$item->MaNV}}">
                    @csrf

                    <div class="form-group row">
                        <label for="MaNV" class="col-md-4 col-form-label text-md-right">Mã nhân viên<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="MaNV" type="text" class="form-control" name="MaNV" value="{{$item->MaNV}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="TenNV" class="col-md-4 col-form-label text-md-right">Tên nhân viên<span class="color-red">*</span></label>

                        <div class="col-md-6">
                            <input id="TenNV" type="text" class="form-control" name="TenNV" value="{{$item->TenNV}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="GioiTinh" class="col-md-4 col-form-label text-md-right">Giới tính</label>

                        <div class="col-md-6">
                            <select style="height: 100%;"  name="GioiTinh" id="GioiTinh" class="form-control">
                                {{$i = 0}}
                                @foreach($sex as $item1)
                                    <option value="{{ $item1 }}" @if( $item->GioiTinh=== $item1) selected='selected' @endif> {{ $item1 }}</option>
                                    {{$i++}}
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ChucVu" class="col-md-4 col-form-label text-md-right">Chức vụ</label>

                        <div class="col-md-6">
                            <input id="ChucVu" type="text" class="form-control" name="ChucVu" value="{{$item->ChucVu}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="SDT" class="col-md-4 col-form-label text-md-right">Số điện thoại</label>

                        <div class="col-md-6">
                            <input id="SDT" type="text" class="form-control" name="SDT" value="{{$item->SDT}}">
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