<?php

namespace App\Http\Controllers;

use App\PhanXuong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhanXuongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = PhanXuong::orderBy('id','DESC')->paginate(10);
        return view('phanxuong.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $factory = PhanXuong::find($id);
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
        $provider = PhanXuong::find($request->all()['id']);
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
        $factory = PhanXuong::find($id);
        $factory->delete();
        return redirect()->back();
    }
}
