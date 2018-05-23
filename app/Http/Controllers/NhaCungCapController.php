<?php

namespace App\Http\Controllers;

use App\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provider = NhaCungCap::orderBy('id','DESC')->paginate(10);
        $i = 1;
        return view('provider.index',compact('provider','i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('provider.create');
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
            'MaNCC.required' => 'Mã nhà cung cấp  không được để trống',
            'TenNCC.required' => 'Tên nhà cung cấp không được để trống',
            'DiaChi' => 'Địa chỉ không được để trống',
            'sdtNCC' => 'Số điện thoại không được để trống',
            'emailNCC' => 'Email không được để trống'
        ];
        $rules = [
            'MaNCC' => 'required|string|max:10|unique:nha_cung_cap',
            'TenNCC' => 'required|string|max:200',
            'DiaChi' => 'required|string',
            'sdtNCC' => 'required|string',
            'emailNCC' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        NhaCungCap::create([
            'TenNCC' => $request['TenNCC'],
            'MaNCC' => $request['MaNCC'],
            'DiaChi' => $request['DiaChi'],
            'SDT' => $request['sdtNCC'],
            'Email' => $request['emailNCC'],
            'fax' => $request['Fax'],
            'GhiChu' => $request['ghiChu'],
        ]);
        return redirect('provider');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NhaCungCap  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(NhaCungCap $provider)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NhaCungCap  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provider = NhaCungCap::find($id);
        return view('provider.edit',compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NhaCungCap  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NhaCungCap $provider)
    {
        $provider = NhaCungCap::find($request->all()['id']);
        $message = [
            'MaNCC.required' => 'Mã nhà cung cấp  không được để trống',
            'TenNCC.required' => 'Tên nhà cung cấp không được để trống',
            'DiaChi.required' => 'Địa chỉ không được để trống',
            'sdtNCC.required' => 'Số điện thoại không được để trống',
            'emailNCC.required' => 'Email không được để trống'
        ];
        $rules = [
            'MaNCC' => 'required|string|max:10',
            'TenNCC' => 'required|string|max:200',
            'DiaChi' => 'required|string',
            'sdtNCC' => 'required|string',
            'emailNCC' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $provider->MaNCC = $request->all()['MaNCC'];
        $provider->TenNCC = $request->all()['TenNCC'];
        $provider->DiaChi = $request->all()['DiaChi'];
        $provider->SDT = $request->all()['sdtNCC'];
        $provider->Fax = $request->all()['fax'];
        $provider->Email = $request->all()['emailNCC'];
        $provider->GhiChu = $request->all()['ghiChu'];
        $provider->save();

        return redirect('/provider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NhaCungCap  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(NhaCungCap $id)
    {
        $provider = NhaCungCap::find($id);
        $provider->delete();
        return redirect()->back();
    }
}
