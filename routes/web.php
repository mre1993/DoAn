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
    Route::get('/mostsupplies','VatTuController@mostSupplies');
});
