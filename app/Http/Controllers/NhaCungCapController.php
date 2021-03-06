<?php

namespace App\Http\Controllers;

use App\NhaCungCap;
use App\VatTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = NhaCungCap::orderBy('MaNCC','ASC')->where('Trang_Thai',false)->paginate(10);
        $i = 1;
        return view('provider.index',compact('items','i'));
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
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $message = [
            'MaNCC.required' => 'Mã nhà cung cấp  không được để trống',
            'MaNCC.max' => 'Mã nhà cung cấp vượt quá 10 ký tự',
            'TenNCC.required' => 'Tên nhà cung cấp không được để trống',
            'DiaChi.required' => 'Địa chỉ không được để trống',
            'sdtNCC.required' => 'Số điện thoại không được để trống',
            'emailNCC.required' => 'Email không được để trống',
            'emailNCC.email' => 'Email không hợp lệ',
            'sdtNCC.regex'  => 'Số điện thoại không hợp lệ',
            'sdtNCC.max'  => 'Số điện thoại không hợp lệ',
            'MaNCC.unique' => 'Mã nhà cung cấp đã tồn tại'
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
            return redirect()->back()->withInput()
                ->withErrors($validator);
        }
        NhaCungCap::create([
            'TenNCC' => $request['TenNCC'],
            'MaNCC' => $request['MaNCC'],
            'DiaChi' => $request['DiaChi'],
            'SDT' => $request['sdtNCC'],
            'Email' => $request['emailNCC'],
            'Fax' => $request['Fax'],
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
        if(Auth::user()->MaQuyen < '3'){
            return view('welcome');
        }
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
        if(Auth::user()->MaQuyen < '3'){
            return view('welcome');
        }
        $provider = NhaCungCap::where('MaNCC',$request->id)->first();
        $vatTu = VatTu::where('MaNCC',$request->id)->get();
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
        foreach($vatTu as $item){
            $item->MaNCC = $request->MaNCC;
            $item->save();
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
    public function destroy($id)
    {
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $provider = NhaCungCap::where('MaNCC',$id)->first();
        $provider->Trang_Thai = true;
        $provider->save();
        return redirect()->back();
    }

    public function searchNCC(Request $request)
    {
        $i = 1;
        $items = DB::table('nha_cung_cap')
            ->select('nha_cung_cap.*')
            ->where('Trang_Thai',false)
            ->where('TenNCC','LIKE','%'.$request->search.'%')
            ->orWhere('DiaChi','LIKE','%'.$request->search.'%')
            ->orderBy('MaNCC','ASC')
            ->paginate(10);
        return view('provider.search',compact('items','i'));
    }

    public function createNew(Request $request)
    {
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $NCC = NhaCungCap::create([
            'TenNCC' => $request['TenNCCNew'],
            'MaNCC' => $request['MaNCCNew'],
            'DiaChi' => $request['DiaChi'],
            'SDT' => $request['sdtNCC'],
            'Email' => $request['emailNCC'],
            'fax' => $request['Fax'],
            'GhiChu' => $request['ghiChu'],
        ]);
        return response()->json($NCC);
    }
}
