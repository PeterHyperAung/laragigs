<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;

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

// All listings
Route::get('/', [ListingController::class, 'index']);

// Route::get('/hello', function(){
//     return response("<h1>Hello World</h1>", '404')->header('Content-Type', 'text/plain')->header('foo', 'bar');
//     // return response('<h1>Hello World</h1>');
// });

// Route::get('/posts/{id}', function($id){
//     // debugging purpose
//     // dd($id);
//     // ddd($id);
//     return response('Post ' . $id);
// })->where('id', '[0-9]+'); // constraints 

// Route::get('/search', function(Request $request){
//     dd($request);
//     dd($request->name . ' ' . $request->city);
// });

// Single listing


Route::get('/listings/create', [ListingController::class, 'create']);

Route::post('/listings', [ListingController::class, 'store']);

Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);

Route::get('/listings/{listing}', [ListingController::class, 'show']);

