<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
use App\ChiTietPhanXuong;
use App\ChiTietPhieuXuat;
use App\KhoVatTu;
use App\PhanXuong;
use App\PhieuXuat;
use App\VatTu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\NhanVien;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class PhieuXuatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i = 1;
        $items = PhieuXuat::orderBy('created_at','ASC')->paginate(10);
        return view('phieuxuat.index',compact('items','i'));
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
        $listNV = NhanVien::all();
        $MaPX = PhanXuong::orderBy('MaPX','ASC')->get();
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        return view('phieuxuat.create',compact('MaPX','nhanVien','MaKVT','listNV'));
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
            'MaPX.required' => 'Mã phân xưởng không được để trống',
            'MaPhieuXuat.unique' => 'Mã phiếu xuất đã tồn tại',
            'MaPhieuXuat.required' => 'Mã phiếu xuất không được để trống',
            'MaKVT.required' => 'Mã kho vật tư không được để trống',
            'MaVT.required' => 'Mã vật tư không được để trống',
            'MaNV.required' => 'Mã nhân viên không được để trống',
        ];
        $rules = [
            'MaPX' => 'required|string|max:10',
            'MaPhieuXuat' => 'required|string|max:10|unique:phieu_xuat',
            'MaKVT' => 'required|string|max:10',
            'MaVT' => 'required|max:10',
            'MaNV' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        $count = count($request->MaVT);
        $month = Carbon::now()->format('m');
        $countPX =  count(PhieuXuat::whereYear('created_at', '=', Carbon::now()->format('Y'))
            ->whereMonth('created_at', '=', $month)
            ->get()) + 1;
        $maPhieuXuat = $request->MaPhieuXuat.'-'.$countPX.'_T-'.$month;
        for($i=0; $i<$count; $i++){
            $check = ChiTietKhoVT::where('MaVT',$request->MaVT[$i])->where('MaKVT',$request->MaKVT)->first();
            if(!$check){
                return redirect()->back()->withErrors(['Không có vật tư trong kho, hãy lựa chọn lại']);
            }
            if($check->SoLuongTon < str_replace(".", "", $request->SoLuong[$i])){
                return redirect()->back()->withErrors(['Số lượng tồn kho nhỏ hơn số lượng xuất']);
            }
            $soLuongTon = $check->SoLuongTon;
            $tongSoLuong = $check->TongSoLuong;
            $check->SoLuongTon = $soLuongTon - str_replace(".", "", $request->SoLuong[$i]);
            $check->TongSoLuong = $tongSoLuong - str_replace(".", "", $request->SoLuong[$i]);
            $check->save();

            ChiTietPhieuXuat::create([
                'MaPhieuXuat' => $maPhieuXuat,
                'MaVT' => $request->MaVT[$i],
                'SoLuong' => str_replace(".", "", $request->SoLuong[$i]),
                'DonGia' => str_replace(".", "", $request->DonGia[$i]),
                'ThanhTien' =>  str_replace(".", "", $request->ThanhTien[$i]),
            ]);
        }

        PhieuXuat::create([
            'MaPhieuXuat' => $maPhieuXuat,
            'MaPX' => $request->MaPX,
            'MaNV' => $request->MaNV,
            'MaKVT' => $request->MaKVT,
            'NoiDung' => $request->NoiDung,
        ]);
        return redirect('phieuxuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chiTiet = ChiTietPhieuXuat::where('MaPhieuXuat',$id)->orderBy('id','ASC')->get();
        $phieuXuat = PhieuXuat::where('MaPhieuXuat',$id)->first();
        $i=1;
        $sumSL = 0;
        $sumTT = 0;
        foreach($chiTiet as $item){
            $sumSL = $sumSL + $item->SoLuong;
            $sumTT = $sumTT + $item->ThanhTien;
        }
        return view('phieuxuat.show',compact('phieuXuat','chiTiet','i','sumTT','sumSL'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        $phieuXuat = PhieuXuat::where('MaPhieuXuat',$id)->first();
        $values = ChiTietPhieuXuat::where('MaPhieuXuat',$phieuXuat->MaPhieuXuat)->get();
        $DVT = array('Bộ','Cây','Chiếc','Cm','Cuốn','Đôi','Hộp','Kg','Lạng','Lọ','Mét','Tấm','Thanh','Túi','Viên','Cái');        $user =  Auth::user();
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        $MaPX = PhanXuong::orderBy('MaPX','ASC')->get();
        return view('phieuxuat.edit',compact('MaKVT','MaPX','DVT','phieuXuat','values'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->MaQuyen < '2'){
            return view('welcome');
        }
        $message = [
            'MaPX.required' => 'Mã phân xưởng không được để trống',
            'MaPhieuXuat.required' => 'Mã phiếu xuất không được để trống',
            'MaKVT.required' => 'Mã kho vật tư không được để trống',
            'MaVT.required' => 'Mã vật tư không được để trống',
            'MaNV.required' => 'Mã nhân viên không được để trống',
        ];
        $rules = [
            'MaPX' => 'required|string|max:10',
            'MaKVT' => 'required|string|max:10',
            'MaVT' => 'required|max:10',
            'MaNV' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        $phieuXuat = PhieuXuat::where('MaPhieuXuat',$request->MaPhieuXuat)->first();
        $chiTietPX = ChiTietPhieuXuat::where('MaPhieuXuat',$request->MaPhieuXuat)->get();
        foreach($chiTietPX as $item){
            $getVTKho = ChiTietKhoVT::where('MaVT',$item->MaVT)->first();
            $getVTKho->SoLuongTon = $getVTKho->SoLuongTon + $item->SoLuong;
            $getVTKho->TongSoLuong = $getVTKho->TongSoLuong + $item->SoLuong;
            $getVTKho->save();
        }
        ChiTietPhieuXuat::where('MaPhieuXuat',$request->MaPhieuXuat)->delete();
        $count = count($request->MaVT);
        for($i=0; $i<$count; $i++){
            $check = ChiTietKhoVT::where('MaVT',$request->MaVT[$i])->where('MaKVT',$request->MaKVT)->first();
            if(!$check){
                return redirect()->back()->withErrors(['Không có vật tư trong kho, hãy lựa chọn lại']);
            }
            if($check->SoLuongTon < str_replace(".", "", $request->SoLuong[$i])){
                return redirect()->back()->withErrors(['Số lượng tồn kho nhỏ hơn số lượng xuất']);
            }
            $soLuongTon = $check->SoLuongTon;
            $tongSoLuong = $check->TongSoLuong;
            $check->SoLuongTon = $soLuongTon - str_replace(".", "", $request->SoLuong[$i]);
            $check->TongSoLuong = $tongSoLuong - str_replace(".", "", $request->SoLuong[$i]);
            $check->save();

            ChiTietPhieuXuat::create([
                'MaPhieuXuat' => $phieuXuat->MaPhieuXuat,
                'MaVT' => $request->MaVT[$i],
                'SoLuong' => str_replace(".", "", $request->SoLuong[$i]),
                'DonGia' => str_replace(".", "", $request->DonGia[$i]),
                'ThanhTien' =>  str_replace(".", "", $request->ThanhTien[$i]),
            ]);
        }
        $phieuXuat->MaPX = $request->MaPX;
        $phieuXuat->MaKVT = $request->MaKVT;
        $phieuXuat->NoiDung = $request->NoiDung;
        $phieuXuat->save();

        return redirect('phieuxuat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $PhieuXuat = PhieuXuat::where('MaPhieuXuat',$request->MaPhieuXuat)->first();
        $vatTuPhieuXuat = ChiTietPhieuXuat::where('MaPhieuXuat',$request->MaPhieuXuat)->where('MaPX',$PhieuXuat->MaPX)->get();
        foreach ($vatTuPhieuXuat as $item){
            $vatTuKho = ChiTietKhoVT::where('MaVT',$item->MaVT)->where('MaKVT',$PhieuXuat->MaKVT)->first();
            $vatTu = VatTu::where('MaVT',$item->MaVT)->first();
            $soLuongTonCu = $vatTuKho->SoLuongTon;
            $soLuongXuatKho= $item->SoLuong;
            $soLuongTonMoi = $soLuongTonCu + $soLuongXuatKho;
            $vatTuKho->SoLuongTon = $soLuongTonMoi;
            $vatTuKho->TongSoLuong = $soLuongXuatKho + $soLuongTonCu;
            $vatTuKho->save();
            $vatTu->save();
        }
        ChiTietPhieuXuat::where('MaPhieuXuat',$request->MaPhieuXuat)->where('MaPX',$PhieuXuat->MaPX)->delete();
        $PhieuXuat->delete();
        return redirect()->back();
    }

    public function printExcel($id)
    {
        $vatTu = ChiTietPhieuXuat::where('MaPhieuXuat',$id)->orderBy('id','ASC')->get();
        $phieuXuat = PhieuXuat::where('MaPhieuXuat',$id)->first();
        $i=1;
        $sumSL = 0;
        $sumTT = 0;
        $countItem = count($vatTu)+7;
        $setBoder = "A6:F$countItem";
        foreach($vatTu as $item){
            $sumSL = $sumSL + $item->SoLuong;
            $sumTT = $sumTT + $item->ThanhTien;
        }
        Excel::create('New', function($excel) use($vatTu,$phieuXuat,$i,$sumSL,$sumTT,$setBoder) {
            $excel->sheet('First sheet', function($sheet)  use($vatTu,$phieuXuat,$i,$sumSL,$sumTT,$setBoder) {
                $sheet->loadView('phieuxuat.showExport')
                    ->setHeight('1',50)
                    ->setHeight('3',20)
                    ->setHeight('4',20)
                    ->setHeight('5',20)
                    ->mergeCells('A1:F1')
                    ->setWidth('A',5)
                    ->setBorder('A1', 'thin')
                    ->setBorder($setBoder, 'thin')
                    ->setWidth('B',25)
                    ->setWidth('C',20)
                    ->setWidth('D',10)
                    ->setWidth('E',10)
                    ->setWidth('F',20)
                    ->with('vatTu' , $vatTu)
                    ->with('phieuXuat' , $phieuXuat)
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
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        return view('report.phieuxuat',compact('MaPX','nhanVien','MaKVT'));
    }

    public function returnReport(Request $request){
        $result = DB::table('phieu_xuat')
            ->select(
                'phieu_xuat.MaPhieuXuat',
                'phan_xuong.TenPX',
                'kho_vat_tu.TenKVT',
                'nhan_vien.TenNV',
                'phieu_xuat.NoiDung',
                'phieu_xuat.created_at',
                'kho_vat_tu.TenKVT',
                'phan_xuong.TenPX',
                'nhan_vien.TenNV',
                'chi_tiet_phieu_xuat.*',
                'vat_tu.MoTa',
                'vat_tu.TenVT'
            )
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','phieu_xuat.MaKVT')
            ->join('phan_xuong','phan_xuong.MaPX','phieu_xuat.MaPX')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_xuat.MaNV')
            ->join('chi_tiet_phieu_xuat','chi_tiet_phieu_xuat.MaPhieuXuat','phieu_xuat.MaPhieuXuat')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_xuat.MaVT')
            ->where(function ($result) use ($request){
                if($request->MaKVT!=null){
                    $result->where('kho_vat_tu.MaKVT','LIKE','%'.$request->MaKVT.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->MaPX!=null){
                    $result->where('phan_xuong.MaPX','LIKE','%'.$request->MaPX.'%');
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
                if($request->MaPhieuXuat!=null){
                    $result->where('phieu_xuat.MaPhieuXuat','LIKE','%'.$request->MaPhieuXuat.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_from!=null){
                    $result->whereDate('phieu_xuat.created_at','>=',$request->date_from);
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_to!=null){
                    $result->whereDate('phieu_xuat.created_at','<=',$request->date_to);
                }
            })
            ->orderBy('phieu_xuat.MaPhieuXuat')->get();
        return response()->json($result);
    }

    public function printReport(Request $request){
        $check = 'PhieuXuat';
        $i = 1;
        $result = DB::table('phieu_xuat')
            ->select(
                'phieu_xuat.MaPhieuXuat',
                'phan_xuong.TenPX',
                'kho_vat_tu.TenKVT',
                'nhan_vien.TenNV',
                'phieu_xuat.NoiDung',
                'phieu_xuat.created_at',
                'kho_vat_tu.TenKVT',
                'phan_xuong.TenPX',
                'nhan_vien.TenNV',
                'chi_tiet_phieu_xuat.*',
                'vat_tu.MoTa',
                'vat_tu.TenVT'
            )
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','phieu_xuat.MaKVT')
            ->join('phan_xuong','phan_xuong.MaPX','phieu_xuat.MaPX')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_xuat.MaNV')
            ->join('chi_tiet_phieu_xuat','chi_tiet_phieu_xuat.MaPhieuXuat','phieu_xuat.MaPhieuXuat')
            ->join('vat_tu','vat_tu.MaVT','chi_tiet_phieu_xuat.MaVT')
            ->where(function ($result) use ($request){
                if($request->MaKVT!=null){
                    $result->where('kho_vat_tu.MaKVT','LIKE','%'.$request->MaKVT.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->MaPX!=null){
                    $result->where('phan_xuong.MaPX','LIKE','%'.$request->MaPX.'%');
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
                if($request->MaPhieuXuat!=null){
                    $result->where('phieu_xuat.MaPhieuXuat','LIKE','%'.$request->MaPhieuXuat.'%');
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_from!=null){
                    $result->whereDate('phieu_xuat.created_at','>=',$request->date_from);
                }
            })
            ->where(function ($result) use ($request){
                if($request->date_to!=null){
                    $result->whereDate('phieu_xuat.created_at','<=',$request->date_to);
                }
            })
            ->orderBy('phieu_xuat.MaPhieuXuat')->get();
        $count = count($result);
        $setborder = $count + 3;
        $setHeight1 = $count + 4;
        $setHeight2 = $count + 5;
//        return response()->json($result);

        $myFile =  Excel::create('New', function($excel) use($result,$i,$check,$count,$setborder,$setHeight1,$setHeight2) {
            $excel->sheet('First sheet', function($sheet)  use($result,$i,$check,$count,$setborder,$setHeight1,$setHeight2) {
                $sheet->loadView('report.printPhieu')
                    ->mergeCells('A1:J1')
                    ->mergeCells('A2:J2')
                    ->setBorder('A3:J'.$setborder, 'thin')
                    ->setHeight(1,50)
                    ->setHeight($setHeight1,20)
                    ->setHeight($setHeight2,20)
                    ->setWidth('A',7)
                    ->setWidth('B',15)
                    ->setWidth('C',15)
                    ->setWidth('D',30)
                    ->setWidth('E',18)
                    ->setWidth('F',18)
                    ->setWidth('G',10)
                    ->setWidth('H',25)
                    ->setWidth('I',15)
                    ->setWidth('J',20)
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

    public function searchPhieuXuat(Request $request)
    {
        $i = 1;
        $items = DB::table('phieu_xuat')
            ->join('nhan_vien','nhan_vien.MaNV','phieu_xuat.MaNV')
            ->join('phan_xuong','phan_xuong.MaPX','phieu_xuat.MaPX')
            ->join('kho_vat_tu','kho_vat_tu.MaKVT','phieu_xuat.MaKVT')
            ->select('phieu_xuat.*','nhan_vien.TenNV','kho_vat_tu.TenKVT','phan_xuong.TenPX')
            ->where('phieu_xuat.MaPhieuXuat','LIKE','%'.$request->search.'%')
            ->orWhere('nhan_vien.TenNV','LIKE','%'.$request->search.'%')
            ->orWhere('kho_vat_tu.TenKVT','LIKE','%'.$request->search.'%')
            ->orWhere('phan_xuong.TenPX','LIKE','%'.$request->search.'%')
            ->orderBy('phieu_xuat.MaPhieuXuat','ASC')
            ->paginate(10);
        return view('phieuxuat.search',compact('items','i'));
    }
}
