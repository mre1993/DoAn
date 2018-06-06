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
        <table class="table table-striped">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã Vật tư</th>
                <th>Tên vật tư</th>
                <th>Đơn vị tính</th>
                <th>Nhà cung cấp</th>
                <th>Đơn giá</th>
                <th>Mô tả</th>
                <th>
                    <form action="{{route('vattu.create')}}">
                        <button class="btn btn-success fa fa-plus-circle" ></button>
                    </form>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->MaVT}}</td>
                    <td>{{$item->TenVT}}</td>
                    <td>{{$item->DVT}}</td>
                    <td>{{$item->NhaCungCap->TenNCC}}</td>
                    <td>{{$item->DonGia}}</td>
                    <td>{{$item->MoTa}}</td>
                    <td>
                        <a class="btn btn-comment fa fa-edit" href="{{route('vattu.edit',$item->MaVT)}}"></a>
                        <form class="delete-form" action="{{ route('vattu.destroy',$item->MaVT) }}" method="post">
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger fa fa-remove"></button>
                            {{ csrf_field() }}
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop