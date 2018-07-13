{{--@extends('home')--}}
{{--@section('right-content')--}}
 <div class="form-nhap">
        <table class="table print-phieu-nhap">
            <tr  class="company-infor">
                <td style="text-align: center"  valign="top">
                    CÔNG TY TNHH KỸ THUẬT XÂY DỰNG E-POWER<br>
                    Tầng 12, tháp B, tòa nhà Sông Đà, Phạm Hùng, Mỹ Đình I, Nam Từ Liêm<br>
                    Tel: +84 24.626.027.61 - Fax: +84 24.321.235.60
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4"><p class="text-uppercase form-name" style="text-align: center">PHIẾU XUẤT VẬT TƯ</p></td>
                <td colspan="2" style="padding-top: 25px"><p>Mã phiếu: {{str_replace('_','/',$phieuXuat->MaPhieuXuat)}}</p></td>
            </tr>
            <tr>
                <td colspan="7" valign="middle"><p>Người nhập: {{$phieuXuat->NhanVien->TenNV}}</p></td>
            </tr>
            <tr>
                <td colspan="7" valign="middle"><p>Lý do nhập: {{$phieuXuat->NoiDung}}</p></td>
            </tr>
            <tr>
                <td colspan="7" style="border: none"  valign="middle">
                    <p>Xuất tại kho: {{$phieuXuat->KhoVatTu->TenKVT}}</p>
                </td>
            </tr>
            <tr class="khung-header" style="text-align: center">
                <td><p>STT</p></td>
                <td><p>TÊN VẬT TƯ</p></td>
                <td><p>MÃ VẬT TƯ</p></td>
                <td><p>ĐVT</p></td>
                <td><p>SỐ LƯỢNG</p></td>
                <td><p>Thành tiền</p></td>
                <td><p>GHI CHÚ</p></td>
            </tr>
           @foreach($vatTu as $item)
                <tr class="khung" style="text-align: right">
                    <td><p>{{$i++}}</p></td>
                    <td><p>{{$item->MaVT}}</p></td>
                    <td><p>{{$item->VatTu->TenVT}}</p></td>
                    <td><p>{{$item->VatTu->DVT}}</p></td>
                    <td><p>{{$item->SoLuong}}</p></td>
                    <td><p>{{$item->ThanhTien}}</p></td>
                    <td><p>{{$item->GhiChu}}</p></td>
                </tr>
           @endforeach
            <tr class="khung" style="text-align: right">
                <td colspan="5"><p class="text-center">Tổng</p></td>
                <td><p style="text-align: center">{{$sumTT}}</p></td>
                <td><p></p></td>
            </tr>
            <tr>
                <td><p></p></td>
                <td><p></p></td>
                <td><p></p></td>
                <td colspan="4"><p class="text-center">Ngày {{date('d')}} tháng {{date('m')}} năm {{date('Y')}}</p></td>
            </tr>
            <tr class="bottom-form text-center">
                <td class="width-18" colspan="2"><p>Người lập phiếu</p></td>
                <td colspan="2"><p>Người giao</p></td>
                <td colspan="2"><p>Thủ kho</p></td>
            </tr>
        </table>
    </div>