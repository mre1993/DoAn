<?php

namespace App\Http\Controllers;

use App\TheLoai;
use Illuminate\Http\Request;

class TheLoaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('theloai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function show(TheLoai $loaiVatTu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function edit(TheLoai $loaiVatTu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TheLoai $loaiVatTu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TheLoai  $loaiVatTu
     * @return \Illuminate\Http\Response
     */
    public function destroy(TheLoai $loaiVatTu)
    {
        //
    }
}
