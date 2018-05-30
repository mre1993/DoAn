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
                <th>Mã phiếu nhập</th>
                <th>Nhân viên</th>
                <th>Kho vật tư</th>
                <th>Nhà cung cấp</th>
                <th>Nội dung</th>
                <th>
                    <form action="{{route('phieunhap.create')}}">
                        <button class="btn btn-success fa fa-plus-circle" ></button>
                    </form>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->MaPN}}</td>
                    <td>{{$item->NhanVien->TenNV}}</td>
                    <td>{{$item->KhoVatTu->TenKVT}}</td>
                    <td>{{$item->NhaCungCap->TenNCC}}</td>
                    <td>{{$item->NoiDung}}</td>
                    <td>
                        <a class="btn btn-comment fa fa-shower" href="{{route('phieunhap.show',$item->MaNV)}}"></a>
                        <a class="btn btn-comment fa fa-edit" href="{{route('phieunhap.edit',$item->MaNV)}}"></a>
                        <form class="delete-form" action="{{ route('phieunhap.destroy',$item->MaNV) }}" method="post">
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