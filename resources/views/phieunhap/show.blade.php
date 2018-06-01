@extends('home')
@section('right-content')
    <div class="col-md-10 form-nhap">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <fieldset class="infor-phieu-nhap">
            <legend class="scheduler-border">Phiếu nhập</legend>
            <div class="col-md-6">
                <label for="MaNV" class="col-md-4 col-form-label">Nhân viên</label>
                <input id="MaNV" name="MaNV" class="form-control col-md-8" readonly value="{{$phieuNhap->NhanVien->TenNV}}">
            </div>
            <div class="col-md-6">
                <label for="MaPN" class="col-md-4 col-form-label">Mã phiếu nhập</label>
                <input id="MaPN" name="MaPN" class="form-control col-md-8" readonly value="{{$phieuNhap->MaPN}}">
            </div>
            <div class="col-md-6">
                <label for="MaKVT" class="col-md-4 col-form-label">Kho Vật Tư</label>
                <input id="MaKVT" name="MaKVT" class="form-control col-md-8" readonly value="{{$phieuNhap->KhoVatTu->TenKVT}}">
            </div>
            <div class="col-md-6">
                <label for="MaNCC" class="col-md-4 col-form-label">Nhà cung cấp</label>
                <input id="MaNCC" name="MaNCC" class="form-control col-md-8" readonly value="{{$phieuNhap->NhaCungCap->TenNCC}}">
            </div>
            <div class="col-md-6">
                <label for="NoiDung" class="col-md-4 col-form-label">Nội dung</label>
                <textarea id="NoiDung" name="NoiDung" class="form-control col-md-8" readonly>{{$phieuNhap->NoiDung}}</textarea>
            </div>
            <div class="col-md-6">
                <label for="time" class="col-md-4 col-form-label">Ngày nhập</label>
                <input id="time" name="time" class="form-control col-md-8" readonly value="{{$phieuNhap->created_at->format('d-m-Y')}}">
            </div>
        </fieldset>
        <fieldset class="chi-tiet">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Vật tư</td>
                        <td>Số lượng</td>
                        <td>Đơn giá</td>
                        <td>Thành tiền</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($chiTiet as $item)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$item->VatTu->TenVT}}</td>
                        <td>{{$item->SoLuong}}</td>
                        <td>{{$item->DonGia}}</td>
                        <td>{{$item->ThanhTien}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </fieldset>
        <div class="col-md-12 text-center">
            <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-back">Quay lại</a>
            <a class="btn btn-success fa fa-print" style="padding: 10px" href="{{route('phieunhap.showExport',$item->MaPN)}}"></a>
        </div>
    </div>
@endsection