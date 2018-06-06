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
        <table class="table table-striped">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã phiếu nhập</th>
                <th>Nhân viên</th>
                <th>Phân xưởng</th>
                <th>Nhà cung cấp</th>
                <th>Nội dung</th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->MaPN}}</td>
                    <td>{{$item->NhanVien->TenNV}}</td>
                    <td>{{$item->PhanXuong->TenPX}}</td>
                    <td>{{$item->NhaCungCap->TenNCC}}</td>
                    <td>{{$item->NoiDung}}</td>
                    <td>
                        <a class="btn fa fa-eye" href="{{route('phieunhap.show',$item->MaPN)}}" style="background-color: blue;color: white"></a>
                        {{--<a class="btn btn-comment fa fa-edit" href="{{route('phieunhap.edit',$item->MaPN)}}"></a>--}}
                        <form class="delete-form" action="{{ route('phieunhap.destroy',$item->MaPN) }}" method="post">
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