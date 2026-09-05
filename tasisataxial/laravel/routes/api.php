<?php

use App\Http\Controllers\Admin\categoriesController;
use App\Http\Controllers\blogController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\productController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\projectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


route::get('getcats/{cat}/{subcat?}',[categoriesController::class,"getcats"]);
route::get('getProducts/{cat}/{subcat?}',[productController::class,"index"]);
route::get('getProjects/{cat}',[projectController::class,"index"]);
route::get("getArticles/{blog?}/{cat?}",[blogController::class,"index"])->name("blog");


route::get('fetchProject/{id}',[projectController::class,"getproject"]);
route::get('fetchProduct/{id}',[productController::class,"getProduct"]);
route::get("article/{id?}",[blogController::class,"getArticle"]);

route::get('pages/listItems/{page_id}/{sect_id}',[HomeController::class,"listItems"]);