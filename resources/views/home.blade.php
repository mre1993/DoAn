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
            <ul class="collapse" id="hethong">
                <li class=""> <a href="{{route('user.index')}}"><i class="fa fa-th-list"></i> <span>Tài Khoản</span></a> </li>
                <li class=""><a href="{{route('tim-tk')}}"><i class="fa fa-search"></i> <span>Tìm kiếm tài khoản</span></a></li>
            </ul>
        </div>
        <div class="menu-list">
            <a data-toggle="collapse" href="#danhmuc" class="list-group-item">
                <span class="fa fa-list-ul"></span> <b> Quản lý danh mục </b>
            </a>
            <ul class="collapse" id="danhmuc">
                <li class=""><a href="{{route('provider.index')}}"><i class="fa fa-th-list"></i> <span>Nhà cung cấp</span></a></li>
                <li class=""><a href="{{route('phanxuong.index')}}"><i class="fa fa-th-list"></i> <span>Phân xưởng</span></a></li>
                <li class=""><a href="{{route('vattu.index')}}"><i class="fa fa-th-list"></i> <span>Vật tư</span></a></li>
                <li class=""><a href="{{route('nhanvien.index')}}"><i class="fa fa-th-list"></i> <span>Nhân viên</span></a></li>
                <li class=""><a href="{{route('khovattu.index')}}"><i class="fa fa-th-list"></i> <span>Kho vật tư</span></a></li>
                <li class=""><a href="{{route('tim-dm')}}"><i class="fa fa-search"></i> <span>Tìm kiếm danh mục</span></a></li>
            </ul>
        </div>
        <div class="menu-list">
            <a data-toggle="collapse" href="#nhapxuat" class="list-group-item">
                <span class="fa fa-random"></span> <b>Nhập xuất tồn</b>
            </a>
            <ul class="collapse" id="nhapxuat">
                <li class=""><a href="{{route('phieunhap.index')}}"><i class="fa fa-download"></i> <span>Quản lý nhập</span></a></li>
                <li class=""><a href="{{route('phieuxuat.index')}}"><i class="fa fa-upload"></i> <span>Quản lý xuất</span></a></li>
                <li class=""><a href="{{route('tim-n-x-t')}}"><i class="fa fa-search"></i> <span>Tìm kiếm nhập-xuất-tồn</span></a></li>
            </ul>
        </div>
        <div class="menu-list">
            <a data-toggle="collapse" href="#bao-cao" class="list-group-item">
                <span class="fa fa-archive"></span> <b>Báo cáo thống kê</b>
            </a>
            <ul class="collapse" id="bao-cao">
                <li class=""><a href="{{route('baocao.vattu')}}"><i class="fa fa-file-alt"></i> <span>Báo cáo vật tư</span></a></li>
                <li class=""><a href="{{route('report.phieuxuat')}}"><i class="fa fa-file-alt"></i> <span>Bảng kê phiếu xuất</span></a></li>
                <li class=""><a href="{{route('report.phieunhap')}}"><i class="fa fa-file-alt"></i> <span>Bảng kê phiếu nhập</span></a></li>
                <li class=""><a href="{{route('baocao.vattu')}}"><i class="fa fa-file-alt"></i> <span>Báo cáo vật tư</span></a></li>
                <li class=""><a href="{{route('tim-bc')}}"><i class="fa fa-search"></i> <span>Tìm kiếm tài khoản</span></a></li>
            </ul>
        </div>
    </div>
</div>

@yield('right-content')
<div class="right-content col-md-12">
    <div class="col-md-12">
        <h2>Dashboard</h2>
    </div>
    <div id="piechart-1"></div>
    <div id="piechart-2"></div>
</div>
@stop
