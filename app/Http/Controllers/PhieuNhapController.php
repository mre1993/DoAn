<?php

namespace App\Http\Controllers;

use App\KhoVatTu;
use App\NhaCungCap;
use App\NhanVien;
use App\PhieuNhap;
use App\VatTu;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PhieuNhapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = PhieuNhap::orderBy('MaPN','ASC')->paginate(10);
        return view('phieunhap.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user =  Auth::user();
        $nhanVien = NhanVien::find($user->MaNV);
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        $MaNCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('phieunhap.create',compact('MaKVT','nhanVien','MaNCC'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'MaKVT.required' => 'Mã loại vật tư  không được để trống',
            'MaPN.unique' => 'Mã loại đã tồn tại',
            'MaNCC.required' => 'Tên loại vật tư không được để trống',
            'MaVT.unique' => 'Tên loại đã tồn tại',
        ];
        $rules = [
            'MaLoaiVT' => 'required|string|max:10|unique:loai_vat_tu',
            'TenLoaiVT' => 'required|string|max:200,unique:loai_vat_tu',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        TheLoai::create([
            'MaLoaiVT' =>$request['MaLoaiVT'],
            'TenLoaiVT' => $request['TenLoaiVT'],
        ]);
        return redirect('theloai');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function show(PhieuNhap $phieuNhap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function edit(PhieuNhap $phieuNhap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhieuNhap $phieuNhap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuNhap $phieuNhap)
    {
        //
    }

    public function search($request){
        $result = VatTu::where('TenVT','LIKE','%'.$request.'%')->get();
        return response()->json($result);
    }

    public function getVT($request){
        $result = VatTu::where('MaVT',$request)->first();
        return response()->json($result);
    }
}
