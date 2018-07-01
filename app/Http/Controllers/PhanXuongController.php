<?php

namespace App\Http\Controllers;

use App\PhanXuong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PhanXuongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i = 1;
        $items = PhanXuong::orderBy('MaPX','ASC')->where('Trang_Thai',false)->paginate(10);
        return view('phanxuong.index',compact('items','i'));
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
        return view('phanxuong.create');
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
            'MaPX.required' => 'Mã phân xưởng  không được để trống',
            'TenPX.required' => 'Tên phân xưởng không được để trống',
        ];
        $rules = [
            'MaPX' => 'required|string|max:10|unique:phan_xuong',
            'TenPX' => 'required|string|max:200',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        PhanXuong::create([
           'MaPX' =>$request['MaPX'],
           'TenPX' => $request['TenPX'],
           'GhiChu' =>$request['ghiChu']
        ]);
        return redirect('phanxuong');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->MaQuyen < '3'){
            return view('welcome');
        }
        $factory  = PhanXuong::where('MaPX',$id)->first();
        return view('phanxuong.edit',compact('factory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $provider = PhanXuong::where('MaPX',$request->id)->first();
        $message = [
            'MaPX.required' => 'Mã phân xưởng  không được để trống',
            'TenPX.required' => 'Tên phân xưởng không được để trống',
        ];
        $rules = [
            'MaPX' => 'required|string|max:10',
            'TenPX' => 'required|string|max:200',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $provider->MaPX = $request->all()['MaPX'];
        $provider->TenPX = $request->all()['TenPX'];
        $provider->GhiChu = $request->all()['ghiChu'];
        $provider->save();

        return redirect('/phanxuong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->MaQuyen < '3'){
            return false;
        }
        $factory = PhanXuong::where('MaPX',$id)->first();
        $factory->Trang_Thai = true;
        $factory->save();
        return redirect()->back();
    }

    public function searchPX(Request $request){
        $i = 1;
        $items = DB::table('phan_xuong')
            ->select('phan_xuong.*')
            ->where('Trang_Thai',false)
            ->where('TenPX','LIKE','%'.$request->search.'%')
            ->orWhere('MaPX','LIKE','%'.$request->search.'%')
            ->orderBy('MaPX','ASC')
            ->paginate(10);
        return view('phanxuong.search',compact('items','i'));
    }
}
