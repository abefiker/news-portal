<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
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
    Route::get('/admin/users' , [AdminController::class,'users'])->name('admin.users');
    Route::get('/admin/writers' , [AdminController::class,'writers'])->name('admin.writers');
    Route::get('/admin/users/profile' , [AdminController::class,'profile'])->name('admin.profile');
    Route::get('/admin/users/user/{id}' , [AdminController::class,'UpdateUserForm'])->name('admin.user.update.form');
    Route::post('/admin/users/user/{id}' , [AdminController::class,'UpdateUser'])->name('admin.user.update');
    Route::post('/admin/user/image/{id}' , [AdminController::class,'UpdateUserImage'])->name('admin.image.update');
    Route::get('/admin/users/destroy/{id}' , [AdminController::class,'DestroyUser'])->name('admin.user.destroy');
    //category route
    Route::get('/admin/categories' , [AdminController::class,'categories'])->name('admin.categories');
    Route::get('/admin/category/create' , [AdminController::class,'categoryCreateForm'])->name('admin.category.create.form');
    Route::post('/admin/category/create' , [AdminController::class,'categoryCreate'])->name('admin.category.create');
    Route::get('/admin/categories/update/{id}' , [AdminController::class,'categoryUpdateForm'])->name('admin.category.update.form');
    Route::post('/admin/categories/update/{id}' , [AdminController::class,'categoryUpdate'])->name('admin.category.update');
    Route::get('/admin/categories/destroy/{id}' , [AdminController::class,'categoryDestroy'])->name('admin.category.destroy');


    //post route
    Route::get('/admin/posts',[AdminController::class , 'posts'])->name('admin.posts');
    Route::get('/admin/post/create',[AdminController::class ,'postCreateForm'])->name('admin.post.create.form');
    Route::post('/admin/post/create',[AdminController::class ,'postCreate'])->name('admin.post.create');
    Route::get('/admin/post/update/{id}',[AdminController::class ,'postUpdateForm'])->name('admin.post.update.form');
    Route::post('/admin/post/update/{id}',[AdminController::class ,'postUpdate'])->name('admin.post.update');
    Route::get('/admin/post/destroy/{id}',[AdminController::class ,'postDestroy'])->name('admin.post.destroy');
    Route::get('/admin/post/restore/{id}',[AdminController::class ,'postRestore'])->name('admin.post.restore');
   
    //events route
    Route::get('/admin/events',[AdminController::class , 'events'])->name('admin.events');
    Route::get('/admin/event/create',[AdminController::class ,'eventCreateForm'])->name('admin.event.create.form');
    Route::post('/admin/event/create',[AdminController::class ,'eventCreate'])->name('admin.event.create');
    Route::get('/admin/event/update/{id}',[AdminController::class ,'eventUpdateForm'])->name('admin.event.update.form');
    Route::post('/admin/event/update/{id}',[AdminController::class ,'eventUpdate'])->name('admin.event.update');
    Route::get('/admin/event/destroy/{id}',[AdminController::class ,'eventDestroy'])->name('admin.event.destroy');

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
    Route::get('/admin/video',[AdminController::class , 'video'])->name('admin.video');
    Route::get('/admin/video/create',[AdminController::class ,'videoCreateForm'])->name('admin.video.create.form');
    Route::post('/admin/video/create',[AdminController::class ,'videoCreate'])->name('admin.video.create');
    Route::get('/admin/video/update/{id}',[AdminController::class ,'videoUpdateForm'])->name('admin.video.update.form');
    Route::post('/admin/video/update/{id}',[AdminController::class ,'videoUpdate'])->name('admin.video.update');
    Route::get('/admin/video/destroy/{id}',[AdminController::class ,'videoDestroy'])->name('admin.video.destroy');
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

