<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ExcelController@index');

Route::get('/procesar', 'ExcelController@procesar')->name('procesar');
Route::get('/prueba', 'ExcelController@CargaProfesor')->name('procesar');

//Route::get('file-upload', 'ExcelController@excelUpload')->name('file.upload');
Route::post('file-upload', 'ExcelController@excelUploadPost')->name('file.upload.excel');

Route::get('/profesor', 'ExcelController@profesor')->name('profesor');
Route::post('/profesor-upload', 'ExcelController@profesorUpload')->name('file.upload.profesor');