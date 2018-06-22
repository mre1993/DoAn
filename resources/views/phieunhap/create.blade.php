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
            <div class="card-header">{{ __('Nhập vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('phieunhap.store') }}" name="create">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="TenNV" class="col-form-label">Nhân viên: {{$nhanVien->TenNV}}</label>
                            <input type="hidden" name="MaNV" value="{{$nhanVien->MaNV}}">
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <select style="height: 100%;"  name="MaKVT" class="form-control">
                                <option value="" disabled selected>Chọn kho lưu vật tư</option>
                                @foreach($MaKVT as $item)
                                    <option value="{{ $item->MaKVT }}" {{ old('MaKVT') == $item->MaKVT ? 'selected' : '' }}> {{ $item->TenKVT }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" placeholder="Nhập mã phiếu nhập" class="form-control" name="MaPN" value="{{old('MaPN')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                                <label for="TimVT" class="col-md-12" style="padding:0">Tìm kiếm vật tư</label>
                                <div class="col-md-10" style="padding: 0">
                                    <input type="text" placeholder="Nhập để tìm" name="TimVT" class="form-control search-query">
                                    <div class="suggest-search"></div>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-primary fa fa-plus new-vt"  data-toggle="modal" data-target="#new-vt" type="button"></button>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <label for="MaNCC">Chọn nhà cung cấp</label>
                            <select name="MaNCC" class="form-control col-md-10" id="MaNCC" style="height: 34px">
                                <option value="" selected disabled >Chọn nhà cung cấp</option>
                                @foreach($MaNCC as $item)
                                    <option value="{{ $item->MaNCC }}" {{ old('MaNCC') == $item->MaNCC ? 'selected' : '' }}> {{ $item->TenNCC }}</option>
                                @endforeach
                            </select>
                            <div class="col-md-1">
                                <button class="btn btn-primary fa fa-plus newNCC" type="button" data-toggle="modal" data-target="#newNCC"></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="NoiDung" class="col-form-label">Nội dung</label>
                            <textarea id="NoiDung" name="NoiDung" class="form-control" placeholder>{{old('NoiDung')}}</textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table table-striped table-PN">
                                <thead>
                                <tr>
                                    <th>Vật tư</th>
                                    <th>Đơn vị tính</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="inputVT">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-7 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Thêm mới') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newNCC" role="dialog">
        <div class="modal-dialog  modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm mới nhà cung cấp</h4>
                </div>
                <div class="modal-body">
                    <form class="form-new-NCC">
                        <div class="form-group row">
                            <label for="MaNCCNew" class="col-md-4 col-form-label text-md-right">Mã nhà cung cấp<span class="color-red">*</span></label>
                            <div class="col-md-6">
                                <input id="MaNCCNew" type="text" class="form-control" name="MaNCCNew" value="{{old('MaNCCNew')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TenNCCNew" class="col-md-4 col-form-label text-md-right">Tên nhà cung cấp<span class="color-red">*</span></label>

                            <div class="col-md-6">
                                <input id="TenNCCNew" type="text" class="form-control" name="TenNCCNew" value="{{old('TenNCCNew')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="DiaChi" class="col-md-4 col-form-label text-md-right">Địa chỉ nhà cung cấp<span class="color-red">*</span></label>

                            <div class="col-md-6">
                                <input id="DiaChi" type="text" class="form-control" name="DiaChi" value="{{old('DiaChi')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sdtNCC" class="col-md-4 col-form-label text-md-right">Số điện thoại<span class="color-red">*</span></label>

                            <div class="col-md-6">
                                <input id="sdtNCC" type="text" class="form-control" name="sdtNCC" value="{{old('sdtNCC')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fax" class="col-md-4 col-form-label text-md-right">Fax</label>

                            <div class="col-md-6">
                                <input id="fax" type="text" class="form-control" name="fax" value="{{old('fax')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emailNCC" class="col-md-4 col-form-label text-md-right">Email<span class="color-red">*</span></label>

                            <div class="col-md-6">
                                <input id="emailNCC" type="email" class="form-control" name="emailNCC" value="{{old('emailNCC')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ghiChu" class="col-md-4 col-form-label text-md-right">Ghi chú</label>

                            <div class="col-md-6">
                                <textarea id="ghiChu" class="form-control" name="ghiChu">{{old('ghiChu')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="button" class="btn btn-primary" id="saveNCC" >{{ __('Save') }}</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-vt" role="dialog">
        <div class="modal-dialog  modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm mới vật tư</h4>
                </div>
                <div class="modal-body">
                    <div class="error-vt" style="display: none">
                        <h5 class="color-red" style="margin-top: 0;display: none">Bạn phải chọn nhà cung cấp trước</h5>
                    </div>
                    <form class="form">
                        @csrf
                        <div class="form-group row">
                            <label for="MaVTNew" class="col-md-4 col-form-label text-md-right">Mã vật tư<span class="color-red">*</span></label>

                            <div class="col-md-6">
                                <input id="MaVTNew" type="text" class="form-control" name="MaVTNew">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="TenVT" class="col-md-4 col-form-label text-md-right">Tên vật tư<span class="color-red">*</span></label>

                            <div class="col-md-6">
                                <input id="TenVT" type="text" class="form-control" name="TenVT" >
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
                            <label for="DonGiaMoi" class="col-md-4 col-form-label text-md-right">Đơn giá</label>
                            <div class="col-md-6">
                                <input id="DonGiaMoi" type="text" class="form-control" name="DonGiaMoi" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="MoTaMoi" class="col-md-4 col-form-label text-md-right">Mô tả</label>

                            <div class="col-md-6">
                                <textarea id="MoTaMoi" class="form-control" name="MoTaMoi"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="button" class="btn btn-primary" id="saveVT" >{{ __('Save') }}</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop