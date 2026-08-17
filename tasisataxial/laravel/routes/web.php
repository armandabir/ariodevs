<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Admin\categoriesController;
use App\Http\Controllers\blogController;
use App\Http\Controllers\Admin\tagsController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\projectController;
use App\Http\Controllers\User\UserDashboardController;
use App\Models\product;
use App\Models\view;
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
    $ip=$_SERVER['REMOTE_ADDR'];
    $views=view::where("ip",$ip)->get();
    if(count($views)==0){
        $view=new view();
        $view->ip=$ip;
        $view->save();
    }
    return view('index');
});



Route::get('/', function () {  
    return view('index');
})->name("home");


Route::get('/cats/{any}', function () {  
    // dd(session()->all());
    return view('index');
})->name("cats");





Route::get('/product/{any}', function () {
    $arman="test";
    $names=['ali','rahmat','ziba'];
    $result=[
        'r1'=>$names,
        'r2'=>$arman
    ];
    return view('index',['result'=>json_encode($result)]);
});

Auth::routes();


Route::prefix('admin')->middleware(['auth'])->group(function(){
    Route::get("dashboard",[AdminDashboardController::class,'index'])->name("admin.dashboard");
    // Route::post("admin/create",[AdminDashboardController::class,"create"])->name("admin.userCreate2");


    
    Route::post("category/create/{cats}/{parent_id?}",[categoriesController::class,"create"])->name("cats.create");
    Route::post("category/edit/{category}/{parent_id?}",[categoriesController::class,"edit"])->name("cats.edit");
    Route::post("category/delete/{category}/{parent_id?}",[categoriesController::class,"destroy"])->name("cats.delete");

    Route::get("blog/articles",[blogController::class,"adminIndex"])->name("articles");
    Route::get("blog/create",[blogController::class,"create"])->name("blog.create");
    Route::post("blog/article/store",[blogController::class,"store"])->name("article.store");
    Route::get("blog/aritcle/show/{article}",[blogController::class,"show"])->name("article.show");
    Route::post("blog/article/update/{article}",[blogController::class,"update"])->name("article.update");
    Route::get("blog/article/publish/{article}",[blogController::class,"edit"])->name("article.publish");
    Route::get("blog/article/delete/{article}",[blogController::class,"destroy"])->name("article.delete");
    Route::post("blog/article/imageUpload",[blogController::class,"imgUploader"])->name("article.imageUploder");
    Route::get("blog/tags",[tagsController::class,"index"])->name("tags");
    Route::post("blog/tags/store",[tagsController::class,"store"])->name("tags.store");
    Route::get("blog/tag/show/{tag}",[tagsController::class,"show"])->name("tag.show");
    Route::get("blog/tag/delete/{tag}",[tagsController::class,"destroy"])->name("tag.delete");
    Route::post("blog/tag/update/{tag}",[tagsController::class,"update"])->name("tag.update");


    Route::get("article/category",[categoriesController::class,"indexArticle"])->name("article.cats");
    Route::get("product/category",[categoriesController::class,"indexProduct"])->name("product.cats");
    Route::get("project/category",[categoriesController::class,"indexProject"])->name("project.cats");

    
    route::get("user/create",[AdminDashboardController::class,"create"])->name("admin.userCreate");
    Route::get("users",[AdminDashboardController::class,"users"])->name("admin.users");
    Route::post("users/register",[AdminDashboardController::class,"store"])->name("admin.register");
    Route::post("users/update/{user}",[AdminDashboardController::class,"update"])->name("admin.user");

    route::get("product/create",[productController::class,"create"])->name("product.create");
    route::post("product/store",[productController::class,"store"])->name("product.store");
    route::get('product/edit',[productController::class,"edit"])->name("product.edit");
    route::get('product/show/{product}',[productController::class,"show"])->name("product.show");
    route::get('product/publish/{product}',[productController::class,"publish"])->name("product.publish");
    route::post("product/update/{product}",[productController::class,"update"])->name("product.update");
    route::post("product/delete/{product}",[productController::class,"destroy"])->name("product.delete");

    route::get("project/list",[projectController::class,"adminIndex"])->name("project.list");
    route::get("project/create",[projectController::class,"create"])->name("project.create");
    route::post("project/store",[projectController::class,"store"])->name("project.store");
    route::get('project/show/{project}',[projectController::class,"show"])->name("project.show");
    route::get('project/publish/{project}',[projectController::class,"publish"])->name("project.publish");
    route::post("project/update/{project}",[projectController::class,"update"])->name("project.update");
    route::get("project/delete/{project}",[projectController::class,"destroy"])->name("project.delete");
    Route::post("project/imageUpload",[projectController::class,"imgUploader"])->name("project.imageUploder");


    route::get("orders",[AdminDashboardController::class,'orders'])->name("orders");
    route::post("orders/search",[AdminDashboardController::class,'search'])->name("order.search");
    route::get("orders/{order}",[AdminDashboardController::class,'details'])->name("order.details");

    route::get("orderPrint",[AdminDashboardController::class,"orderPrint"])->name("orderPrint");

    route::get('pages/create/{page_id}/{section_id}',[HomeController::class,"create"])->name('admin.home');
    route::get("pages/show/{page_id}/{sect_id}",[HomeController::class,"show"])->name('admin.pages.show');
    route::post('pages/store/{page_id}/{sect_id}',[HomeController::class,'store'])->name('admin.pages.store');
    route::get("page/item/edit/{page}",[HomeController::class,'edit'])->name('page.item.edit'); 
    route::get("page/item/delete/{page}",[HomeController::class,'destroy'])->name('page.item.delete');
    route::post('pages/update/{page?}/{page_id?}/{sect_id?}',[HomeController::class,'update'])->name('admin.pages.update');
});



