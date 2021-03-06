@extends('home')

@section('right-content')
    <div class="role col-md-10 ">
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
                <th>Tên đăng nhập</th>
                <th>Vai trò</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $i = ($users->currentpage() - 1) * $users->perpage() + 1 ?>
            @foreach($users as $user)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phanQuyen->TenQuyen }}</td>
                    <td>
                        @if(\Illuminate\Support\Facades\Auth::user()->MaQuyen === 3)
                        <button class="btn btn-comment fa fa-edit" data-toggle="modal" data-target="#changeRole-{{$user->id}}"></button>
                        @endif
                        <div class="modal fade" id="changeRole-{{$user->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit User</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('user.update',$user->id) }}">
                                            <input name="_method" type="hidden" value="PATCH">
                                            <input name="userId" type="hidden" value="{{$user->id}}">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-4 text-md-right">{{ __('Username') }}</label>

                                                <div class="col-md-6">
                                                   {{$user->name}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="quyen" class="col-md-4 col-form-label text-md-right">Quyền</label>
                                                <div  class="col-md-6">
                                                    <select style="width: 50%;height: 100%;"  name="role">
                                                        @foreach($listQuyen as $item)
                                                            <option value="{{ $item->MaQuyen }}" @if($user->phanQuyen->TenQuyen=== $item->TenQuyen) selected='selected' @endif> {{ strtoupper($item->TenQuyen) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
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
            </tbody>
        </table>
        <div class="pagination">{{ $users->links() }}</div>
    </div>
    <!-- Modal create-->
@stop
