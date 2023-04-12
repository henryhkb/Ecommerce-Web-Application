<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, 'index']);




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


//redirecting the user based on the usertype
Route::get('/redirect', [HomeController::class, 'redirect'])->middleware('auth','verified');

Route::get('/view_category',[AdminController::class, 'view_category']);

Route::post('/add_category',[AdminController::class, 'add_category']);

Route::get('/delete_category/{id}',[AdminController::class, 'delete_category']);

Route::get('/view_product',[AdminController::class, 'view_product']);

Route::post('/add_product',[AdminController::class, 'add_product']);

Route::get('/show_product',[AdminController::class, 'show_product']);

Route::get('/delete_product/{id}',[AdminController::class, 'delete_product']);

Route::get('/update_product/{id}',[AdminController::class, 'update_product']);

Route::post('/update_product_confirm/{id}', [AdminController::class, 'update_product_confirm']);

Route::get('/order', [AdminController::class, 'order']);

Route::get('/delivered/{id}', [AdminController::class, 'delivered']);






Route::get('/product_details/{id}', [HomeController::class, 'product_details']);

Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);

Route::get('/showcart', [HomeController::class, 'showcart']);

Route::get('/remove_cart/{id}', [HomeController::class, 'remove_cart']);

Route::get('/cash_order', [HomeController::class, 'cash_order']);

Route::get('/stripe/{totalPrice}', [HomeController::class, 'stripe']);

// Route::controller(HomeController::class)->group(function(){
//     Route::get('stripe', 'stripe');
//     Route::post('stripe', 'stripePost')->name('stripe.post');
// });


//name function is there because in the action form tag route is used instead of url.
Route::post('stripe/{totalPrice}', [HomeController::class, 'stripePost'])->name('stripe.post');

Route::get('print_PDF/{id}', [AdminController::class, 'print_PDF']);

Route::get('send_email/{id}', [AdminController::class, 'send_email']);

Route::post('send_user_email/{id}', [AdminController::class, 'send_user_email']);

Route::get('search', [AdminController::class, 'search']);

Route::post('add_comment', [HomeController::class, 'add_comment']);

Route::post('add_reply', [HomeController::class, 'add_reply']);

Route::get('product_search', [HomeController::class, 'product_search']);



