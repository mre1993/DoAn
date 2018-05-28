@extends('layouts.app')
@section('content')
<div id="sidebar" class="col-md-2">
    <div class="panel panel-default-small">
        <div class="menu-list">
            <a href="{{route('home')}}" class="list-group-item"><i class="fa fa-home"></i> <span>Dashboard</span></a>
        </div>
        <div class="menu-list">
            <a data-toggle="collapse" href="#hethong" class="list-group-item">
                <span class="fa fa-user-circle"></span> <b>Quản lý hệ thống</b>
            </a>
            <ul class="collapse out" id="hethong">
                <li class=""> <a href="{{route('user.index')}}"><i class="fa fa-th-list"></i> <span>Tài Khoản</span></a> </li>
            </ul>
        </div>
        <div class="menu-list">
            <a data-toggle="collapse" href="#danhmuc" class="list-group-item">
                <span class="fa fa-th"></span> <b> Quản lý danh mục </b>
            </a>
            <ul class="collapse out" id="danhmuc">
                <li class=""><a href="{{route('provider.index')}}"><i class="fa fa-th-list"></i> <span>Nhà cung cấp</span></a></li>
                <li class=""><a href="{{route('phanxuong.index')}}"><i class="fa fa-th-list"></i> <span>Phân xưởng</span></a></li>
                <li class=""><a href="{{route('theloai.index')}}"><i class="fa fa-th-list"></i> <span>Loại vật tư</span></a></li>
                <li class=""><a href="{{route('vattu.index')}}"><i class="fa fa-th-list"></i> <span>Vật tư</span></a></li>
                <li class=""><a href="{{route('nhanvien.index')}}"><i class="fa fa-th-list"></i> <span>Nhân viên</span></a></li>
                <li class=""><a href="{{route('khovattu.index')}}"><i class="fa fa-th-list"></i> <span>Kho vật tư</span></a></li>
            </ul>
        </div>
        <div class="menu-list">
            <a data-toggle="collapse" href="#nhapxuat" class="list-group-item">
                <span class="indent"></span> <b>Quản lý nhập xuất tồn</b>
            </a>
            <ul class="collapse out" id="nhapxuat">
                <li class=""><a href="{{route('phieunhap.index')}}"><i class="fa fa-th-list"></i> <span>Kho vật tư</span></a></li>
            </ul>
        </div>
    </div>
</div>
@yield('right-content')
@stop
