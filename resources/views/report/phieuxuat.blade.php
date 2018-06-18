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
        <div class="card report">
            <div class="card-header">{{ __('Bảng kê phiếu xuất') }}</div>
            <div class="card-body">
                <form name="create" id="myform" action="{{route('reportRecord.phieuxuat')}}">
                    @csrf
                <div class="form-group row">
                        <div class="col-md-4">
                            <label for="date_from" class="col-md-4 col-form-label">Từ ngày</label>
                            <input type="date" class="form-control col-md-8" id="date_from" name="date_from">
                        </div>
                        <div class="col-md-4">
                            <label for="date_to" class="col-md-4 col-form-label">Từ ngày</label>
                            <input type="date" class="form-control col-md-8" id="date_to" name="date_to">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label col-md-4" for="TenNV">Nhân viên</label>
                            <input type="text" name="TenNV" value="" id="TenNV" class="col-md-8 form-control" placeholder="Nhập tên nhân viên">
                        </div>
                    </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label class="control-label col-md-4" for="MaPhieuXuat">Phiếu xuất</label>
                        <input type="text" placeholder="Nhập mã phiếu xuất" class="form-control col-md-8" name="MaPhieuXuat">
                    </div>
                    <div class="col-md-4">
                        <label class="control-label col-md-4" for="MaKVT">Kho vật tư</label>
                        <select style="height: auto;"  name="MaKVT" class="form-control col-md-8" id="MaKVT">
                            <option value=""  selected>Chọn kho vật tư</option>
                            @foreach($MaKVT as $item)
                                <option value="{{ $item->MaKVT }}" > {{ $item->TenKVT }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label col-md-4" for="MaPX">Phân xưởng</label>
                        <select style="height: auto;"  name="MaPX" class="form-control col-md-8" id="MaPX">
                            <option value="" selected>Chọn phân xưởng</option>
                            @foreach($MaPX as $item)
                                <option value="{{ $item->MaPX }}" > {{ $item->TenPX }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="TimVT" class="col-md-4 col-form-label">Vật tư</label>
                            <div class="col-md-8" style="padding: 0">
                                <input type="text" placeholder="Nhập tên vật tư" name="TimVT" class="form-control search-vat-tu">
                                <div class="suggest-search-vat-tu col-md-12"></div>
                            </div>
                        </div>
                    </div>
                <div class="form-group row mb-0">
                    <div class="col-md-7 offset-md-5">
                        <button type="button" class="btn btn-primary" id="create-report-phieuxuat">
                            {{ __('Tạo') }}
                        </button>
                    </div>
                </div>
                </form>
                <div class="form-group" id="export-report">
                </div>
                <button type="submit" id="btn-export" class="btn btn-primary offset-md-5 fa fa-file-excel-o" style="display: none;"> Excel</button>
            </div>
        </div>
    </div>
@endsection
