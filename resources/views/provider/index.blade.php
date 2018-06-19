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
        <div class="search-container">
            <form action="{{route('searchNCC')}}" method="POST">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã NCC</th>
                <th>Nhà cung cấp</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Fax</th>
                <th>Email</th>
                <th>Ghi chú</th>
                <th style="padding-top: 0px; padding-bottom: 5px;">
                    <form action="{{route('provider.create')}}">
                        <button class="btn btn-success fa fa-plus-circle" style=""></button>
                    </form>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $i = ($items->currentpage() - 1) * $items->perpage() + 1 ?>
                @foreach($items as $item)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$item->MaNCC}}</td>
                        <td>{{$item->TenNCC}}</td>
                        <td>{{$item->DiaChi}}</td>
                        <td>{{$item->SDT}}</td>
                        <td>{{$item->Fax}}</td>
                        <td>{{$item->Email}}</td>
                        <td>{{$item->GhiChu}}</td>
                        <td>
                            <a class="btn btn-comment fa fa-edit" href="{{route('provider.edit',$item->MaNCC)}}"></a>
                            <form class="delete-form" action="{{ route('provider.destroy',$item->MaNCC) }}" method="post">
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