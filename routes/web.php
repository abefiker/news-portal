<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/',[App\Http\Controllers\FrontendController::class,'welcome']);
Route::get('/send', [App\Http\Controllers\HomeController::class, 'sendnotification']);
Route::middleware(['auth','admin'])->group(function () {

    Route::get('/admin/home' , [AdminController::class,'home']);
    //settings route
    Route::get('/admin/settings/update' , [AdminController::class,'settingsUpdateForm'])->name('settings.update.form');
    Route::post('/admin/settings/update' , [AdminController::class,'settingsUpdate'])->name('settings.update');
    // user route

    Route::get('/admin/writers' , [AdminController::class,'writers'])->name('admin.writers');

    Route::get('/admin/users/profile' , [AdminController::class,'profile'])->name('admin.profile');

    Route::resource('/admin/users',UserController::class);
    Route::post('/admin/user/image/{id}' , [AdminController::class,'UpdateUserImage'])->name('admin.image.update');
    Route::resource('/admin/categories',CategoryController::class);


    //post route

    Route::resource('/admin/posts', PostsController::class);
    Route::get('/admin/posts/{post}/restore', [PostsController::class, 'restore'])->name('admin.posts.restore');


    //events route

    Route::resource('/admin/events',EventController::class);
    //admin writer request route
    Route::get('/admin/writer-requests',[AdminController::class ,'writer_requests'])->name('admin.writer.request');
    Route::get('/admin/writer-requests/approve/{id}',[AdminController::class ,'writer_requestsApprove'])->name('admin.writer_request.approve');
    Route::get('/admin/writer-requests/destroy/{id}',[AdminController::class ,'writer_requestsDestroy'])->name('admin.writer_request.destroy');
    Route::get('/admin/writer-requests/bann/{id}',[AdminController::class ,'writer_requestsBann'])->name('admin.writer_request.bann');

    //advert request route
    Route::get('/admin/adverter-requests',[AdminController::class ,'adverter_requests'])->name('admin.adverter.request');
    Route::get('/admin/adverter-requests/approve/{id}',[AdminController::class ,'adverter_requestsApprove'])->name('admin.advert_request.approve');
    Route::get('/admin/adverter-requests/destroy/{id}',[AdminController::class ,'adverter_requestsDestroy'])->name('admin.advert_request.destroy');
    Route::get('/admin/adverter-requests/bann/{id}',[AdminController::class ,'adverter_requestsBann'])->name('admin.advert_request.bann');

    //video route
    // Route::get('/admin/video',[AdminController::class , 'video'])->name('admin.video');
    // Route::get('/admin/video/create',[AdminController::class ,'videoCreateForm'])->name('admin.video.create.form');
    // Route::post('/admin/video/create',[AdminController::class ,'videoCreate'])->name('admin.video.create');
    // Route::get('/admin/video/update/{id}',[AdminController::class ,'videoUpdateForm'])->name('admin.video.update.form');
    // Route::post('/admin/video/update/{id}',[AdminController::class ,'videoUpdate'])->name('admin.video.update');
    // Route::get('/admin/video/destroy/{id}',[AdminController::class ,'videoDestroy'])->name('admin.video.destroy');
    Route::resource('/admin/videos', VideoController::class);
});
//Admin route

Route::post('/client/ckupload/', [FrontendController::class, 'ckupload'])->name('ck.upload');
Route::get('/client/post/{id}', [FrontendController::class, 'post'])->name('client.post');
Route::get('/client/category/{id}', [FrontendController::class, 'category'])->name('client.category');
//admin event route

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//pages
Route::get('/client/write', [App\Http\Controllers\FrontendController::class, 'writeForm'])->middleware('auth')->name('become.writer.form');
Route::post('/client/write', [App\Http\Controllers\FrontendController::class, 'writeForUs'])->middleware('auth')->name('become.writer');

Route::get('/client/contact', [App\Http\Controllers\FrontendController::class, 'contactForm'])->name('contact.us.form');
Route::post('/client/contact', [App\Http\Controllers\FrontendController::class, 'contactUs'])->name('contact.us');

Route::get('/client/advertise', [App\Http\Controllers\FrontendController::class, 'advertiseForm'])->middleware('auth')->name('advertise.form');
Route::post('/client/advertise', [App\Http\Controllers\FrontendController::class, 'advertise'])->middleware('auth')->name('advertise');

Route::get('/client/about', [App\Http\Controllers\FrontendController::class, 'about'])->name('about.us');
Route::get('/client/event', [App\Http\Controllers\FrontendController::class, 'clientEvents'])->name('client.event');

//Route for video

