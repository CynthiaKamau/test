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

Route::get('/upload-form', function () { return view('upload'); });
Route::post("/upload", [App\Http\Controllers\FileUploadController::class, 'store'])->name("fileUpload");

Route::get("/", [App\Http\Controllers\MarvelController::class, 'index'])->name("marvel-universe");
Route::get("/marvel-universe-fetch", [App\Http\Controllers\MarvelController::class, 'get_characters'])->name("marvel-universe-fetch");
Route::get("/marvel-universe-fetch/{pgno}", [App\Http\Controllers\MarvelController::class, 'get_characters_test'])->name("pgt");



