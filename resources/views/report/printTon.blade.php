<table class="print-ton" >
    <tr  class="company-infor">
        <td>
            CÔNG TY TNHH KỸ THUẬT XÂY DỰNG E-POWER<br>
            Tầng 12, tháp B, tòa nhà Sông Đà, Phạm Hùng, Mỹ Đình I, Nam Từ Liêm<br>
            Tel: +84 24.626.027.61 - Fax: +84 24.321.235.60
        </td>
    </tr>
    <tr >
        <td class=" text-uppercase">
            <h1 style="margin-top:30px;margin-bottom: 0;text-align: center;">
                BÁO CÁO TỒN KHO
            </h1>
        </td>
    </tr>
    <tr class="khung-header" style="text-align: center">
        <td style="width: 100px;"><p>STT</p></td>
        <td>TÊN KHO VẬT TƯ</td>
        <td>TÊN VẬT TƯ</td>
        <td>MÃ VẬT TƯ</td>
        <td>Đơn vị tính</td>
        <td>Số lượng tồn</td>
        <td>Giá trị vật tư</td>
    </tr>
    <?php $sumSLT = 0; $sumSLH =0; $sumTSL = 0; $sumTT = 0;?>
    @foreach($result as $item)
        {{$sumSLT = $sumSLT + $item->SoLuongTon}}
        {{$sumTT = $sumTT + $item->DonGia*$item->SoLuongTon}}
        <tr class="khung" style="text-align: right">
            <td><p>{{$i++}}</p></td>
            <td>{{$item->TenKVT}}</td>
            <td>{{$item->TenVT}}</td>
            <td>{{$item->MaVT}}</td>
            <td>{{$item->DVT}}</td>
            <td>{{$item->SoLuongTon}}</td>
            <td>{{$item->DonGia*$item->SoLuongTon}}</td>
        </tr>
    @endforeach
    <tr class="khung-header">
        <td style="text-align: center">Tổng cộng</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{$sumSLT}}</td>
        <td>{{$sumTT}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><span id="date" style="text-align: center;display: block;margin-bottom:30px">Ngày: 18/06/2018</span></td>
    </tr>
    <tr>
        <td style="text-align: center;">Người lập phiếu</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: center;">Thủ kho</td>
    </tr>
    <tr>
        <td style="text-align: center;">(Ký, họ tên)</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: center;">(Ký, họ tên)</td>
    </tr>
</table>

