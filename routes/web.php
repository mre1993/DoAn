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
    Route::resource('/phieunhap','PhieuNhapController');
    Route::resource('/chitietphieunhap','ChiTietPhieuNhapController');
});
