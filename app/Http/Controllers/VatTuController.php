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
        if(Auth::user()->MaQuyen < '2'){
            return redirect()->back();
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
            return redirect()->back();
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
            return redirect()->back();
        }
        $DVT = array('Bộ','Cây','Chiếc','Cm','Cuốn','Đôi','Hộp','Kg','Lạng','Lọ','Mét','Tấm','Thanh','Túi','Viên','Cái');
        $item = VatTu::where('MaVT',$id)->get();
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
            return redirect()->back();
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
            return false;
        }
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

    public function report()
    {
        $MaKVT = KhoVatTu::all();
        return view('report.vattu',compact('MaKVT'));
    }

    public function mostImport(){
        $nhap = DB::table('chi_tiet_phieu_nhap')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_nhap.MaVT')
            ->select('vat_tu.TenVT', DB::raw('SUM(chi_tiet_phieu_nhap.SoLuong) as SoLuong'))
            ->groupBy('chi_tiet_phieu_nhap.MaVT')
            ->orderBy('ID','DESC')
            ->get()->toArray();
        $array = [];
        $array[] = ['Vật tư','Số lượng'];
        foreach ($nhap as $value){
            $array[] = [$value->TenVT,json_decode($value->SoLuong)];
        }
        return response()->json($array);
    }

    public function mostInventory(){
        $nhap = DB::table('chi_tiet_kho_vat_tu')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_kho_vat_tu.MaVT')
            ->select('vat_tu.TenVT', DB::raw('SUM(chi_tiet_kho_vat_tu.SoLuongTon) as SoLuong'))
            ->groupBy('chi_tiet_kho_vat_tu.MaVT')
            ->orderBy('ID','DESC')
            ->get()->toArray();
        $array = [];
        $array[] = ['Vật tư','Số lượng'];
        foreach ($nhap as $value){
            $array[] = [$value->TenVT,json_decode($value->SoLuong)];
        }
        return response()->json($array);
    }

    public function mostExport(){
        $xuat = DB::table('chi_tiet_phieu_xuat')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_xuat.MaVT')
            ->select('vat_tu.TenVT', DB::raw('SUM(chi_tiet_phieu_xuat.SoLuong) as SoLuong'))
            ->groupBy('chi_tiet_phieu_xuat.MaVT')
            ->orderBy('ID','DESC')
            ->limit(10)
            ->get()->toArray();
        $array = [];
        $array[] = ['Vật tư','Số lượng'];
        foreach ($xuat as $value){
            $array[] = [$value->TenVT,json_decode($value->SoLuong)];
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
                    $result->where('vat_tu.MaVT','LIKE','%'.$request->TimVT.'%')
                        ->orWhere('vat_tu.TenVT','LIKE','%'.$request->TimVT.'%');
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
                    $result->where('vat_tu.MaVT','LIKE','%'.$request->TimVT.'%')
                        ->orWhere('vat_tu.TenVT','LIKE','%'.$request->TimVT.'%');
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
//                    ->setBorder('A3:L'.$setborder, 'thin')
                    ->setHeight(1,60)
//                    ->setHeight($setHeight1,40)
//                    ->setHeight($setHeight2,20)
                    ->setWidth('A',7)
                    ->setWidth('B',15)
                    ->setWidth('C',15)
                    ->setWidth('D',15)
                    ->setWidth('E',10)
                    ->setWidth('F',18)
                    ->setWidth('G',18)
                    ->setWidth('H',18)
                    ->setWidth('I',18)
//                    ->setWidth('J',10)
//                    ->setWidth('K',20)
//                    ->setWidth('L',20)
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
}