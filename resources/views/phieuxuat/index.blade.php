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
            <form action="{{route('searchPhieuXuat')}}" method="POST">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã phiếu xuất</th>
                <th>Nhân viên</th>
                <th>Kho vật tư</th>
                <th>Phân xưởng</th>
                <th>Ngày xuất</th>
                <th>Nội dung</th>
                <th>
                    <form action="{{route('phieuxuat.create')}}">
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
                    <td>{{$item->MaPhieuXuat}}</td>
                    <td>{{$item->NhanVien->TenNV}}</td>
                    <td>{{$item->KhoVatTu->TenKVT}}</td>
                    <td>{{$item->PhanXuong->TenPX}}</td>
                    <td>{{$item->created_at->format('d-m-Y')}}</td>
                    <td>{{$item->NoiDung}}</td>
                    <td>
                        <a class="btn fa fa-eye" href="{{route('phieuxuat.show',$item->MaPhieuXuat)}}" style="background-color: blue;color: white"></a>
                        <a class="btn btn-comment fa fa-edit" href="{{route('phieuxuat.edit',$item->MaPhieuXuat)}}"></a>
                        <form class="delete-form" action="{{ route('phieuxuat.destroy',$item->MaPhieuXuat) }}" method="post">
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger fa fa-remove"></button>
                            {{ csrf_field() }}
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">{{ $items->links() }}</div>
    </div>
@stop