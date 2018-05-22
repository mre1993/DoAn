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
                <th>Mã loại vật tư</th>
                <th>Tên loại</th>
                <th>
                    <form action="{{route('theloai.create')}}">
                        <button class="btn btn-success fa fa-plus-circle" ></button>
                    </form>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->MaPX}}</td>
                    <td>{{$item->TenPX}}</td>
                    <td>{{$item->GhiChu}}</td>
                    <td>
                        <a class="btn btn-comment fa fa-edit" href="{{route('theloai.edit',$item->id)}}"></a>
                        <form class="delete-form" action="{{ route('theloai.destroy',$item->id) }}" method="post">
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