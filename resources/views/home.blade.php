@extends('layouts.app')
@section('content')
<div id="sidebar" class="col-md-2">
    <ul>
        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a> </li>
        <li> <a href="{{route('user.index')}}"><i class="fa fa-user-circle"></i> <span>Tài Khoản</span></a> </li>
        <li> <a href="{{route('provider.index')}}"><i class="fa fa-inbox"></i> <span>Nhà cung cấp</span></a></li>
        <li><a href="{{route('phanxuong.index')}}"><i class="fa fa-th"></i> <span>Phân xưởng</span></a></li>
        <li><a href="{{route('theloai.index')}}"><i class="fa fa-th"></i> <span>Loại vật tư</span></a></li>
        <li><a href="{{route('vattu.index')}}"><i class="fa fa-th"></i> <span>Vật tư</span></a></li>
        {{--<li><a href="{{route('factories.index')}}"><i class="fa fa-th"></i> <span>Kho vật tư</span></a></li>--}}
        {{--<li><a href="{{route('factories.index')}}"><i class="fa fa-th"></i> <span>Nhân viên</span></a></li>--}}
        {{--<li><a href="{{route('factories.index')}}"><i class="fa fa-th"></i> <span>Kiểm tra</span></a></li>--}}
    </ul>
</div>
@yield('right-content')
@stop
