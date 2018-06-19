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
        <div class="card">
            <div class="card-header">{{ __('Xuất vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('phieuxuat.store') }}" name="create">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="TenNV" class="col-form-label">Nhân viên: {{$nhanVien->TenNV}}</label>
                            <input type="hidden" name="MaNV" value="{{$nhanVien->MaNV}}">
                        </div>
                        <div class="col-md-3">
                            <select style="height: 100%;"  name="MaKVT" class="form-control" id="MaKVT">
                                <option value="" disabled selected>Chọn kho vật tư</option>
                                @foreach($MaKVT as $item)
                                    <option value="{{ $item->MaKVT }}" {{ old('MaKVT') == $item->MaKVT ? 'selected' : '' }}> {{ $item->TenKVT }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select style="height: 100%;"  name="MaPX" class="form-control">
                                <option value="" disabled selected>Chọn phân xưởng</option>
                                @foreach($MaPX as $item)
                                    <option value="{{ $item->MaPX }}" {{ old('MaNCC') == $item->MaPX ? 'selected' : '' }}> {{ $item->TenPX }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" placeholder="Nhập mã phiếu xuất" class="form-control" name="MaPhieuXuat" value="{{old('MaPhieuXuat')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="TimVT">Tìm kiếm vật tư</label>
                            <input type="text" placeholder="Nhập để tìm" name="TimVT" class="form-control search-query">
                            <div class="suggest-search"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="NoiDung">Nội dung</label>
                            <textarea id="NoiDung" name="NoiDung" class="form-control">{{old('NoiDung')}}</textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table table-striped table-PN">
                                <thead>
                                <tr>
                                    <th>Vật tư</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="inputVT">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-7 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Thêm mới') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop