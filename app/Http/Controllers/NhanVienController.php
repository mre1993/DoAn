<?php

namespace App\Http\Controllers;

use App\NhanVien;
use App\PhieuNhap;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = NhanVien::orderBy('MaNV','ASC')->where('Trang_Thai',false)->paginate(10);
        return view('nhanvien.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->MaQuyen < '3'){
            return view('welcome');
        }
        return view('nhanvien.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $message = [
            'MaNV.required' => 'Mã nhân viên  không được để trống',
            'MaNV.max' => 'Mã nhân viên vượt quá 10 ký tự',
            'MaNV.unique' => 'Mã nhân viên đã tồn tại',
            'TenNV.required' => 'Tên nhân viên không được để trống',
            'SDT.regex'  => 'Số điện thoại không hợp lệ',
            'SDT.max'  => 'Số điện thoại không hợp lệ',
            'SDT.min'  => 'Số điện thoại không hợp lệ'
        ];
        $rules = [
            'MaNV' => 'required|string|max:10|unique:nhan_vien',
            'TenNV' => 'required|string|max:200',
            'SDT' => 'nullable|regex:/^[0-9-+]+$/|max:13|min:10',
            'ChucVu' => 'nullable'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if($request['SDT'] == null){
            $request['SDT'] = '';
        }
        if($request['ChucVu'] == null){
            $request['ChucVu'] = '';
        }
        NhanVien::create([
            'TenNV' => $request['TenNV'],
            'MaNV' => $request['MaNV'],
            'ChucVu' => $request['ChucVu'],
            'SDT' => $request['SDT'],
            'GioiTinh' => $request['GioiTinh'],
        ]);
        return redirect('nhanvien');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function show(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->MaQuyen < '3'){
            return view('welcome');
        }
        $item = NhanVien::where('MaNV',$id)->first();
        $sex = ['nam','nữ'];
        return view('nhanvien.edit',compact('item','sex'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NhanVien $nhanVien)
    {
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $item = NhanVien::where('MaNV',$request->id)->first();
        $phieuNhap = PhieuNhap::where('MaNV',$request->id)->get();
        $phieuXuat = PhieuNhap::where('MaNV',$request->id)->get();
        $user = User::where('MaNV',$request->id)->get();
        $message = [
            'MaNV.required' => 'Mã nhân viên  không được để trống',
            'MaNV.max' => 'Mã nhân viên vượt quá 10 ký tự',
            'TenNV.required' => 'Tên nhân viên không được để trống',
            'SDT.regex'  => 'Số điện thoại không hợp lệ',
            'SDT.max'  => 'Số điện thoại không hợp lệ',
            'SDT.min'  => 'Số điện thoại không hợp lệ'
        ];
        $rules = [
            'MaNV' => 'required|string|max:10|',
            'TenNV' => 'required|string|max:200',
            'SDT' => 'required|string|regex:/^[0-9-+]+$/|max:13|min:10',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        foreach($phieuNhap as $item1){
            $item1->MaNV = $request->MaNV;
            $item1->save();
        }
        foreach($phieuXuat as $item2){
            $item2->MaNV = $request->MaNV;
            $item2->save();
        }
        foreach($user as $item3){
            $item3->MaNV = $request->MaNV;
            $item3->save();
        }
        $item->MaNV = $request->MaNV;
        $item->TenNV = $request->TenNV;
        $item->SDT = $request->SDT;
        $item->GioiTinh = $request->GioiTinh;
        $item->ChucVu = $request->ChucVu;
        $item->save();

        return redirect('/nhanvien');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $item = NhanVien::where('MaNV',$id)->first();
        $user = User::where('MaNV',$id)->first();
        $item->Trang_Thai = true;
        $user->Trang_Thai = true;
        $item->save();
        return redirect()->back();
    }

    public function searchNV(Request $request){
        $i = 1;
        $items = DB::table('nhan_vien')
            ->select('nhan_vien.*')
            ->where('Trang_Thai',false)
            ->where('TenNV','LIKE','%'.$request->search.'%')
            ->orWhere('MaNV','LIKE','%'.$request->search.'%')
            ->orWhere('ChucVu','LIKE','%'.$request->search.'%')
            ->orWhere('SDT','LIKE','%'.$request->search.'%')
            ->orderBy('MaNV','ASC')
            ->paginate(10);
        return view('nhanvien.search',compact('items','i'));
    }
}
