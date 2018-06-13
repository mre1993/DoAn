<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
use App\ChiTietPhanXuong;
use App\ChiTietPhieuXuat;
use App\KhoVatTu;
use App\PhanXuong;
use App\PhieuXuat;
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
        $items = PhieuXuat::orderBy('MaPhieuXuat','ASC')->paginate(10);
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
        $MaPX = PhanXuong::orderBy('MaPX','ASC')->get();
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        return view('phieuxuat.create',compact('MaPX','nhanVien','MaKVT'));
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
            'MaPhieuXuat.unique' => 'Mã phiếu nhập đã tồn tại',
            'MaPhieuXuat.required' => 'Mã phiếu nhập không được để trống',
            'MaKVT.required' => 'Mã kho vật tư không được để trống',
            'MaVT.required' => 'Mã vật tư không được để trống',
        ];
        $rules = [
            'MaPX' => 'required|string|max:10',
            'MaPhieuXuat' => 'required|string|max:10|unique:phieu_xuat',
            'MaKVT' => 'required|string|max:10',
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
            $phanXuong = ChiTietPhanXuong::where('MaVT',$request->MaVT[$i])->where('MaPX',$request->MaPX)->first();
            $soLuongTonPX = $phanXuong->SoLuongTon;
            if(!$check){
                ChiTietKhoVT::create([
                    'MaKVT' => $request->MaKVT,
                    'MaVT' => $request->MaVT[$i],
                    'SoLuongTon' => $request->SoLuong[$i],
                ]);
            }else{
                $soLuongTon = $check->SoLuongTon;
                $check->SoLuongTon = $request->SoLuong[$i]+$soLuongTon;
                $check->save();
            }
            $phanXuong->SoLuongTon = $soLuongTonPX - $request->SoLuong[$i];
            $phanXuong->save();
            ChiTietPhieuXuat::create([
                'MaPhieuXuat' => $request->MaPhieuXuat,
                'MaVT' => $request->MaVT[$i],
                'SoLuong' => $request->SoLuong[$i],
                'DonGia' => $request->DonGia[$i],
                'ThanhTien' => $request->ThanhTien[$i],
            ]);
        }

        PhieuXuat::create([
            'MaPhieuXuat' =>$request->MaPhieuXuat,
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
    public function edit(PhieuXuat $phieuXuat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhieuXuat $phieuXuat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuXuat $phieuXuat)
    {
        //
    }

    public function printExcel($id)
    {
        $vatTu = ChiTietPhieuXuat::where('MaPhieuXuat',$id)->orderBy('id','ASC')->get();
        $phieuXuat = PhieuXuat::where('MaPhieuXuart',$id)->first();
        $i=1;
        $sumSL = 0;
        $sumTT = 0;
        foreach($vatTu as $item){
            $sumSL = $sumSL + $item->SoLuong;
            $sumTT = $sumTT + $item->ThanhTien;
        }
        Excel::create('New', function($excel) use($vatTu,$phieuXuat,$i,$sumSL,$sumTT) {

            $excel->sheet('First sheet', function($sheet)  use($vatTu,$phieuXuat,$i,$sumSL,$sumTT) {
                $sheet->loadView('phieuxuat.showExport')
                    ->mergeCells('B1:G2')
                    ->mergeCells('B1:G1')
                    ->mergeCells('B1:B2')
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
}
