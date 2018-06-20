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
    Route::get('phanquyen','UserController@phanQuyen')->name('phanQuyen');
    Route::resource('user', 'UserController');
    Route::get('/user/create', 'UserController@indexCreate')->name('createUser');
    Route::resource('/provider', 'NhaCungCapController');
    Route::post('/provider/createNew','NhaCungCapController@createNew')->name('newNCC');
    Route::resource('/phanxuong', 'PhanXuongController');
    Route::resource('/vattu', 'VatTuController');
    Route::resource('/nhanvien', 'NhanVienController');
    Route::resource('khovattu','KhoVatTuController');
    Route::resource('/phieunhap','PhieuNhapController');
    Route::get('phieunhap/search/{TimVT}','VatTuController@searchPN');
    Route::get('phieuxuat/search/{TimVT}','VatTuController@searchPX');
    Route::get('search-vt/{TimVT}','VatTuController@searchVT');
    Route::get('getVT/{TimVT}','VatTuController@getVT')->name('getVT');
    Route::get('getVT-xuat/{TimVT}','VatTuController@getVTX')->name('getVT');
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
    Route::post('provider/searchNCC','NhaCungCapController@searchNCC')->name('searchNCC');
    Route::post('phanxuong/searchPX','PhanXuongController@searchPX')->name('searchPX');
    Route::post('vattu/searchVT','VatTuController@searchVTIndex')->name('searchVTIndex');
    Route::post('nhanvien/searchNV','NhanVienController@searchNV')->name('searchNV');
    Route::post('khovattu/searchKVT','KhoVatTuController@searchKVT')->name('searchKVT');
    Route::post('phieunhap/searchPhieuNhap','PhieuNhapController@searchPhieuNhap')->name('searchPhieuNhap');
    Route::post('phieuxuat/searchPhieuXuat','PhieuXuatController@searchPhieuXuat')->name('searchPhieuXuat');
});
