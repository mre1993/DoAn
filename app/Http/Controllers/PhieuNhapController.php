<?php

namespace App\Http\Controllers;

use App\ChiTietKhoVT;
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
            $check = ChiTietKhoVT::where('MaVT',$request->MaVT[$i])->where('MaPX',$request->MaPX)->first();
            if(!$check){
                ChiTietKhoVT::create([
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
        $phieuNhap = PhieuNhap::find($id)->first();
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

    public function search($request){
        $result = VatTu::where('TenVT','LIKE','%'.$request.'%')->get();
        return response()->json($result);
    }

    public function getVT($request){
        $result = VatTu::where('MaVT',$request)->first();
        return response()->json($result);
    }

    public function printExcel($id)
    {
        $vatTu = ChiTietPhieuNhap::where('MaPN',$id)->orderBy('id','ASC')->get();
        $phieuNhap = PhieuNhap::find($id)->first();
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
}

