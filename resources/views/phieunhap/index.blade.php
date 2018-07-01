@extends('home')
@section('right-content')
    <div class="col-md-10">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="search-container">
            <form action="{{route('searchPhieuNhap')}}" method="POST">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="5%">STT</th>
                <th width="10%">Mã phiếu nhập</th>
                <th width="10%">Nhân viên</th>
                <th width="15%">Nhà cung cấp</th>
                <th width="15%">Kho vật tư</th>
                <th width="15%">Ngày nhập</th>
                <th width="20%">Nội dung</th>
                <th>
                    <form action="{{route('phieunhap.create')}}">
                        <button class="btn btn-success fa fa-plus-circle"></button>
                    </form>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $i = ($items->currentpage() - 1) * $items->perpage() + 1 ?>
            @foreach($items as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->MaPN}}</td>
                    <td>{{$item->NhanVien->TenNV}}</td>
                    <td>{{$item->NhaCungCap->TenNCC}}</td>
                    <td>{{$item->KhoVatTu->TenKVT}}</td>
                    <td>{{$item->created_at->format('d-m-Y')}}</td>
                    <td>{{$item->NoiDung}}</td>
                    <td>
                        <a class="btn fa fa-eye" href="{{route('phieunhap.show',$item->MaPN)}}" style="background-color: blue;color: white"></a>
                        <form class="delete-form" action="{{route('phieunhap.edit',$item->MaPN)}}">
                            <button class="btn btn-comment fa fa-edit"></button>
                        </form>
                        <form class="delete-form" action="{{ route('phieunhap.destroy')}}" method="post">
                            {{ csrf_field() }}
                            <input name="MaPN" type="hidden" value="{{$item->MaPN}}">
                            <button class="btn btn-danger fa fa-remove before-post"></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">{{ $items->links() }}</div>
    </div>
@stop