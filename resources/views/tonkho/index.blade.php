@extends('home')
@section('right-content')
    <div class="provider col-md-10">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên vật tư</th>
                <th>Kho còn vật tư</th>
                <th>Đơn vị tính</th>
                <th>Tổng số lượng vật tư</th>
                <th>Tổng số lượng vật tư hỏng</th>
                <th>Tổng số lượng vật tư tồn</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $i = ($items->currentpage() - 1) * $items->perpage() + 1 ?>
            @foreach($items as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->TenVT}}</td>
                    <td>
                        <?php $kvt = \App\ChiTietKhoVT::where('MaVT',$item->MaVT)->where('SoLuongTon','>',0)->get()?>
                        @foreach($kvt as $value)
                            <?php $kho = \App\KhoVatTu::where('MaKVT',$value->MaKVT)->get() ?>
                            @foreach($kho as $ten)
                                {{$ten->TenKVT}},
                            @endforeach
                        @endforeach
                    </td>
                    <td>{{$item->DVT}}</td>
                    <td>{{number_format($item->SoLuongTon, 0, ',', '.')}}</td>
                    <td>{{number_format($item->SoLuongHong, 0, ',', '.')}}</td>
                    <td>{{number_format($item->TongSoLuong, 0, ',', '.')}}</td>
                    <td>
                        <form action="{{route('tonkho.edit',$item->MaVT)}}">
                            <button class="btn btn-primary fa fa-minus"></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop