<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactRequestController;

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

Route::post('/contact-requests', [ContactRequestController::class, 'store'])->middleware('throttle:5,1');
Route::post('/visitor-location', [\App\Http\Controllers\VisitorLocationController::class, 'store'])->middleware('throttle:10,1');
Route::post('/locale', function (\Illuminate\Http\Request $request) {
    $locale = $request->validate(['locale' => ['required', 'in:fa,en']])['locale'];
    $request->session()->put('locale', $locale);
    return response()->json(['locale' => $locale]);
});
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'show'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])
        ->name('users.dashboard');
    Route::get('/dashboard/visitor-count', [\App\Http\Controllers\VisitorLocationController::class, 'count'])
        ->middleware('throttle:60,1')
        ->name('users.dashboard.visitor-count');
    Route::get('/dashboard/contact-requests', [ContactRequestController::class, 'index'])
        ->name('users.dashboard.contact-requests');
    Route::delete('/dashboard/contact-requests/{contactRequest}', [ContactRequestController::class, 'destroy'])
        ->whereNumber('contactRequest')
        ->name('contact-requests.destroy');
});

Route::prefix('/dashboard/publications')->group(function () {
    Route::get('/login', fn () => redirect()->route('login'))->name('publications.admin.login');
    Route::post('/login', fn () => redirect()->route('login'))->name('publications.admin.login.submit');
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('publications.admin.logout');

    Route::middleware('publications.admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\PublicationAdminController::class, 'index'])->name('publications.admin.index');
        Route::get('/{publication}/edit', [\App\Http\Controllers\PublicationAdminController::class, 'edit'])
            ->whereNumber('publication')
            ->name('publications.admin.edit');
        Route::put('/{publication}', [\App\Http\Controllers\PublicationAdminController::class, 'update'])
            ->whereNumber('publication')
            ->name('publications.admin.update');
        Route::delete('/{publication}', [\App\Http\Controllers\PublicationAdminController::class, 'destroy'])
            ->whereNumber('publication')
            ->name('publications.admin.destroy');
    });
});

Route::get('/{any}', function () {
    return view('index', ['visitorsCount' => \App\Models\Visitor::count()]);
})->where('any', '.*')->middleware(\App\Http\Middleware\CountUniqueVisitor::class);
