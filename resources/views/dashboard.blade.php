@extends('home')
@section('right-content')
    <div class="right-content col-md-10">
        <div class="chart col-md-6">
            <div id="chartNhap"   style="height: 300px;"></div>
            <h3>Số lượng nhập</h3>
        </div>
        <div class="chart col-md-6">
            <div id="chartXuat" style="height: 300px;"></div>
            <h3>Số lượng Xuất</h3>
        </div>
        <div class="chart col-md-6">
            <div id="chartTon" style="height: 300px;"></div>
            <h3>Số lượng Tồn</h3>
        </div>
    </div>
@endsection