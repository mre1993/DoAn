<?php

namespace App\Http\Controllers;

use App\TheLoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TheLoaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items =  TheLoai::orderBy('id','DESC')->paginate(10);
        return view('theloai.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('theloai.create');
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
            'MaLoaiVT.required' => 'Mã loại vật tư  không được để trống',
            'MaLoaiVT.unique' => 'Mã loại đã tồn tại',
            'TenLoaiVT.required' => 'Tên loại vật tư không được để trống',
            'TenLoaiVT.unique' => 'Tên loại đã tồn tại',
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
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loai = TheLoai::find($id);
        return view('theloai.edit',compact('loai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TheLoai $loaiVatTu)
    {
        $provider = TheLoai::find($request->all()['id']);

        $message = [
            'MaLoaiVT.required' => 'Mã loại vật tư  không được để trống',
            'TenLoaiVT.required' => 'Tên loại vật tư không được để trống',
        ];
        $rules = [
            'MaLoaiVT' => 'string|max:10',
            'TenLoaiVT' => 'string|max:200',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $provider->MaLoaiVT = $request->all()['MaLoaiVT'];
        $provider->TenLoaiVT = $request->all()['TenLoaiVT'];
        $provider->save();

            return redirect('/theloai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = TheLoai::find($id);
        $item->delete();
        return redirect()->back();
    }
}
