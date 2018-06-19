<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
use App\ChiTietPhanXuong;
use App\ChiTietPhieuNhap;
use App\KhoVatTu;
use App\NhaCungCap;
use App\NhanVien;
use App\PhanXuong;
use App\PhieuNhap;
use App\VatTu;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class PhieuNhapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i = 1;
        $items = PhieuNhap::orderBy('MaPN','ASC')->paginate(10);
        return view('phieunhap.index',compact('items','i'));
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
        $user =  Auth::user();
        $nhanVien = NhanVien::find($user->MaNV);
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        $MaNCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('phieunhap.create',compact('MaKVT','nhanVien','MaNCC'));
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
            'MaKVT.required' => 'Mã kho vật tư không được để trống',
            'MaPN.unique' => 'Mã phiếu nhập đã tồn tại',
            'MaPN.required' => 'Mã phiếu nhập không được để trống',
            'MaNCC.required' => 'Mã nhà cung cấp không được để trống',
            'MaVT.required' => 'Mã vật tư không được để trống',
        ];
        $rules = [
            'MaKVT' => 'required|string|max:10',
            'MaPN' => 'required|string|max:10|unique:phieu_nhap',
            'MaNCC' => 'required|string|max:10',
            'MaVT' => 'required|max:10',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        $count = count($request->MaVT);
        for($i=0; $i<$count; $i++){
            $check = ChiTietKhoVT::where('MaVT',$request->MaVT[$i])->where('MaKVT',$request->MaKVT)->first();
            if(!$check){
                ChiTietKhoVT::create([
                    'MaKVT' => $request->MaKVT,
                    'MaVT' => $request->MaVT[$i],
                    'SoLuongTon' => $request->SoLuong[$i],
                    'TongSoLuong' => $request->SoLuong[$i]
                ]);
            }else{
                $soLuongHong = $check->SoLuongHong;
                $soLuongTon = $check->SoLuongTon;
                $check->SoLuongTon = $request->SoLuong[$i]+$soLuongTon;
                $check->TongSoLuong = $request->SoLuong[$i]+$soLuongTon+$soLuongHong;
                $check->DonGia = $request->DonGia;
                $check->save();
            }
            ChiTietPhieuNhap::create([
                'MaPN' => $request->MaPN,
                'MaVT' => $request->MaVT[$i],
                'SoLuong' => $request->SoLuong[$i],
                'DonGia' => $request->DonGia[$i],
                'ThanhTien' => $request->ThanhTien[$i],
            ]);
        }

        PhieuNhap::create([
            'MaPN' =>$request->MaPN,
            'MaKVT' => $request->MaKVT,
            'MaNV' => $request->MaNV,
            'MaNCC' => $request->MaNCC,
            'NoiDung' => $request->NoiDung,
        ]);
        return redirect('phieunhap');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chiTiet = ChiTietPhieuNhap::where('MaPN',$id)->orderBy('id','ASC')->get();
        $phieuNhap = PhieuNhap::where('MaPN',$id)->first();
        $i=1;
        $sumSL = 0;
        $sumTT = 0;
        foreach($chiTiet as $item){
            $sumSL = $sumSL + $item->SoLuong;
            $sumTT = $sumTT + $item->ThanhTien;
        }
        return view('phieunhap.show',compact('phieuNhap','chiTiet','i','sumTT','sumSL'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function edit(PhieuNhap $phieuNhap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhieuNhap $phieuNhap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuNhap $phieuNhap)
    {
        //
    }

//    public function search($request){
//        $result = VatTu::where('TenVT','LIKE','%'.$request.'%')->get();
//        return response()->json($result);
//    }

//    public function getVT($request){
//        $result = VatTu::where('MaVT',$request)->first();
//        return response()->json($result);
//    }

    public function printExcel($id)
    {
        $vatTu = ChiTietPhieuNhap::where('MaPN',$id)->orderBy('id','ASC')->get();
        $phieuNhap = PhieuNhap::where('MaPN',$id)->first();
        $i=1;
        $sumSL = 0;
        $sumTT = 0;
        foreach($vatTu as $item){
            $sumSL = $sumSL + $item->SoLuong;
            $sumTT = $sumTT + $item->ThanhTien;
        }
        Excel::create('New', function($excel) use($vatTu,$phieuNhap,$i,$sumSL,$sumTT) {

            $excel->sheet('First sheet', function($sheet)  use($vatTu,$phieuNhap,$i,$sumSL,$sumTT) {
                $sheet->loadView('phieunhap.showExport')
                    ->mergeCells('B1:G2')
                    ->mergeCells('B1:G1')
                    ->mergeCells('B1:B2')
                    ->with('vatTu' , $vatTu)
                    ->with('phieuNhap' , $phieuNhap)
                    ->with('sumSL' , $sumSL)
                    ->with('sumTT' , $sumTT)
                    ->with('i' , $i);
            });
        })->download('xlsx');
    }

    public function report(){
        $user =  Auth::user();
        $nhanVien = NhanVien::find($user->MaNV);
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        $MaNCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('report.phieunhap',compact('MaKVT','nhanVien','MaNCC'));
    }

    public function returnReport(Request $request){
        $result = DB::table('phieu_nhap')
            ->select(
                'phieu_nhap.MaPN',
                'kho_vat_tu.MaKVT',
                'nha_cung_cap.TenNCC',
                'nhan_vien.TenNV',
                'phieu_nhap.NoiDung',
                'phieu_nhap.created_at',
                'nha_cung_cap.TenNCC',
                'kho_vat_tu.TenKVT',
                'nhan_vien.TenNV',
                'chi_tiet_phieu_nhap.*',
                'vat_tu.MoTa',
                'vat_tu.TenVT'
            )
            ->join('nha_cung_cap','nha_cung_cap.MaNCC','phieu_nhap.MaNCC')
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','phieu_nhap.MaKVT')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_nhap.MaNV')
            ->join('chi_tiet_phieu_nhap','chi_tiet_phieu_nhap.MaPN','phieu_nhap.MaPN')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_nhap.MaVT')
            ->where(function ($result) use ($request){
                if($request->MaNCC!=null){
                    $result->where('nha_cung_cap.MaNCC','LIKE','%'.$request->MaNCC.'%');
                }
            })
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
                if($request->TenNV!=null){
                    $result->where('nhan_vien.TenNV','LIKE','%'.$request->TenNV.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->MaPN!=null){
                    $result->where('phieu_nhap.MaPN','LIKE','%'.$request->MaPN.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_from!=null){
                    $result->whereDate('phieu_nhap.created_at','>=',$request->date_from);
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_to!=null){
                    $result->whereDate('phieu_nhap.created_at','<=',$request->date_to);
                }
            })
            ->orderBy('phieu_nhap.MaPN')->get();
        return response()->json($result);
    }

    public function printReport(Request $request){
        $check = 'PhieuNhap';
        $i= 1;
        $result = DB::table('phieu_nhap')
            ->select(
                'phieu_nhap.MaPN',
                'kho_vat_tu.TenKVT',
                'nha_cung_cap.TenNCC',
                'nhan_vien.TenNV',
                'phieu_nhap.NoiDung',
                'phieu_nhap.created_at',
                'nha_cung_cap.TenNCC',
                'kho_vat_tu.TenKVT',
                'nhan_vien.TenNV',
                'chi_tiet_phieu_nhap.*',
                'vat_tu.MoTa',
                'vat_tu.TenVT'
            )
            ->join('nha_cung_cap','nha_cung_cap.MaNCC','phieu_nhap.MaNCC')
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','phieu_nhap.MaKVT')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_nhap.MaNV')
            ->join('chi_tiet_phieu_nhap','chi_tiet_phieu_nhap.MaPN','phieu_nhap.MaPN')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_nhap.MaVT')
            ->where(function ($result) use ($request){
                if($request->MaNCC!=null){
                    $result->where('nha_cung_cap.MaNCC','LIKE','%'.$request->MaNCC.'%');
                }
            })
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
                if($request->TenNV!=null){
                    $result->where('nhan_vien.TenNV','LIKE','%'.$request->TenNV.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->MaPN!=null){
                    $result->where('phieu_nhap.MaPN','LIKE','%'.$request->MaPN.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_from!=null){
                    $result->whereDate('phieu_nhap.created_at','>=',$request->date_from);
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_to!=null){
                    $result->whereDate('phieu_nhap.created_at','<=',$request->date_to);
                }
            })
            ->orderBy('phieu_nhap.MaPN')->get();
        $count = count($result);
        $setborder = $count + 3;
        $setHeight1 = $count + 4;
        $setHeight2 = $count + 5;
        $myFile = Excel::create('New', function($excel) use($result,$i,$check,$count,$setborder,$setHeight1,$setHeight2) {
            $excel->sheet('First sheet', function($sheet)  use($result,$i,$check,$count,$setborder,$setHeight1,$setHeight2) {
                $sheet->loadView('report.printPhieu')
                    ->setBorder('A3:L'.$setborder, 'thin')
                    ->setHeight(1,50)
                    ->setHeight($setHeight1,40)
                    ->setHeight($setHeight2,20)
                    ->setWidth('A',7)
                    ->setWidth('B',15)
                    ->setWidth('C',10)
                    ->setWidth('D',30)
                    ->setWidth('E',18)
                    ->setWidth('F',18)
                    ->setWidth('G',10)
                    ->setWidth('H',8)
                    ->setWidth('I',15)
                    ->setWidth('J',10)
                    ->setWidth('K',20)
                    ->setWidth('L',20)
                    ->with('i' , $i)
                    ->with('result' , $result)
                    ->with('check' , $check);
            });
        });
        $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
        $response =  array(
            'name' => "filename", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
//        return view('report.printPhieu',compact('result','i','check'));
    }

    public function searchPhieuNhap(Request $request)
    {
        $i = 1;
        $items = DB::table('phieu_nhap')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_nhap.MaNV')
            ->join('nha_cung_cap','nha_cung_cap.MaNCC','phieu_nhap.MaNCC')
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','phieu_nhap.MaKVT')
            ->select('phieu_nhap.*','nhan_vien.TenNV','kho_vat_tu.TenKVT','nha_cung_cap.TenNCC')
            ->where('phieu_nhap.MaPN','LIKE','%'.$request->search.'%')
            ->orWhere('nhan_vien.TenNV','LIKE','%'.$request->search.'%')
            ->orWhere('kho_vat_tu.TenKVT','LIKE','%'.$request->search.'%')
            ->orWhere('nha_cung_cap.TenNCC','LIKE','%'.$request->search.'%')
            ->orderBy('phieu_nhap.MaPN','ASC')
            ->paginate(10);
        return view('phieunhap.search',compact('items','i'));
    }
}

