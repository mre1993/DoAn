<?php

namespace App\Http\Controllers;

use App\NhaCungCap;
use App\TheLoai;
use App\VatTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VatTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = VatTu::orderBy('id','DESC')->paginate(10);
        return view('vattu.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $NCC = NhaCungCap::orderBy('id','DESC')->get();
        $MaLoaiVT = TheLoai::orderBy('id','DESC')->get();
        return view('vattu.create',compact('MaLoaiVT','NCC'));
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
            'MaVT.required' => 'Mã vật tư  không được để trống',
            'TenVT.required' => 'Tên vật tư không được để trống',
            'DVT.required'  => 'Đơn vị tính không được để trống',
        ];
        $rules = [
            'MaVT' => 'required|string|max:10|unique:vat_tu',
            'TenVT' => 'required|string|max:200',
            'DVT' => 'required|string|max:200',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        VatTu::create([
            'MaVT' =>$request['MaVT'],
            'TenVT' => $request['TenVT'],
            'DVT' => $request['DVT'],
            'MaNCC' => $request['MaNCC'],
            'MaLoaiVT' => $request['MaLoaiVT'],
            'MoTa' =>$request['MoTa']
        ]);
        return redirect('vattu');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VatTu  $vatTu
     * @return \Illuminate\Http\Response
     */
    public function show(VatTu $vatTu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VatTu  $vatTu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = VatTu::find($id);
        $NCC = NhaCungCap::orderBy('id','DESC')->get();
        $MaLoaiVT = TheLoai::orderBy('id','DESC')->get();
        return view('vattu.edit',compact('item','NCC','MaLoaiVT'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VatTu  $vatTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VatTu $vatTu)
    {
        $item = VatTu::find($request['id']);
        $message = [
            'MaVT.required' => 'Mã vật tư  không được để trống',
            'TenVT.required' => 'Tên vật tư không được để trống',
            'DVT.required'  => 'Đơn vị tính không được để trống',
        ];
        $rules = [
            'MaVT' => 'required|string|max:10',
            'TenVT' => 'required|string|max:200',
            'DVT' => 'required|string|max:200',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $item->MaVT = $request['MaVT'];
        $item->TenVT = $request['TenVT'];
        $item->DVT = $request['DVT'];
        $item->MaNCC = $request['MaNCC'];
        $item->MaLoaiVT = $request['MaLoaiVT'];
        $item->MoTa = $request['MoTa'];
        $item->save();

        return redirect('/vattu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VatTu  $vatTu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = VatTu::find($id);
        $item->delete();
        return redirect()->back();
    }
}
