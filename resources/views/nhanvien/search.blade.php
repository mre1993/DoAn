@extends('home')
@section('right-content')
    <div class="factories col-md-10">
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
            <form action="{{route('searchNV')}}" method="POST">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã loại nhân viên</th>
                <th>Tên nhân viên</th>
                <th>Giới tính</th>
                <th>Chức vụ</th>
                <th>Số điện thoại</th>
                <th>
                    <form action="{{route('nhanvien.create')}}">
                        <button class="btn btn-success fa fa-plus-circle" ></button>
                    </form>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $i = ($items->currentpage() - 1) * $items->perpage() + 1 ?>
            @foreach($items as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->MaNV}}</td>
                    <td>{{$item->TenNV}}</td>
                    <td>{{$item->GioiTinh}}</td>
                    <td>{{$item->ChucVu}}</td>
                    <td>{{$item->SDT}}</td>
                    <td>
                        <a class="btn btn-comment fa fa-edit" href="{{route('nhanvien.edit',$item->MaNV)}}"></a>
                        <form class="delete-form" action="{{ route('nhanvien.destroy',$item->MaNV) }}" method="post">
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