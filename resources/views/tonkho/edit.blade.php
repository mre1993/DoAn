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
        <fieldset class="col-md-12 infor-phieu-nhap">
            <legend class="scheduler-border">Tồn kho vật tư</legend>
            <div class="col-md-6">
                <label for="MaVT" class="col-md-4 col-form-label">Mã vật tư</label>
                <input id="MaVT" name="MaVT" class="form-control col-md-8" readonly value="{{$id}}">
            </div>
            <div class="col-md-6">
                <label for="TenVT" class="col-md-4 col-form-label">Tên vật tư</label>
                <input id="TenVT" name="TenVT" class="form-control col-md-8" readonly value="{{$item->TenVT}}">
            </div>
            <div class="col-md-6">
                <label for="SoLuongTon" class="col-md-4 col-form-label">Số lượng tồn</label>
                <input id="SoLuongTon" name="SoLuongTon" class="form-control col-md-8" readonly value="{{number_format($item->SoLuongTon, 0, ',', '.')}}">
            </div>
            <div class="col-md-6">
                <label for="SoLuongHong" class="col-md-4 col-form-label">Số lượng vật tư hỏng</label>
                <input id="SoLuongHong" name="SoLuongHong" class="form-control col-md-8" readonly value="{{number_format($item->SoLuongHong, 0, ',', '.')}}">
            </div>
            <div class="col-md-6">
                <label for="TongSoLuong" class="col-md-4 col-form-label">Tổng số vật tư</label>
                <input id="TongSoLuong" name="TongSoLuong" class="form-control col-md-8" readonly value="{{number_format($item->TongSoLuong, 0, ',', '.')}}">
            </div>
        </fieldset>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kho vật tư</th>
                    <th>Địa chỉ</th>
                    <th>Số lượng vật tư tồn</th>
                    <th>Số lượng vật tư hỏng</th>
                    <th>Tổng số lượng vật tư</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php $kvt = \App\ChiTietKhoVT::where('MaVT',$item->MaVT)->where('SoLuongTon','>',0)->get()?>
            @foreach($kvt as $value)
                <?php $kho = \App\KhoVatTu::where('MaKVT',$value->MaKVT)->get() ?>
                @foreach($kho as $ten)
                        <tr>
                            <td>{{$ten->TenKVT}}</td>
                            <td>{{$ten->DiaChi}}</td>
                            <td>{{number_format($value->SoLuongTon, 0, ',', '.')}}</td>
                            <td>{{number_format($value->SoLuongHong, 0, ',', '.')}}</td>
                            <td>{{number_format($value->TongSoLuong, 0, ',', '.')}}</td>
                            <td>
                                <button type="button" class="btn btn-comment fa fa-cogs"  data-toggle="modal" data-target="#hong-{{$ten->MaKVT}}"></button>
                                <form action="{{route('hong.remove')}}" method="post" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="MaKVT" value="{{$ten->MaKVT}}">
                                    <input type="hidden" name="MaVT" value="{{$item->MaVT}}">
                                </form>
                                <div class="modal fade" id="hong-{{$ten->MaKVT}}" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Số lượng vật tư hỏng cho {{$ten->TenKVT}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{route('hong.edit')}}" class="edit-hong">
                                                    @csrf
                                                    <input type="hidden" name="MaKVT" value="{{$ten->MaKVT}}">
                                                    <input type="hidden" name="MaVT" value="{{$item->MaVT}}">
                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-12">
                                                            <label for="SoLuongHong" class="col-md-6 col-form-label">
                                                                Thêm lượng vật tư hỏng
                                                            </label>
                                                            <input type="number" placeholder="Nhập số lượng hàng hỏng" class="form-control col-md-6" name="SoLuongHong" max="{{$value->TongSoLuong}}">
                                                        </div>
                                                        <div class="col-md-12" style="margin-top: 10px;">
                                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@stop