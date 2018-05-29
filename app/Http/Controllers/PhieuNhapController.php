<?php

namespace App\Http\Controllers;

use App\KhoVatTu;
use App\PhieuNhap;
use Illuminate\Http\Request;

class PhieuNhapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = PhieuNhap::orderBy('MaPN','ASC')->paginate(10);
        return view('phieunhap.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MaKVT = KhoVatTu::orderBy('MaKVT','ASC')->get();
        return view('phieunhap.create',compact('MaKVT'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function show(PhieuNhap $phieuNhap)
    {
        //
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
}
