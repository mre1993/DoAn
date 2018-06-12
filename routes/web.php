<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user', 'UserController');
    Route::get('/user/create', 'UserController@indexCreate')->name('createUser');
    Route::resource('/provider', 'NhaCungCapController');
    Route::resource('/phanxuong', 'PhanXuongController');
    Route::resource('/vattu', 'VatTuController');
    Route::resource('/theloai', 'TheLoaiController');
    Route::resource('/nhanvien', 'NhanVienController');
    Route::resource('khovattu','KhoVatTuController');
    Route::resource('/phieunhap','PhieuNhapController');
    Route::get('search/{TimVT}','VatTuController@search')->name('search');
    Route::get('getVT/{TimVT}','VatTuController@getVT')->name('getVT');
    Route::get('phieunhap/showExport/{id}',[
        'as' => 'phieunhap.showExport',
        'uses' => 'PhieuNhapController@showExport'
    ]);
    Route::get('phieunhap/printExcel/{id}',[
        'as' => 'phieunhap.printExcel',
        'uses' => 'PhieuNhapController@printExcel'
    ]);
    Route::get('phieuxuat/showExport/{id}',[
        'as' => 'phieuxuat.showExport',
        'uses' => 'PhieuXuatController@showExport'
    ]);
    Route::get('phieuxuat/printExcel/{id}',[
        'as' => 'phieuxuat.printExcel',
        'uses' => 'PhieuXuatController@printExcel'
    ]);
    Route::resource('/phieuxuat','PhieuXuatController');
    Route::prefix('search')->group(function(){
       Route::get('tim-tai-khoan')->name('tim-tk');
       Route::get('tim-danh-muc')->name('tim-dm');
       Route::get('tim-nhap-xuat-ton')->name('tim-n-x-t');
       Route::get('tim-bao-cao')->name('tim-bc');
    });
    Route::get('/bc-vattu',[
        'as' => 'baocao.vattu',
        'uses' => 'VatTuController@report'
    ]);
    Route::get('/bc-phieuxuat','PhieuXuatController@report')->name('report.phieuxuat');
    Route::get('/bc-phieuxuat/get/','PhieuXuatController@returnReport')->name('reportRecord.phieuxuat');
    Route::get('/bc-phieunhap',[
        'as' => 'report.phieunhap',
        'uses' => 'PhieuNhapController@report'
    ]);
//    Route::post('/bc-phieunhap/{request}',[
//        'as' => 'report.phieunhap',
//        'uses' => 'PhieuNhapController@report'
//    ]);
});
