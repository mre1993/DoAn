<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PhanQuyen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\NhanVien;

class UserController extends Controller
{
    use RegistersUsers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','ASC')->where('Trang_Thai',false)->paginate(10);
        $listQuyen = PhanQuyen::orderBy('MaQuyen','ASC')->get();
        $i = 1;
        return view('user', compact('users','listQuyen','i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCreate()
    {
        if(Auth::user()->MaQuyen != 3){
            return view('welcome');
        }
        $user = User::all();
        $maNV = array();
        foreach ($user as $item){
            $maNV[] = $item->MaNV;
        }
        $nhanvien = NhanVien::orderBy('MaNV','ASC')->whereNotIn('MaNV',$maNV)->get();
        return view('createUser',compact('nhanvien'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->MaQuyen !== 3){
            return redirect()->back();
        }
        $message = [
            'password.required' => 'Mật khẩu  không được để trống',
            'MaNV.required' => 'Bạn hãy chọn nhân viên'
        ];
        $rules = [
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'MaNV' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        User::create([
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'MaNV' => $request->MaNV
        ]);

        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function show(PhanQuyen $phanQuyen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function edit(PhanQuyen $phanQuyen)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->MaQuyen !== 3){
            return redirect()->back();
        }
        if($request->get('password')){
            $rules = array(
                'oldpassword' => 'required|string|min:6',
                'password' => 'required|string|min:6',
                'cpassword' => 'required|same:oldpassword|string|min:6',
            );
            $message = [
                'oldpassword.required' => 'Mật khẩu cũ không được để trống',
                'password.required' => 'Mật khẩu mới không được để trống',
                'cpassword.required' => 'Nhập lại mật khẩu không được để trống',
                'cpassword.same' => 'Nhập lại mật khẩu phải giống với mật khẩu mới',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $password = User::find($request->get('userId'))->password;
            if (Hash::check($request->input('oldpassword'), $password)) {
                User::find($request->input('userId'))->update([
                    'password' => bcrypt($request->input('password')),
                ]);

                return redirect()->back();
            } else {
                return redirect()->back()->withErrors('Mật khẩu cũ không đúng!');
            }
        }
        else if($request->role)
        {
            User::where('id',$request->userId)->update([
                'MaQuyen' => $request->role,
            ]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->MaQuyen !== 3){
            return false;
        }
        $user = User::find($id);
        $user->delete();
        return redirect()->back();
    }

    public function phanQuyen(){
        $users = User::orderBy('id','ASC')->paginate(10);
        $listQuyen = PhanQuyen::orderBy('MaQuyen','ASC')->get();
        $i = 1;
        return view('phanquyen', compact('users','listQuyen','i'));
    }
}
