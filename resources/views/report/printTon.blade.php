<style>
    table{
        border-collapse: collapse;
    }
    .print-ton .khung-header td{
        border: 1px solid black;
    }
</style>
<table class="print-ton" width="70%" style="margin: auto">
    <tr  class="company-infor">
        <td colspan="5">
            CÔNG TY TNHH KỸ THUẬT XÂY DỰNG E-POWER<br>
            Tầng 12, tháp B, tòa nhà Sông Đà, Phạm Hùng, Mỹ Đình I, Nam Từ Liêm<br>
            Tel: +84 24.626.027.61 - Fax: +84 24.321.235.60
        </td>
    </tr>
    <tr >
        <td colspan="9" class=" text-uppercase">
            <h1 style="margin-top:30px;margin-bottom: 0;text-align: center;">
                BÁO CÁO TỒN KHO
            </h1>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            <span id="date" style="text-align: center;display: block;margin-bottom:30px">Ngày: 18/06/2018</span>
        </td>
    </tr>
    <tr>
        <td  colspan="9" class="">
            <h3 style="text-align: center;display: block;margin-bottom:30px">Kho vật tư: Kho 1</h3>
        </td>
    </tr>
    <tr class="khung-header border border-dark" style="text-align: center;">
        <td>STT</td>
        <td>MÃ VẬT TƯ</td>
        <td>TÊN VẬT TƯ</td>
        <td>Đơn vị tính</td>
        <td>Đơn giá</td>
        <td>Số lượng tồn</td>
        <td>Số lượng hỏng</td>
        <td>Tổng số lượng</td>
        <td>Tổng giá trị tồn</td>
    </tr>
    <?php $sumSLT = 0; $sumSLH =0; $sumTSL = 0; $sumTT = 0;?>
    @foreach($result as $item)
        {{$sumSLT = $sumSLT + $item->SoLuongTon}}
        {{$sumSLH = $sumSLH + $item->SoLuongHong}}
        {{$sumTSL = $sumTSL + $item->TongSoLuong}}
        {{$sumTT = $sumTT + array_sum([$item->DonGia,$item->SoLuongTon])}}
        <tr class="khung-header">
            <td>{{$i++}}</td>
            <td>{{$item->MaVT}}</td>
            <td>{{$item->TenVT}}</td>
            <td>{{$item->DVT}}</td>
            <td>{{$item->DonGia}}</td>
            <td>{{$item->SoLuongTon}}</td>
            <td>{{$item->SoLuongHong}}</td>
            <td>{{$item->TongSoLuong}}</td>
            <td>{{array_sum([$item->DonGia,$item->SoLuongTon])}}</td>
        </tr>
    @endforeach
    <tr class="khung-header">
        <td colspan="5" style="text-align: center">Tổng cộng</td>
        <td>{{$sumSLT}}</td>
        <td>{{$sumSLH}}</td>
        <td>{{$sumTSL}}</td>
        <td>{{$sumTT}}</td>
    </tr>
    <tr></tr>
    <tr >
        <td colspan="5" style="text-align: center;padding-top: 30px">Người lập phiếu</td>
        <td colspan="4" style="text-align: center;padding-top: 30px">Thủ kho</td>
    </tr>
</table>

