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
            <div class="card-header">{{ __('Báo cáo tồn kho') }}</div>
            <div class="card-body">
                <form name="create" id="myform-ton" action="{{route('reportRecord.vattu')}}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label col-md-4" for="MaKVT">Kho vật tư</label>
                            <select style="height: auto;"  name="MaKVT" class="form-control col-md-8" id="MaKVT">
                                <option value=""  selected>Chọn kho vật tư</option>
                                @foreach($MaKVT as $item)
                                    <option value="{{ $item->MaKVT }}" > {{ $item->TenKVT }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="TimVT" class="col-md-4 col-form-label">Vật tư</label>
                            <input type="text" placeholder="Nhập tên vật hoặc mã vật tư" name="TimVT" class="form-control col-md-8">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label col-md-4" for="start">Số lượng tồn ít nhất</label>
                            <input type="number" placeholder="Từ số lượng" name="start" class="form-control col-md-8">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label col-md-4" for="end">Số lượng tồn lớn nhất</label>
                            <input type="number" placeholder="Đến số lượng" name="end" class="form-control col-md-8">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-7 offset-md-5">
                            <button type="button" class="btn btn-primary" id="report-ton">
                                {{ __('Tạo') }}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="form-group" id="export-report">
                </div>
                <button type="submit" id="btn-export-ton" class="btn btn-primary offset-md-5 fa fa-file-excel-o" style="display: none;"> Excel</button>
            </div>
        </div>
    </div>
@endsection
