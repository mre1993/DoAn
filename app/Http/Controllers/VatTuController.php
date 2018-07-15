<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
use App\ChiTietPhanXuong;
use App\ChiTietPhieuNhap;
use App\KhoVatTu;
use App\NhaCungCap;
use App\VatTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class VatTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = VatTu::orderBy('MaVT','ASC')->where('Trang_Thai',false)->paginate(10);
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
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
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
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
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
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        $DVT = array('Bộ','Cây','Chiếc','Cm','Cuốn','Đôi','Hộp','Kg','Lạng','Lọ','Mét','Tấm','Thanh','Túi','Viên','Cái');
        $item = VatTu::where('MaVT',$id)->first();
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
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
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
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        $item = VatTu::find($id);
        $checkTonKho = DB::table('chi_tiet_kho_vat_tu')->select(DB::raw('SUM(SoLuongTOn) as SoLuongTon'))->first();
        if($checkTonKho->SoLuongTon > 0){
            return redirect()->back()->withErrors(['Không thể xóa vật tư còn tồn kho']);
        }
        $item->Trang_Thai = true;
        $item->save();
        return redirect()->back();
    }

    public function searchPN(Request $request){
        $result = DB::table('vat_tu')
            ->join('nha_cung_cap','nha_cung_cap.MaNCC','vat_tu.MaNCC')
            ->select('vat_tu.*')
            ->where('vat_tu.Trang_Thai',false)
            ->where(function ($result) use ($request){
                if($request->MaNCC!=null){
                    $result->where('TenVT','LIKE','%'.$request->term.'%')
                        ->where('nha_cung_cap.MaNCC','LIKE','%'.$request->MaNCC.'%');
                }else{
                    $result->where('TenVT','LIKE','%'.$request->term.'%');
                }
            })->get();
        return response()->json($result);
    }

    public function searchPX(Request $request){
        $result = DB::table('chi_tiet_kho_vat_tu')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->join('kho_vat_tu','chi_tiet_kho_vat_tu.MaKVT','kho_vat_tu.MaKVT')
            ->select('chi_tiet_kho_vat_tu.MaVT','vat_tu.TenVT')
            ->where('vat_tu.Trang_Thai',false)
            ->where(function ($result) use ($request){
                if($request->MaKVT!=null){
                    $result->where('TenVT','LIKE','%'.$request->term.'%')
                    ->where('chi_tiet_kho_vat_tu.MaKVT','LIKE','%'.$request->MaKVT.'%');
                }else{
                    $result->where('TenVT','LIKE','%'.$request->term.'%');
                }
            })
            ->get();
        return response()->json($result);
    }

    public function searchVT($request){
        $result = VatTu::where('TenVT','LIKE','%'.$request.'%')->where('Trang_Thai',false)->get();
        return response()->json($result);
    }

    public function getVT($request){
        $result = VatTu::where('MaVT',$request)->where('Trang_Thai',false)->first();
        return response()->json($result);
    }

    public function getVTX($request){
        $result = DB::table('vat_tu')
            ->join('chi_tiet_kho_vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->select('chi_tiet_kho_vat_tu.*','vat_tu.*')
            ->where('vat_tu.Trang_Thai',false)
            ->where('vat_tu.MaVT',$request)
            ->first();
        return response()->json($result);
    }

    public function report()
    {
        $MaKVT = KhoVatTu::where('Trang_Thai',false)->get();
        return view('report.vattu',compact('MaKVT'));
    }

    public function mostImport(){
        $nhap = DB::table('chi_tiet_phieu_nhap')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_nhap.MaVT')
            ->select('vat_tu.TenVT', DB::raw('SUM(chi_tiet_phieu_nhap.SoLuong) as SoLuong'))
            ->groupBy('chi_tiet_phieu_nhap.MaVT')
            ->orderBy('chi_tiet_phieu_nhap.SoLuong','DESC')
            ->limit(5)
            ->get()->toArray();
        $array = [];
        $check = DB::table('chi_tiet_phieu_nhap')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_nhap.MaVT')
            ->select(DB::raw('SUM(chi_tiet_phieu_nhap.SoLuong) as SoLuong1'))
            ->where(function ($result) use ($nhap){
                foreach ($nhap as $item){
                    $result->where('vat_tu.TenVT', '!=', $item->TenVT);
                }
            })
            ->groupBy('chi_tiet_phieu_nhap.MaVT')
            ->orderBy('chi_tiet_phieu_nhap.SoLuong','DESC')
            ->get()->toArray();
        foreach ($nhap as $value){
            $array[] = array(
                'name' => $value->TenVT,
                'number' => json_decode($value->SoLuong));
        }
        if(!empty($check)){
            $array[] = array('name' => 'Loại khác', 'number' => json_decode($check[0]->SoLuong1));
        }
        return response()->json($array);
    }

    public function mostInventory(){
        $nhap = DB::table('chi_tiet_kho_vat_tu')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->select('vat_tu.TenVT', DB::raw('SUM(chi_tiet_kho_vat_tu.SoLuongTon) as SoLuong'))
            ->groupBy('chi_tiet_kho_vat_tu.MaVT')
            ->orderBy('chi_tiet_kho_vat_tu.SoLuongTon','DESC')
            ->limit(5)
            ->get()->toArray();
        $array = [];
        $check = DB::table('chi_tiet_kho_vat_tu')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->select(DB::raw('SUM(chi_tiet_kho_vat_tu.SoLuongTon) as SoLuongTon'))
            ->where(function ($result) use ($nhap){
                foreach ($nhap as $item){
                    $result->where('vat_tu.TenVT', '!=', $item->TenVT);
                }
            })
            ->groupBy('chi_tiet_kho_vat_tu.MaVT')
            ->orderBy('chi_tiet_kho_vat_tu.SoLuongTon','DESC')
            ->get()->toArray();
        foreach ($nhap as $value){
            $array[] = array(
                'name' => $value->TenVT,
                'number' => json_decode($value->SoLuong));
        }
        if(!empty($check)){
            $array[] = array('name' => 'Loại khác', 'number' => json_decode($check[0]->SoLuongTon));
        }
        return response()->json($array);
    }

    public function mostExport(){
        $xuat = DB::table('chi_tiet_phieu_xuat')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_xuat.MaVT')
            ->select('vat_tu.TenVT', DB::raw('SUM(chi_tiet_phieu_xuat.SoLuong) as SoLuong'))
            ->groupBy('chi_tiet_phieu_xuat.MaVT')
            ->orderBy('chi_tiet_phieu_xuat.SoLuong','DESC')
            ->limit(5)
            ->get()->toArray();
        $array = [];
        $check = DB::table('chi_tiet_phieu_xuat')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_xuat.MaVT')
            ->select(DB::raw('SUM(chi_tiet_phieu_xuat.SoLuong) as SoLuong1'))
            ->where(function ($result) use ($xuat){
                foreach ($xuat as $item){
                    $result->where('vat_tu.TenVT', '!=', $item->TenVT);
                }
            })
            ->groupBy('chi_tiet_phieu_xuat.MaVT')
            ->orderBy('chi_tiet_phieu_xuat.Soluong','DESC')
            ->get()->toArray();
        foreach ($xuat as $value){
            $array[] = array(
                'name' => $value->TenVT,
                'number' => json_decode($value->SoLuong));
        }
        if(!empty($check)){
            $array[] = array('name' => 'Loại khác', 'number' => json_decode($check[0]->SoLuong1));
        }
        return response()->json($array);
    }


    public function returnReport(Request $request){
        $result = DB::table('chi_tiet_kho_vat_tu')
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','chi_tiet_kho_vat_tu.MaKVT')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->select('vat_tu.*','kho_vat_tu.TenKVT','chi_tiet_kho_vat_tu.*'
            )
            ->where(function ($result) use ($request){
                if($request->MaKVT!=null){
                    $result->where('kho_vat_tu.MaKVT','LIKE','%'.$request->MaKVT.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->TimVT!=null){
                    $result->where('vat_tu.TenVT','LIKE','%'.$request->TimVT.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->start!=null) {
                    $result->where('chi_tiet_kho_vat_tu.SoLuongTon', '>=', $request->start);
                }
            })
            ->where(function ($result) use ($request){
                if($request->end!=null){
                    $result->where('chi_tiet_kho_vat_tu.SoLuongTon','<=',$request->end);
                }
            })
            ->orderBy('chi_tiet_kho_vat_tu.MaKVT','DESC')->get();

        return response()->json($result);
    }

    public function printTon(Request $request){
        $i=1;
        $result = DB::table('chi_tiet_kho_vat_tu')
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','chi_tiet_kho_vat_tu.MaKVT')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->select('vat_tu.*','kho_vat_tu.TenKVT','chi_tiet_kho_vat_tu.*'
            )
            ->where(function ($result) use ($request){
                if($request->MaKVT!=null){
                    $result->where('kho_vat_tu.MaKVT','LIKE','%'.$request->MaKVT.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->TimVT!=null){
                    $result->where('vat_tu.TenVT','LIKE','%'.$request->TimVT.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->start!=null) {
                    $result->where('chi_tiet_kho_vat_tu.SoLuongTon', '>=', $request->start);
                }
            })
            ->where(function ($result) use ($request){
                if($request->end!=null){
                    $result->where('chi_tiet_kho_vat_tu.SoLuongTon','<=',$request->end);
                }
            })
            ->orderBy('chi_tiet_kho_vat_tu.MaKVT','DESC')->get();
        $count = count($result);
        $setborder = $count + 3;
        $setHeight1 = $count + 4;
        $setHeight2 = $count + 5;
        $myFile =  Excel::create('New', function($excel) use($result,$i,$count,$setborder,$setHeight1,$setHeight2) {
            $excel->sheet('First sheet', function($sheet)  use($result,$i,$count,$setborder,$setHeight1,$setHeight2) {
                $sheet->loadView('report.printTon')
                    ->mergeCells('A1:G1')
                    ->mergeCells('A2:G2')
                    ->setBorder('A3:G'.$setHeight1, 'thin')
                    ->mergeCells('A'.$setHeight1.':E'.$setHeight1)
                    ->mergeCells('E'.($setHeight1+1).':G'.($setHeight1+1))
                    ->mergeCells('A'.($setHeight1+2).':C'.($setHeight1+2))
                    ->mergeCells('E'.($setHeight1+2).':G'.($setHeight1+2))
                    ->mergeCells('A'.($setHeight1+3).':C'.($setHeight1+3))
                    ->mergeCells('E'.($setHeight1+3).':G'.($setHeight1+3))
                    ->setWidth('A',7)
                    ->setHeight(1,50)
                    ->setWidth('B',15)
                    ->setWidth('C',15)
                    ->setWidth('D',15)
                    ->setWidth('E',10)
                    ->setWidth('F',18)
                    ->setWidth('G',20)
                    ->with('i' , $i)
                    ->with('result' , $result);
            });
        });
        $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
        $response =  array(
            'name' => "filename", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
//        return view('report.printTon');
    }

    public function searchVTIndex(Request $request){
        $i = 1;
        $items = DB::table('vat_tu')
            ->join('nha_cung_cap','nha_cung_cap.MaNCC','vat_tu.MaNCC')
            ->select('vat_tu.*','nha_cung_cap.TenNCC')
            ->where('vat_tu.Trang_Thai',false)
            ->where('vat_tu.TenVT','LIKE','%'.$request->search.'%')
            ->orWhere('vat_tu.MaVT','LIKE','%'.$request->search.'%')
            ->orWhere('nha_cung_cap.TenNCC','LIKE','%'.$request->search.'%')
            ->orderBy('vat_tu.MaVT','ASC')
            ->paginate(10);
        return view('vattu.search',compact('items','i'));
    }

}