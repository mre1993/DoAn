<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->id === 1 && Auth::user()->MaQuyen === 1){
            $user = User::where('id',Auth::user()->id)->first();
            $user->MaQuyen = '3';
            $user->save();
        }
        return view('dashboard');
    }

    public function searchDM(){
        return view('tim-kiem.danhmuc');
    }

    public function searchNX(){
        return view('tim-kiem.nhapxuat');
    }
}
