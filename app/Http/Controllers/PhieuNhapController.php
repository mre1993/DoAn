<?php

namespace App\Http\Controllers;

use App\ChiTietPhieuNhap;
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
        $i = 1;
        $items = PhieuNhap::orderBy('MaPN','ASC')->paginate(10);
        return view('phieunhap.index',compact('items','i'));
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
            'MaKVT.required' => 'Mã kho vật tư không được để trống',
            'MaPN.unique' => 'Mã phiếu nhập đã tồn tại',
            'MaPN.required' => 'Mã phiếu nhập không được để trống',
            'MaNCC.required' => 'Mã nhà cung cấp không được để trống',
            'MaVT.required' => 'Mã vật tư không được để trống',
        ];
        $rules = [
            'MaKVT' => 'required|string|max:10',
            'MaPN' => 'required|string|max:10|unique:phieu_nhap',
            'MaNCC' => 'required|string|max:10',
            'MaVT' => 'required|max:10',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        $count = count($request->MaVT);
        for($i=0; $i<$count; $i++){
            ChiTietPhieuNhap::create([
                'MaPN' => $request->MaPN,
                'MaVT' => $request->MaVT[$i],
                'SoLuong' => $request->SoLuong[$i],
                'DonGia' => $request->DonGia[$i],
                'ThanhTien' => $request->ThanhTien[$i],
            ]);
        }

        PhieuNhap::create([
            'MaPN' =>$request->MaPN,
            'MaKVT' => $request->MaKVT,
            'MaNV' => $request->MaNV,
            'MaNCC' => $request->MaNCC,
            'NoiDung' => $request->NoiDung,
        ]);
        return redirect('phieunhap');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phieuNhap = PhieuNhap::find($id)->first();
        $chiTiet = ChiTietPhieuNhap::where('MaPN',$id)->get();
        $i=1;
        return view('phieunhap.show',compact('phieuNhap','chiTiet','i'));
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

    public function showExport($id){
        $vatTu = ChiTietPhieuNhap::where('MaPN',$id)->orderBy('id','ASC')->get();
        $phieuNhap = PhieuNhap::find($id)->first();
        $i=1;
        $sumSL = 0;
        foreach($vatTu as $item){
            $sumSL = $sumSL + $item->SoLuong;
        }
        return view('phieunhap.showExport',compact('vatTu','phieuNhap','i','sumSL'));
    }
}
