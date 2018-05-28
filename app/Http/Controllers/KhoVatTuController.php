<?php

namespace App\Http\Controllers;

use App\KhoVatTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'Fax' => $request->Fax,
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
        $item = KhoVatTu::find($id)->first();
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
        $item = KhoVatTu::where('MaKVT',$request->id)->first();
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
        $item->MaKVT = $request->MaKVT;
        $item->TenKVT = $request->TenKVT;
        $item->DiaChi = $request->DiaChi;
        $item->SDT = $request->SDT;
        $item->Fax = $request->Fax;
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
        $item = KhoVatTu::find($id);
        $item->delete();
        return redirect()->back();
    }
}