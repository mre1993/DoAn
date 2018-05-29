@extends('home')
@section('right-content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">{{ __('Nhập vật tư') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('nhanvien.store') }}" name="create">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="TenNV">Nhân viên:</label>
                            <input type="text" name="MaPN" id="MaPN" class="form-control" placeholder="Nhập mã phiếu nhập">
                        </div>
                        <div class="col-md-3">
                            <select style="height: 100%;"  name="MaKVT" class="form-control">
                                <option value="" disabled selected>Chọn kho nhập</option>
                                @foreach($MaKVT as $item)
                                    <option value="{{ $item->MaKVT }}" > {{ $item->TenKVT }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
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