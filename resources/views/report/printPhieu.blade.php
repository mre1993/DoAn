<table class="table print-phieu-nhap" width="100%">
    <tr  class="company-infor">
        <td colspan="5">
            CÔNG TY TNHH KỸ THUẬT XÂY DỰNG E-POWER<br>
            Tầng 12, tháp B, tòa nhà Sông Đà, Phạm Hùng, Mỹ Đình I, Nam Từ Liêm<br>
            Tel: +84 24.626.027.61 - Fax: +84 24.321.235.60
        </td>
    </tr>
    <tr >
        <td colspan="12" class=" text-uppercase">
            <h1 style="margin-top:30px;margin-bottom: 0;text-align: center;">
                @if($check == 'PhieuNhap')
                    BÁO CÁO PHIẾU NHẬP
                @else
                    BÁO CÁO PHIẾU XUẤT
                @endif
            </h1>
            <span id="date" style="text-align: center;display: block;margin-bottom:30px"></span>
        </td>
    </tr>
    <tr class="khung-header" style="text-align: center;">
        <td>STT</td>
        <td>
            @if($check == 'PhieuNhap')
                Mã phiếu nhập
            @else
                Mã phiếu xuất
            @endif
        </td>
        <td>MÃ VẬT TƯ</td>
        <td>TÊN VẬT TƯ</td>
        <td>Tên phân xưởng</td>
        <td>
            @if($check == 'PhieuNhap')
                Tên nhà cung cấp
            @else
                Tên kho
            @endif
        </td>
        <td>SỐ LƯỢNG</td>
        <td>Đơn giá</td>
        <td>Thành tiền</td>
        <td>GHI CHÚ</td>
        <td>Ngày nhập</td>
        <td>Nhân viên</td>
    </tr>
    @foreach($result as $item)
    <tr style="text-align: center">
        <td> {{$i++}} </td>
        <td>
            @if($check == 'PhieuNhap')
                {{$item->MaPN}}
            @else
                {{$item->MaPhieuXuat}}
            @endif
        </td>
        <td> {{$item->MaVT}} </td>
        <td> {{$item->TenVT}} </td>
        <td> {{$item->TenKVT}} </td>
        <td>
            @if($check == 'PhieuNhap')
                {{$item->TenNCC}}
            @else
                {{$item->TenPX}}
            @endif
        <td> {{$item->SoLuong}} </td>
        <td> {{$item->DonGia}} </td>
        <td> {{$item->ThanhTien}} </td>
        <td> {{$item->NoiDung}} </td>
        <td> {{Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}} </td>
        <td> {{$item->TenNV}} </td>
    </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: center">Người lập</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: center">{{\Illuminate\Support\Facades\Auth::user()->NhanVien->TenNV}}</td>
        <td></td>
    </tr>
</table>
<script>
    var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');

    document.getElementById("date").innerHTML  = utc;
</script>
