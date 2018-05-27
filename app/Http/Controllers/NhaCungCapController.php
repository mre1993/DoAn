<?php

namespace App\Http\Controllers;

use App\NhaCungCap;
use App\VatTu;
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
        $provider = NhaCungCap::orderBy('MaNCC','ASC')->paginate(10);
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
            'MaNCC.max' => 'Mã nhà cung cấp vượt quá 10 ký tự',
            'TenNCC.required' => 'Tên nhà cung cấp không được để trống',
            'DiaChi.required' => 'Địa chỉ không được để trống',
            'sdtNCC.required' => 'Số điện thoại không được để trống',
            'emailNCC.required' => 'Email không được để trống',
            'emailNCC.email' => 'Email không hợp lệ',
            'sdtNCC.regex'  => 'Số điện thoại không hợp lệ',
            'sdtNCC.max'  => 'Số điện thoại không hợp lệ'
        ];
        $rules = [
            'MaNCC' => 'required|string|max:10|unique:nha_cung_cap',
            'TenNCC' => 'required|string|max:200',
            'DiaChi' => 'required|string',
            'sdtNCC' => 'required|string|regex:/^[0-9-+]+$/|max:13',
            'emailNCC' => 'required|string|email',
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
        $provider = NhaCungCap::where('MaNCC',$id)->first();
        return view('provider.edit',compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NhaCungCap  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $provider = NhaCungCap::where('MaNCC',$request->id)->first();
        $message = [
            'MaNCC.required' => 'Mã nhà cung cấp  không được để trống',
            'MaNCC.max' => 'Mã nhà cung cấp vượt quá 10 ký tự',
            'TenNCC.required' => 'Tên nhà cung cấp không được để trống',
            'DiaChi.required' => 'Địa chỉ không được để trống',
            'sdtNCC.required' => 'Số điện thoại không được để trống',
            'emailNCC.required' => 'Email không được để trống',
            'emailNCC.email' => 'Email không hợp lệ',
            'sdtNCC.regex'  => 'Số điện thoại không hợp lệ',
            'sdtNCC.max'  => 'Số điện thoại không hợp lệ'
        ];
        $rules = [
            'MaNCC' => 'required|string|max:10',
            'TenNCC' => 'required|string|max:200',
            'DiaChi' => 'required|string',
            'sdtNCC' => 'required|string|regex:/^[0-9-+]+$/|max:13',
            'emailNCC' => 'required|string|email',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        VatTu::where('MaNCC', '=', $provider->MaNCC)->update(['MaNCC' => $request->MaNCC]);
        $provider->MaNCC = $request->MaNCC;
        $provider->TenNCC = $request->TenNCC;
        $provider->DiaChi = $request->DiaChi;
        $provider->SDT = $request->sdtNCC;
        $provider->Fax = $request->fax;
        $provider->Email = $request->emailNCC;
        $provider->GhiChu = $request->ghiChu;
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
