<div class="form-nhap">
    <table class="table text-center">
        <thead>
        <tr>
            <th>STT</th>
            <th>Mã phiếu nhập</th>
            <th>Mã vật tư</th>
            <th>Tên vật tư</th>
            <th>Phân xưởng</th>
            <th>Nhà cung cấp</th>
            <th>Số lượng</th>
            <th>Đơn Giá</th>
            <th>Thành Tiền</th>
            <th>Ghi chú</th>
            <th>Ngày tạo</th>
            <th>Nhân viên</th>
            </tr>
        </thead>
        <tbody class="export-content">
            @foreach($result as $item)
                <tr>
                    <td></td>
                    <td> {{$item->MaPN}} </td>
                    <td> {{$item->MaVT}} </td>
                    <td> {{$item->TenVT}} </td>
                    <td> {{$item->TenPX}} </td>
                    <td> {{$item->TenNCC}} </td>
                    <td> {{$item->SoLuong}} </td>
                    <td> {{$item->DonGia}} </td>
                    <td> {{$item->ThanhTien}} </td>
                    <td> {{$item->NoiDung}} </td>
                    <td> {{Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}} </td>
                    <td> {{$item->TenNV}} </td>
                </tr>
            @endforeach
        </tbody>
        </table>
</div>