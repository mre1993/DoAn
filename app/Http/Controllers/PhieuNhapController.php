<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
use App\ChiTietPhanXuong;
use App\ChiTietPhieuNhap;
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
        $MaPX = PhanXuong::orderBy('MaPX','ASC')->get();
        $MaNCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('phieunhap.create',compact('MaPX','nhanVien','MaNCC'));
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
            'MaPX.required' => 'Mã phân xưởng không được để trống',
            'MaPN.unique' => 'Mã phiếu nhập đã tồn tại',
            'MaPN.required' => 'Mã phiếu nhập không được để trống',
            'MaNCC.required' => 'Mã nhà cung cấp không được để trống',
            'MaVT.required' => 'Mã vật tư không được để trống',
        ];
        $rules = [
            'MaPX' => 'required|string|max:10',
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
            $check = ChiTietPhanXuong::where('MaVT',$request->MaVT[$i])->where('MaPX',$request->MaPX)->first();
            if(!$check){
                ChiTietPhanXuong::create([
                    'MaPX' => $request->MaPX,
                    'MaVT' => $request->MaVT[$i],
                    'SoLuongTon' => $request->SoLuong[$i],
                ]);
            }else{
                $soLuongTon = $check->SoLuongTon;
                $check->SoLuongTon = $request->SoLuong[$i]+$soLuongTon;
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
            'MaPX' => $request->MaPX,
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
        $MaPX = PhanXuong::orderBy('MaPX','ASC')->get();
        $MaNCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('report.phieunhap',compact('MaPX','nhanVien','MaNCC'));
    }

    public function returnReport(Request $request){
        $result = DB::table('phieu_nhap')
            ->select(
                'phieu_nhap.MaPN',
                'phan_xuong.TenPX',
                'nha_cung_cap.TenNCC',
                'nhan_vien.TenNV',
                'phieu_nhap.NoiDung',
                'phieu_nhap.created_at',
                'nha_cung_cap.TenNCC',
                'phan_xuong.TenPX',
                'nhan_vien.TenNV',
                'chi_tiet_phieu_nhap.*',
                'vat_tu.MoTa',
                'vat_tu.TenVT'
            )
            ->join('nha_cung_cap','nha_cung_cap.MaNCC','phieu_nhap.MaNCC')
            ->join('phan_xuong','phan_xuong.MaPX','phieu_nhap.MaPX')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_nhap.MaNV')
            ->join('chi_tiet_phieu_nhap','chi_tiet_phieu_nhap.MaPN','phieu_nhap.MaPN')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_nhap.MaVT')
            ->where(function ($result) use ($request){
                if($request->MaNCC!=null){
                    $result->where('nha_cung_cap.MaNCC','LIKE','%'.$request->MaNCC.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->MaPX!=null){
                    $result->where('phan_xuong.MaPX','LIKE','%'.$request->MaPX.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->TimVT!=null){
                    $result->where('vat_tu.MaVT','LIKE','%'.$request->TimVT.'%')
                        ->orWhere('vat_tu.TenVT','LIKE','%'.$request->TimVT.'%');
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
        $result = DB::table('phieu_nhap')
            ->select(
                'phieu_nhap.MaPN',
                'phan_xuong.TenPX',
                'nha_cung_cap.TenNCC',
                'nhan_vien.TenNV',
                'phieu_nhap.NoiDung',
                'phieu_nhap.created_at',
                'nha_cung_cap.TenNCC',
                'phan_xuong.TenPX',
                'nhan_vien.TenNV',
                'chi_tiet_phieu_nhap.*',
                'vat_tu.MoTa',
                'vat_tu.TenVT'
            )
            ->join('nha_cung_cap','nha_cung_cap.MaNCC','phieu_nhap.MaNCC')
            ->join('phan_xuong','phan_xuong.MaPX','phieu_nhap.MaPX')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_nhap.MaNV')
            ->join('chi_tiet_phieu_nhap','chi_tiet_phieu_nhap.MaPN','phieu_nhap.MaPN')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_nhap.MaVT')
            ->where(function ($result) use ($request){
                if($request->MaNCC!=null){
                    $result->where('nha_cung_cap.MaNCC','LIKE','%'.$request->MaNCC.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->MaPX!=null){
                    $result->where('phan_xuong.MaPX','LIKE','%'.$request->MaPX.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->TimVT!=null){
                    $result->where('vat_tu.MaVT','LIKE','%'.$request->TimVT.'%')
                        ->orWhere('vat_tu.TenVT','LIKE','%'.$request->TimVT.'%');
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

        return view('report.printPhieu',compact('result'));
    }
}

