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
        <fieldset class="col-md-12 infor-phieu-nhap">
            <legend class="scheduler-border">Phiếu xuất</legend>
            <div class="col-md-6">
                <label for="MaNV" class="col-md-4 col-form-label">Nhân viên</label>
                <input id="MaNV" name="MaNV" class="form-control col-md-8" readonly value="{{$phieuXuat->NhanVien->TenNV}}">
            </div>
            <div class="col-md-6">
                <label for="MaPhieuXuat" class="col-md-4 col-form-label">Mã phiếu xuất</label>
                <input id="MaPhieuXuat" name="MaPhieuXuat" class="form-control col-md-8" readonly value="{{$phieuXuat->MaPhieuXuat}}">
            </div>
            <div class="col-md-6">
                <label for="MaPX" class="col-md-4 col-form-label">Phân xưởng</label>
                <input id="MaPX" name="MaPX" class="form-control col-md-8" readonly value="{{$phieuXuat->PhanXuong->TenPX}}">
            </div>
            <div class="col-md-6">
                <label for="MaKVT" class="col-md-4 col-form-label">Kho vật tư</label>
                <input id="MaKVT" name="MaKVT" class="form-control col-md-8" readonly value="{{$phieuXuat->KhoVatTu->TenKVT}}">
            </div>
            <div class="col-md-6">
                <label for="NoiDung" class="col-md-4 col-form-label">Nội dung</label>
                <textarea id="NoiDung" name="NoiDung" class="form-control col-md-8" readonly>{{$phieuXuat->NoiDung}}</textarea>
            </div>
            <div class="col-md-6">
                <label for="time" class="col-md-4 col-form-label">Ngày xuất</label>
                <input id="time" name="time" class="form-control col-md-8" readonly value="{{$phieuXuat->created_at->format('d-m-Y')}}">
            </div>
        </fieldset>
        {{--<fieldset class="col-md-12 chi-tiet">--}}
            {{--<table class="table table-striped">--}}
                {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<td>STT</td>--}}
                        {{--<td>Vật tư</td>--}}
                        {{--<td>Số lượng</td>--}}
                        {{--<td>Đơn giá</td>--}}
                        {{--<td>Thành tiền</td>--}}
                    {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--@foreach($chiTiet as $item)--}}
                    {{--<tr>--}}
                        {{--<td>{{$i++}}</td>--}}
                        {{--<td>{{$item->VatTu->TenVT}}</td>--}}
                        {{--<td>{{$item->SoLuong}}</td>--}}
                        {{--<td>{{$item->DonGia}}</td>--}}
                        {{--<td>{{$item->ThanhTien}}</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
        {{--</fieldset>--}}
        <div class="col-md-12 show-form">
                <table class="table print-phieu-nhap">
                    <tr  class="company-infor">
                        <td colspan="8" class="text-center size-16">
                            <p class="font-weight-bold" style="font-size: 18px">CÔNG TY TNHH KỸ THUẬT XÂY DỰNG E-POWER</p>
                            <p>Tầng 12, tháp B, tòa nhà Sông Đà, Phạm Hùng, Mỹ Đình I, Nam Từ Liêm</p>
                            <p style="text-decoration: underline">Tel: +84 24.626.027.61 - Fax: +84 24.321.235.60</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="4"><p class="text-center text-uppercase form-name">PHIẾU NHẬP VẬT TƯ</p></td>
                        <td colspan="2" style="padding-top: 25px;text-align: center" class="size-16"><p>Mã phiếu: {{$phieuXuat->MaPhieuXuat}}</p></td>
                    </tr>
                    <tr>
                        <td colspan="8" class="size-16"><p>Người xuất: {{$phieuXuat->NhanVien->TenNV}}</p></td>
                    </tr>
                    <tr>
                        <td colspan="8" class="size-16"><p>Lý do xuất: {{$phieuXuat->NoiDung}}</p></td>
                    </tr>
                    <tr>
                        <td colspan="7" style="border: none" class="size-16">
                            <p>Xuất tại kho: {{$phieuXuat->PhanXuong->TenPX}}
                        </td>
                    </tr>
                    <tr class="khung-header">
                        <td width="5%"><p>STT</p></td>
                        <td width="19%"><p>MÃ VẬT TƯ</p></td>
                        <td width="19%"><p>TÊN VẬT TƯ</p></td>
                        <td width="10%"><p>ĐVT</p></td>
                        <td width="10%"><p>Đơn giá</p></td>
                        <td width="10%"><p>SỐ LƯỢNG</p></td>
                        <td width="10%"><p>Thành tiền</p></td>
                        <td><p>GHI CHÚ</p></td>
                    </tr>
                    @foreach($chiTiet as $item)
                        <tr class="khung">
                            <td><p>{{$i++}}</p></td>
                            <td><p>{{$item->MaVT}}</p></td>
                            <td><p>{{$item->VatTu->TenVT}}</p></td>
                            <td><p>{{$item->VatTu->DVT}}</p></td>
                            <td><p>{{$item->DonGia}}</p></td>
                            <td><p>{{$item->SoLuong}}</p></td>
                            <td><p>{{$item->ThanhTien}}</p></td>
                            <td><p>{{$item->GhiChu}}</p></td>
                        </tr>
                    @endforeach
                    <tr class="khung">
                        <td colspan="4"><p class="text-center">Tổng</p></td>
                        <td><p></p></td>
                        <td><p>{{$sumSL}}</p></td>
                        <td><p>{{$sumTT}}</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td colspan="4"><p class="text-center">Ngày {{date('d')}} tháng {{date('m')}} năm {{date('Y')}}</p></td>
                    </tr>
                    <tr class="bottom-form text-center">
                        <td class="width-18" colspan="3"><p>Người lập phiếu</p></td>
                        <td colspan="3"><p>Người giao</p></td>
                        <td colspan="2"><p>Thủ kho</p></td>
                    </tr>
                </table>
            </div>
        <div class="col-md-12 text-center">
                <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-back">Quay lại</a>
                <a class="btn btn-success fa fa-print" style="padding: 10px" href="{{route('phieuxuat.printExcel',$item->MaPhieuXuat)}}"></a>
            </div>
    </div>
@endsection