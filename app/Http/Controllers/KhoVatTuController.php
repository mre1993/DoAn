<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
use App\KhoVatTu;
use App\VatTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KhoVatTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = KhoVatTu::orderBy('MaKVT','ASC')->paginate(10);
        $i=1;
        return view('khovattu.index',compact('items','i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        return view('khovattu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->MaQuyen < '2'){
            return false;
        }
        $message = [
            'MaKVT.required' => 'Mã kho không được để trống',
            'MaKVT.max' => 'Mã nhà cung cấp vượt quá 10 ký tự',
            'TenKVT.required' => 'Tên kho không được để trống',
            'DiaChi.required' => 'Địa chỉ không được để trống',
            'SDT.required' => 'Số điện thoại không được để trống',
            'SDT.regex'  => 'Số điện thoại không hợp lệ',
            'SDT.max'  => 'Số điện thoại không hợp lệ'
        ];
        $rules = [
            'MaKVT' => 'required|string|max:10|unique:kho_vat_tu',
            'TenKVT' => 'required|string|max:200',
            'DiaChi' => 'required|string',
            'SDT' => 'required|string|regex:/^[0-9-+]+$/|max:13',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        KhoVatTu::create([
            'TenKVT' => $request->TenKVT,
            'MaKVT' => $request->MaKVT,
            'DiaChi' => $request->DiaChi,
            'SDT' => $request->SDT,
            'ThuKho' => $request->ThuKho,
            'GhiChu' => $request->GhiChu,
        ]);
        return redirect('/khovattu');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KhoVatTu  $khoVatTu
     * @return \Illuminate\Http\Response
     */
    public function show(KhoVatTu $khoVatTu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KhoVatTu  $khoVatTu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        $item = KhoVatTu::where('MaKVT',$id)->first();
        return view('khovattu.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KhoVatTu  $khoVatTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KhoVatTu $khoVatTu)
    {
        if(Auth::user()->MaQuyen < '2'){
            return false;
        }
        $item = KhoVatTu::where('MaKVT',$request->id)->first();
        $chiTietKVT = ChiTietKhoVT::where('MaKVT',$request->id)->get();
        $message = [
            'MaKVT.required' => 'Mã kho không được để trống',
            'MaKVT.max' => 'Mã nhà cung cấp vượt quá 10 ký tự',
            'TenKVT.required' => 'Tên kho không được để trống',
            'DiaChi.required' => 'Địa chỉ không được để trống',
            'SDT.required' => 'Số điện thoại không được để trống',
            'SDT.regex'  => 'Số điện thoại không hợp lệ',
            'SDT.max'  => 'Số điện thoại không hợp lệ'
        ];
        $rules = [
            'MaKVT' => 'required|string|max:10',
            'TenKVT' => 'required|string|max:200',
            'DiaChi' => 'required|string',
            'SDT' => 'required|string|regex:/^[0-9-+]+$/|max:13',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        foreach ($chiTietKVT as $chiTiet){
            $chiTiet->MaKVT   = $request->MaKVT;
            $chiTiet->save();
        }
        $item->MaKVT = $request->MaKVT;
        $item->TenKVT = $request->TenKVT;
        $item->DiaChi = $request->DiaChi;
        $item->SDT = $request->SDT;
        $item->ThuKho = $request->ThuKho;
        $item->GhiChu = $request->GhiChu;
        $item->save();

        return redirect('/khovattu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KhoVatTu  $khoVatTu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->MaQuyen < '2'){
            return false;
        }
        $item = KhoVatTu::where('MaKVT',$id);
        $item->delete();
        return redirect()->back();
    }

    public function showTonKho(){
        $items = DB::table('vat_tu')
            ->select(
                'vat_tu.MaVT',
                'vat_tu.TenVT',
                'chi_tiet_kho_vat_tu.MaKVT',
                DB::raw('SUM(chi_tiet_kho_vat_tu.TongSoLuong) as TongSoLuong'),
                DB::raw('SUM(chi_tiet_kho_vat_tu.SoLuongTon) as SoLuongTon'),
                DB::raw('SUM(chi_tiet_kho_vat_tu.SoLuongHong) as SoLuongHong')
            )
            ->join('chi_tiet_kho_vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->groupBy('chi_tiet_kho_vat_tu.MaVT')
            ->orderBy('vat_tu.MaVT','DESC')
            ->paginate(10);
        return view('tonkho.index',compact('items'));
    }

    public function checkHong($id){
        $item = DB::table('vat_tu')
            ->select(
                'vat_tu.MaVT',
                'vat_tu.TenVT',
                'kho_vat_tu.TenKVT',
                DB::raw('SUM(chi_tiet_kho_vat_tu.TongSoLuong) as TongSoLuong'),

                DB::raw('SUM(chi_tiet_kho_vat_tu.SoLuongTon) as SoLuongTon'),
                DB::raw('SUM(chi_tiet_kho_vat_tu.SoLuongHong) as SoLuongHong')
            )
            ->join('chi_tiet_kho_vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','chi_tiet_kho_vat_tu.MaKVT')
            ->where('vat_tu.MaVT',$id)
            ->groupBy('vat_tu.MaVT')
            ->orderBy('vat_tu.MaVT','DESC')
            ->first();
        return view('tonkho.edit',compact('item','id'));
    }
}
