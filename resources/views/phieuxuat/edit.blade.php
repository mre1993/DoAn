
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
                <form method="POST" action="{{ route('phieuxuat.update',$phieuXuat->MaPhieuXuat) }}">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="TenNV" class="col-form-label">Nhân viên: {{$phieuXuat->NhanVien->TenNV}}</label>
                            <input type="hidden" name="MaNV" value="{{$phieuXuat->MaNV}}">
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <select style="height: 100%;" name="MaKVT" class="form-control">
                                <option value="" disabled selected>Chọn kho lưu vật tư</option>
                                @foreach($MaKVT as $item)
                                    <option value="{{ $item->MaKVT }}" {{ $phieuXuat->MaKVT == $item->MaKVT ? 'selected' : '' }}> {{ $item->TenKVT }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="MaPhieuXuat" readonly value="{{$phieuXuat->MaPhieuXuat}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="TimVT" class="col-md-12" style="padding:0">Tìm kiếm vật tư</label>
                            <div class="col-md-10" style="padding: 0">
                                <input type="text" placeholder="Nhập để tìm" name="TimVT" class="form-control search-query">
                                <div class="suggest-search"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="MaPX">Chọn phân xưởng</label>
                            <select name="MaPX" class="form-control col-md-10" id="MaPX" style="height: 34px">
                                <option value="" selected disabled >Chọn phân xưởng</option>
                                @foreach($MaPX as $item)
                                    <option value="{{ $item->MaPX }}" {{ $phieuXuat->MaPX == $item->MaPX ? 'selected' : '' }}> {{ $item->TenPX }}</option>
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
                            <textarea id="NoiDung" name="NoiDung" class="form-control" placeholder>{{$phieuXuat->NoiDung}}</textarea>
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

                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="inputVT">
                                @foreach($values as $value)
                                    <tr class="input-record" >
                                        <td class="TenVT">{{$value->VatTu->TenVT}}<input type="hidden" name="MaVT[]" value="{{$value->MaVT}}"></td>
                                        <td><input type="text" readonly class="form-control" name="DVT[]" value="{{$value->VatTu->DVT}}"></td>
                                        <td><input name="SoLuong[]" type="number" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" onchange="return  myFunction(this)" min="0" value="{{number_format($value->SoLuong, 0, ',', '.')}}"></td>
                                        <td><input name="DonGia[]" onchange="return  myFunction2(this)"  type="hidden" value="{{number_format($value->VatTu->DonGia, 0, ',', '.')}}" class="form-control"></td>
                                        <td><input type="hidden" readonly class="form-control" name="ThanhTien[]" value="{{number_format($value->ThanhTien, 0, ',', '.')}}"></td>
                                        <td><button type="button" class="btn btn-danger remove-record" onclick="return remove(this)">Delete</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-7 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Sửa') }}
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
                    <h4 class="modal-title">Thêm mới phân xưởng</h4>
                </div>
                <div class="modal-body">
                    <form class="form-new-NCC">
                        <div class="form-group row">
                            <label for="MaPXNew" class="col-md-4 col-form-label text-md-right">Mã phân xưởng<span class="color-red">*</span></label>
                            <div class="col-md-6">
                                <input id="MaPXNew" type="text" class="form-control" name="MaPXNew" value="{{old('MaPXNew')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TenNCCNew" class="col-md-4 col-form-label text-md-right">Tên phân xưởng<span class="color-red">*</span></label>

                            <div class="col-md-6">
                                <input id="TenNCCNew" type="text" class="form-control" name="TenNCCNew" value="{{old('TenNCCNew')}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="DiaChi" class="col-md-4 col-form-label text-md-right">Địa chỉ phân xưởng<span class="color-red">*</span></label>

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
@stop
