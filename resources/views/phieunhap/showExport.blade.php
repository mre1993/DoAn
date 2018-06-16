{{--@extends('home')--}}
{{--@section('right-content')--}}
<div class="col-md-12">
    <form action="{{route('phieunhap.printExcel',$phieuNhap->MaPN)}}" method="get">
        <button class="print btn btn-primary fa fa-print"></button>
    </form>
</div>
 <div class="form-nhap">
        <table class="table print-phieu-nhap">
            <tr  class="company-infor">
                <td rowspan="2"></td>
                <td ><p>
                    CÔNG TY TNHH KỸ THUẬT XÂY DỰNG E-POWER<br>
                    Tầng 12, tháp B, tòa nhà Sông Đà, Phạm Hùng, Mỹ Đình I, Nam Từ Liêm<br>
                    Tel: +84 24.626.027.61 - Fax: +84 24.321.235.60</p>
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
                <td colspan="4"><p class="text-center text-uppercase form-name">PHIẾU NHẬP VẬT TƯ</p></td>
                <td colspan="2" style="padding-top: 25px"><p>Mã phiếu: {{$phieuNhap->MaPN}}</p></td>
            </tr>
            <tr>
                <td colspan="8"><p>Người nhập: {{$phieuNhap->NhanVien->TenNV}}</p></td>
            </tr>
            <tr>
                <td colspan="8"><p>Lý do nhập: {{$phieuNhap->NoiDung}}</p></td>
            </tr>
            <tr>
                <td colspan="7" style="border: none">
                    <p>Nhập tại kho: {{$phieuNhap->KhoVatTu->TenKVT}}, <span>Địa chỉ: {{$phieuNhap->KhoVatTu->DiaChi}}</span></p>
                </td>
            </tr>
            <tr class="khung-header">
                <td><p>STT</p></td>
                <td><p>TÊN VẬT TƯ</p></td>
                <td><p>MÃ VẬT TƯ</p></td>
                <td><p>ĐVT</p></td>
                <td><p>Đơn giá</p></td>
                <td><p>SỐ LƯỢNG</p></td>
                <td><p>Thành tiền</p></td>
                <td><p>GHI CHÚ</p></td>
            </tr>
           @foreach($vatTu as $item)
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
                <td><p>Phê duyệt</p></td>
                <td class="width-14"><p></p></td>
                <td class="width-18" colspan="2"><p>Thủ kho</p></td>
                <td><p>KCS</p></td>
                <td><p></p></td>
                <td><p>Bảo vệ</p></td>
                <td style="border:none"><p></p></td>
            </tr>
        </table>
    </div>