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
use App\PhieuXuat;
use App\VatTu;
use Carbon\Carbon;
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
        $DVT = array('Bộ','Cây','Chiếc','Cm','Cuốn','Đôi','Hộp','Kg','Lạng','Lọ','Mét','Tấm','Thanh','Túi','Viên','Cái');        $user =  Auth::user();
        $nhanVien = NhanVien::find($user->MaNV);
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->where('Trang_Thai',false)->get();
        $MaNCC = NhaCungCap::orderBy('MaNCC','ASC')->where('Trang_Thai',false)->get();
        return view('phieunhap.create',compact('MaKVT','nhanVien','MaNCC','DVT'));
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

        $month = Carbon::now()->format('m');
        $countPN =  count(PhieuNhap::whereYear('created_at', '=', Carbon::now()->format('Y'))
            ->whereMonth('created_at', '=', Carbon::now()->format('m'))
            ->get()) + 1;
        $maPhieuNhap = $request->MaPN.'-'.$countPN.'_T-'.$month;
        $count = count($request->MaVT);
        for($i=0; $i<$count; $i++){
            $check = ChiTietKhoVT::where('MaVT',$request->MaVT[$i])->where('MaKVT',$request->MaKVT)->first();
            $checkVT = VatTu::where('MaVT',$request->MaVT[$i])->first();
            if(!$check){
                if(!$checkVT){
                    VatTu::create([
                        'MaVT'=> $request->MaVT[$i],
                        'TenVT'=> $request->TenVT[$i],
                        'MaNCC'=> $request->MaNCC,
                        'DVT'=> $request->DVT[$i],
                        'DonGia'=> str_replace(".", "", $request->DonGia[$i]),
                        'MoTa'=> $request->MoTa[$i],
                    ]);
                }
                ChiTietKhoVT::create([
                    'MaKVT' => $request->MaKVT,
                    'MaVT' => $request->MaVT[$i],
                    'SoLuongTon' => str_replace(".", "", $request->SoLuong[$i]),
                    'TongSoLuong' => str_replace(".", "", $request->SoLuong[$i])
                ]);
            }else{
                $soLuongHong = $check->SoLuongHong;
                $soLuongTon = $check->SoLuongTon;
                $check->SoLuongTon = str_replace(".", "", $request->SoLuong[$i])+$soLuongTon;
                $check->TongSoLuong = str_replace(".", "", $request->SoLuong[$i])+$soLuongTon+$soLuongHong;
                $check->save();
                $checkVT->save();
            }
            ChiTietPhieuNhap::create([
                'MaPN' => $maPhieuNhap,
                'MaVT' => $request->MaVT[$i],
                'SoLuong' => str_replace(".", "", $request->SoLuong[$i]),
                'DonGia' => str_replace(".", "", $request->DonGia[$i]),
                'ThanhTien' => str_replace(".", "", $request->ThanhTien[$i]),
            ]);
        }
        PhieuNhap::create([
            'MaPN' => $maPhieuNhap,
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
    public function edit($id)
    {
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        $phieuNhap = PhieuNhap::where('MaPN',$id)->first();
        $values = ChiTietPhieuNhap::where('MaPN',$phieuNhap->MaPN)->get();
        $DVT = array('Bộ','Cây','Chiếc','Cm','Cuốn','Đôi','Hộp','Kg','Lạng','Lọ','Mét','Tấm','Thanh','Túi','Viên','Cái');        $user =  Auth::user();
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        $MaNCC = NhaCungCap::orderBy('MaNCC','ASC')->get();
        return view('phieunhap.edit',compact('MaKVT','MaNCC','DVT','phieuNhap','values'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        $phieuNhap = PhieuNhap::where('MaPN',$request->MaPN)->first();
        $itemsDel =  ChiTietPhieuNhap::whereNotIn('MaVT',$request->MaVT)->where('MaPN',$request->MaPN)->get();
        if($itemsDel != null){
            foreach($itemsDel as $itemDel){
                $check = ChiTietKhoVT::where('MaVT',$itemDel->MaVT)->where('MaKVT',$phieuNhap->MaKVT)->first();
                if($itemDel->SoLuong > $check->SoLuongTon){
                    return redirect()->back()->withErrors(['Số lượng tồn kho nhỏ hơn số lượng nhập']);
                }
                $check->SoLuongTon = $check->SoLuongTon - $itemDel->SoLuong;
                $check->TongSoLuong = $check->TongSoLuong - $itemDel->SoLuong;
                $check->save();
                $itemDel->delete();
            }
        }
        $count = count($request->MaVT);
        for($i=0;$i<= $count-1;$i++){
            $checkPhieuNhap = ChiTietPhieuNhap::where('MaVT',$request->MaVT[$i])->where('MaPN',$request->MaPN)->first();
            $checkKhoVatTu = ChiTietKhoVT::where('MaVT',$request->MaVT[$i])->where('MaKVT',$phieuNhap->MaKVT)->first();
            if(!$checkPhieuNhap){
                if(!$checkKhoVatTu){
                    $checkVatTu = VatTu::where('MaVT',$request->MaVT[$i])->get();
                    if(!$checkVatTu){
                        VatTu::create([
                            'MaVT'=> $request->MaVT[$i],
                            'TenVT'=> $request->TenVT[$i],
                            'MaNCC'=> $request->MaNCC,
                            'DVT'=> $request->DVT[$i],
                            'DonGia'=> str_replace(".", "", $request->DonGia[$i]),
                            'MoTa'=> $request->MoTa[$i],
                        ]);
                    }
                    ChiTietKhoVT::create([
                        'MaKVT' => $request->MaKVT,
                        'MaVT' => $request->MaVT[$i],
                        'SoLuongTon' => str_replace(".", "", $request->SoLuong[$i]),
                        'TongSoLuong' => str_replace(".", "", $request->SoLuong[$i])
                    ]);
                }else{
                    $checkKhoVatTu->SoLuongTon = $checkKhoVatTu->SoLuongTon + str_replace(".", "", $request->SoLuong[$i]);
                    $checkKhoVatTu->TongSoLuong = $checkKhoVatTu->TongSoLuong + str_replace(".", "", $request->SoLuong[$i]);
                    $checkKhoVatTu->save();
                }
                ChiTietPhieuNhap::create([
                    'MaPN' => $request->MaPN,
                    'MaVT' => $request->MaVT[$i],
                    'SoLuong' => str_replace(".", "", $request->SoLuong[$i]),
                    'DonGia' => str_replace(".", "", $request->DonGia[$i]),
                    'ThanhTien' => str_replace(".", "", $request->ThanhTien[$i]),
                ]);
            }else{
                $checkKhoVatTu->MaKVT = $request->MaKVT;
                $checkKhoVatTu->SoLuongTon = $checkKhoVatTu->SoLuongTon + str_replace(".", "", $request->SoLuong[$i]) - $checkPhieuNhap->SoLuong ;
                $checkKhoVatTu->TongSoLuong = $checkKhoVatTu->TongSoLuong + str_replace(".", "", $request->SoLuong[$i]) - $checkPhieuNhap->SoLuong ;
                $checkPhieuNhap->SoLuong = str_replace(".", "", $request->SoLuong[$i]);
                $checkPhieuNhap->DonGia = str_replace(".", "", $request->DonGia[$i]);
                $checkPhieuNhap->ThanhTien =  str_replace(".", "", $request->ThanhTien[$i]);
                $checkKhoVatTu->save();
                $checkPhieuNhap->save();
            }
        }
        $phieuNhap->MaKVT = $request->MaKVT;
        $phieuNhap->MaNCC = $request->MaNCC;
        $phieuNhap->save();
        return redirect('phieunhap');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $phieuNhap = PhieuNhap::where('MaPN',$request->MaPN)->first();
        $vatTuPhieuNhap = ChiTietPhieuNhap::where('MaPN',$request->MaPN)->get();
        foreach ($vatTuPhieuNhap as $item){
            $vatTuKho = ChiTietKhoVT::where('MaVT',$item->MaVT)->where('MaKVT',$phieuNhap->MaKVT)->first();
            $vatTu = VatTu::where('MaVT',$item->MaVT)->first();
            $soLuongTonCu = $vatTuKho->SoLuongTon;
            $soLuongNhapKho= $item->SoLuong;
            $soLuongTonMoi = $soLuongTonCu - $soLuongNhapKho;
            $vatTuKho->SoLuongTon = $soLuongTonMoi;
            $vatTuKho->TongSoLuong = $vatTuKho->TongSoLuong - $soLuongTonCu;
            $vatTuKho->save();
            $vatTu->save();
            $item->delete();
        }
        $phieuNhap->delete();
        return redirect()->back();
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
        $countItem = count($vatTu)+7;
        $setBoder = "A6:H$countItem";
        foreach($vatTu as $item){
            $sumSL = $sumSL + $item->SoLuong;
            $sumTT = $sumTT + $item->ThanhTien;
        }
        Excel::create('New', function($excel) use($vatTu,$phieuNhap,$i,$sumSL,$sumTT,$setBoder) {
            $excel->sheet('First sheet', function($sheet)  use($vatTu,$phieuNhap,$i,$sumSL,$sumTT,$setBoder) {
                $sheet->loadView('phieunhap.showExport')
                    ->setHeight('1',50)
                    ->setHeight('3',20)
                    ->setHeight('4',20)
                    ->setHeight('5',20)
                    ->mergeCells('A1:H1')
                    ->setWidth('A',5)
                    ->setBorder('A1', 'thin')
                    ->setBorder($setBoder, 'thin')
                    ->setWidth('B',19)
                    ->setWidth('C',19)
                    ->setWidth('D',10)
                    ->setWidth('E',10)
                    ->setWidth('F',10)
                    ->setWidth('G',10)
                    ->setWidth('H',17)
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
                    ->mergeCells('A1:L1')
                    ->mergeCells('A2:L2')
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

