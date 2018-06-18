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
Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/chart','HomeController@chart');
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
    Route::get('search-vt/{TimVT}','VatTuController@searchVT')->name('search');
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
    Route::get('/ton-kho','KhoVatTuController@showTonKho')->name('tonkho.index');
    Route::get('/ton-kho/quan-ly-hong/{request}','KhoVatTuController@checkHong')->name('tonkho.edit');
    Route::get('/bao-cao/bc-vattu',[
        'as' => 'baocao.vattu',
        'uses' => 'VatTuController@report'
    ]);
    Route::get('/bao-cao/bc-vattu/get/','VatTuController@returnReport')->name('reportRecord.vattu');
    Route::get('/bao-cao/bc-vattu/printTon','VatTuController@printTon')->name('printTon.vattu');
    Route::get('/bao-cao/bc-phieuxuat','PhieuXuatController@report')->name('report.phieuxuat');
    Route::get('/bao-cao/bc-phieuxuat/get/','PhieuXuatController@returnReport')->name('reportRecord.phieuxuat');
    Route::get('/bao-cao/bc-phieunhap',[
        'as' => 'report.phieunhap',
        'uses' => 'PhieuNhapController@report'
    ]);
    Route::get('/bao-cao/bc-phieunhap/get/','PhieuNhapController@returnReport')->name('reportRecord.phieunhap');
    Route::get('/bao-cao/bc-phieuxuat/printReport/','PhieuXuatController@printReport');
    Route::get('/bao-cao/bc-phieunhap/printReport/','PhieuNhapController@printReport');
    Route::get('/mostimport','VatTuController@mostImport');
    Route::get('/mostexport','VatTuController@mostExport');
    Route::get('/mostinventory','VatTuController@mostInventory');
    Route::get('/mostsupplies','VatTuController@mostSupplies');
    Route::prefix('search')->group(function(){
        Route::get('tim-tai-khoan')->name('tim-tk');
        Route::get('tim-danh-muc')->name('tim-dm');
        Route::get('tim-nhap-xuat-ton')->name('tim-n-x-t');
        Route::get('tim-bao-cao')->name('tim-bc');
    });
});
