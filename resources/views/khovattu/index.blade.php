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
            <form action="{{route('searchKVT')}}" method="post">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã Kho Vật Tư</th>
                <th>Tên Kho</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Thủ kho</th>
                <th>Ghi chú</th>
                <th>
                    <form action="{{route('khovattu.create')}}">
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
                    <td>{{$item->MaKVT}}</td>
                    <td>{{$item->TenKVT}}</td>
                    <td>{{$item->DiaChi}}</td>
                    <td>{{$item->SDT}}</td>
                    <td>{{$item->ThuKho}}</td>
                    <td>{{$item->GhiChu}}</td>
                    <td>
                        <a class="btn btn-comment fa fa-edit" href="{{route('khovattu.edit',$item->MaKVT)}}"></a>
                        <form class="delete-form" action="{{ route('khovattu.destroy',$item->MaKVT) }}" method="post">
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger fa fa-remove before-post"></button>
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