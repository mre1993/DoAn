<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
use App\ChiTietPhanXuong;
use App\ChiTietPhieuNhap;
use App\NhaCungCap;
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
        $items = VatTu::orderBy('MaVT','ASC')->paginate(10);
        $i = 1;
        return view('vattu.index',compact('items','i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $DVT = array('Bộ','Cây','Chiếc','Cm','Cuốn','Đôi','Hộp','Kg','Lạng','Lọ','Mét','Tấm','Thanh','Túi','Viên','Cái');
        $NCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('vattu.create',compact('NCC','DVT'));
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
            'DonGia.required' => 'Đơn giá không được để trống',
            'DonGia.numeric' => 'Đơn giá phải là số',
        ];
        $rules = [
            'MaVT' => 'required|string|max:10|unique:vat_tu',
            'TenVT' => 'required|string|max:200',
            'DVT' => 'required|string|max:200',
            'DonGia' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        VatTu::create([
            'MaVT' =>$request->MaVT,
            'TenVT' => $request->TenVT,
            'DVT' => $request->DVT,
            'MaNCC' => $request->MaNCC,
            'DonGia' => $request->DonGia,
            'MoTa' =>$request->MoTa
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
        $DVT = array('Bộ','Cây','Chiếc','Cm','Cuốn','Đôi','Hộp','Kg','Lạng','Lọ','Mét','Tấm','Thanh','Túi','Viên','Cái');
        $item = VatTu::find($id);
        $NCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('vattu.edit',compact('item','NCC','DVT'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VatTu  $vatTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $item = VatTu::where('MaVT',$request->id)->first();
        $message = [
            'MaVT.required' => 'Mã vật tư  không được để trống',
            'TenVT.required' => 'Tên vật tư không được để trống',
            'DVT.required'  => 'Đơn vị tính không được để trống',
            'DonGia.required' => 'Đơn giá không được để trống',
            'DonGia.numeric' => 'Đơn giá phải là số',
        ];
        $rules = [
            'MaVT' => 'required|string|max:10',
            'TenVT' => 'required|string|max:200',
            'DVT' => 'required|string|max:200',
            'DonGia' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $chiTietPhieuNhap = ChiTietPhieuNhap::where('MaVT',$request->MaVT)->get();
//        $chiTietPhieuXuat = ChiTietPhieuXuat::where('MaVT',$request->MaVT)->get();
        $chiTietKhoVT = ChiTietKhoVT::where('MaVT',$request->MaVT)->get();
        foreach($chiTietPhieuNhap as $item1){
            $item1->MaVT = $request->MaVT;
            $item1->save();
        }
//        foreach($chiTietPhieuXuat as $item2){
//            $item2->MaVT = $request->MaVT;
//            $item2->save();
//        }
        foreach($chiTietKhoVT as $item3){
            $item3->MaVT = $request->MaVT;
            $item3->save();
        }
        $item->MaVT = $request->MaVT;
        $item->TenVT = $request->TenVT;
        $item->DVT = $request->DVT;
        $item->MaNCC = $request->MaNCC;
        $item->DonGia = $request->DonGia;
        $item->MoTa = $request->MoTa;
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

    public function search($request){
        $result = VatTu::where('TenVT','LIKE','%'.$request.'%')->get();
        return response()->json($result);
    }

    public function getVT($request){
        $result = VatTu::where('MaVT',$request)->first();
        return response()->json($result);
    }

    public function report(){
        return view('report.vattu');

    public function mostSupplies(){
        $vatTuPX = ChiTietPhanXuong::all();
        $vatTuKhoVT = ChiTietKhoVT::all();
        $array1 = array();
        $array2 = array();
        $array3 = array();
        foreach($vatTuPX as $item1)
        {
            $array1[] = [$item1->VatTu->TenVT,$item1->SoLuongTon];
        }

        foreach($vatTuKhoVT as $item2)
        {
            $array2[] = [$item2->VatTu->TenVT,$item2->SoLuongTon];
        }
        $count1 = count($array1);
        $count2 = count($array2);
        $key1 = array();
        $key2 = array();
        for($i=0;$i<$count1;$i++){
            for($j=0;$j<$count2;$j++){
                if($array1[$i][0]=== $array2[$j][0]){
                    $array3[] = [$array1[$i][0],$array1[$i][1] + $array2[$j][1]];
                    $key1[] = $i;
                    $key2[] =$j;
                }
            }
        }
        $array1 = array_diff_key($array1,$key1);
        $array2 = array_diff_key($array2,$key2);
        $array1 = array_merge($array1,$array2);
        $array1 = array_merge($array1,$array3);
        $sum = 0;
        foreach($array1 as $key => $item){
            $sum = $sum + $item[1];
        }
        array_unshift($array1,['Vật tư','Số lượng mỗi loại vật tư']);
        return response()->json($array1);
    }
}