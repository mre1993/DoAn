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
        <table class="table">
            <tr  class="company-infor">
                <td colspan="1" rowspan="2"><img src="{{asset('img/epower.png')}}"></td>
                <td colspan="5" rowspan="2" class="text-center">
                    <p>"CÔNG TY TNHH KỸ THUẬT XÂY DỰNG E-POWER</p>
                    <p>Tầng 12, tháp B, tòa nhà Sông Đà, Phạm Hùng, Mỹ Đình I, Nam Từ Liêm</p>
                    <p>Tel: +84 24.626.027.61 - Fax: +84 24.321.235.60"</p>
                </td>
                <td>
                    <p>Ngày:{{date('d/m/Y')}}</p>
                </td>
            </tr>
            <tr class="company-infor">
                <td style="padding: 5px">
                    <p>BM.01B-QT.EP.32</p>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="3"><p class="text-center text-uppercase form-name">PHIẾU NHẬP KHO</p></td>
                <td colspan="2" style="padding-top: 25px"><p>Mã phiếu: {{$phieuNhap->MaPN}}</p></td>
            </tr>
            <tr>
                <td colspan="7"><p>Người nhập: {{$phieuNhap->NhanVien->TenNV}}</p></td>
            </tr>
            <tr>
                <td colspan="7"><p>Lý do nhập: {{$phieuNhap->NoiDung}}</p></td>
            </tr>
            <tr>
                <td colspan="7" style="border: none">
                    <p>Nhập tại kho: {{$phieuNhap->KhoVatTu->TenKVT}}, <span>Địa chỉ: {{$phieuNhap->KhoVatTu->DiaChi}}</span></p>
                </td>
            </tr>
            <tr class="khung-header">
                <td><p>STT</p></td>
                <td colspan="2"><p>TÊN VẬT TƯ</p></td>
                <td><p>MÃ VẬT TƯ</p></td>
                <td><p>ĐVT</p></td>
                <td><p>SỐ LƯỢNG</p></td>
                <td><p>GHI CHÚ</p></td>
            </tr>
           @foreach($vatTu as $item)
                <tr class="khung">
                    <td><p>{{$i++}}</p></td>
                    <td colspan="2"><p>{{$item->MaVT}}</p></td>
                    <td><p>{{$item->VatTu->TenVT}}</p></td>
                    <td><p>{{$item->VatTu->DVT}}</p></td>
                    <td><p>{{$item->SoLuong}}</p></td>
                    <td><p>{{$item->GhiChu}}</p></td>
                </tr>
           @endforeach
            <tr class="khung">
                <td colspan="5"><p class="text-center">Tổng</p></td>
                <td><p>{{$sumSL}}</p></td>
                <td><p></p></td>
            </tr>
            <tr>
                <td><p></p></td>
                <td><p></p></td>
                <td><p></p></td>
                <td><p></p></td>
                <td colspan="3"><p class="text-center">Ngày {{date('d')}} tháng {{date('m')}} năm {{date('Y')}}</p></td>
            </tr>
            <tr class="bottom-form text-center">
                <td><p>Phê duyệt</p></td>
                <td class="width-14"><p></p></td>
                <td class="width-18"><p>Thủ kho</p></td>
                <td><p>KCS</p></td>
                <td><p></p></td>
                <td><p>Bảo vệ</p></td>
                <td><p></p></td>
            </tr>
        </table>
    </div>
@endsection