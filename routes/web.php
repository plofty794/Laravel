<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogPostController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::get('/', [UserController::class, "getBlogPosts"]);

Route::get('/getting-started', function () {
    return view('getting-started');
});

// User Controllers
Route::get('/signup', function () {
    if (auth()->check()) {
        return redirect("/");
    }
    return view('signup');
});
Route::get('/login', function () {
    if (auth()->check()) {
        return redirect("/");
    }
    return view('login');
});
Route::post('/signup', [UserController::class, "signup"]);
Route::post('/login', [UserController::class, "login"]);
Route::post('/logout', [UserController::class, "logout"]);
Route::patch('/update-user-profile/{userId}', [UserController::class, "updateUserProfile"]);

// Blog Post Controllers
Route::get('/edit-blog-post/{blogPostId}', [BlogPostController::class, "editBlogPostPage"]);
Route::post('/create-blog-post', [BlogPostController::class, "createBlogPost"]);
Route::patch('/edit-blog-post/{blogPostId}', [BlogPostController::class, "editBlogPost"]);
Route::delete('/delete-blog-post/{blogPostId}', [BlogPostController::class, "deleteBlogPost"]);

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');