Route::prefix('user')->middleware(['auth'])->group(function(){

   
    Route::get("dashboard",[UserDashboardController::class,'index'])->name("user.dashboard");
    Route::post('user/update/{user}',[UserDashboardController::class,'update'])->name('user.update');

  
});
Route::get("/login",[UserAuthController::class,"login"])->name("login");
Route::get("/userlogout",[UserAuthController::class,"logout"])->name("userlogout");

route::POST("/check",[UserAuthController::class,"check"])->name("auth.check");
route::get("/forgetPassword",[UserAuthController::class,"forgetForm"])->name("forgetForm");
route::get("/forgetCode",[UserAuthController::class,"forgetCode"])->name("forgetCode");
route::post("/forgetConfirm/{rndNumber}",[UserAuthController::class,"forgetConfirmCode"])->name("confirmForget");
route::get("/passwordForm",[UserAuthController::class,"passwordForm"])->name("passwordForm");
route::post("/resetPassword/{user}",[UserAuthController::class,"resetPassword"])->name("resetPassword");

route::get("/mobile",function(){
    return view("user.mobile");
})->name("mobile");


route::get("/smsCode",[UserAuthController::class,"smsCode"])->name("smsCode");
route::post("/confrimCode/{code}",[UserAuthController::class,"confirmcode"])->name("confirmcode");
route::get("user/create",[UserAuthController::class,"create"])->name("user.create");
route::POST("/register",[UserAuthController::class,"store"])->name("user.register");


// route::get("/blog/{blog?}",[blogController::class,"index"])->name("blog");
route::get("/blog/article/{article}",[blogController::class,"article"])->name('article');
route::post("/cart/payment",[cartController::class,"paycard"]);
Route::middleware('web')->post('/api/cart/payment', [CartController::class, 'paycard']);
Route::middleware('web')->post('/api/session', [HomeController::class, 'session']);
route::get("/payment",[cartController::class,'payment']);
Route::get("/verification",[cartController::class,'verification'])->name('verification');
route::get("/paymentStore",[cartController::class,'store'])->name('paymentStore');

Route::any('captcha-test', function() {
   
})->name("captcha-test");

Route::get('/{any}', function () {
    return view('index');
})->where('any','.*');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
