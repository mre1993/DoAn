<?php

namespace App\Http\Controllers;

use App\VatTu;
use Illuminate\Http\Request;

class VatTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = VatTu::orderBy('id','DESC')->paginate(10);
        return view('vattu.index',compact('items'));
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
    public function edit(VatTu $vatTu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VatTu  $vatTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VatTu $vatTu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VatTu  $vatTu
     * @return \Illuminate\Http\Response
     */
    public function destroy(VatTu $vatTu)
    {
        //
    }
}
