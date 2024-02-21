<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogPostController;

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
    return view('signup');
});
Route::get('/login', function () {
    return view('login');
});
Route::post('/signup', [UserController::class, "signup"]);
Route::post('/login', [UserController::class, "login"]);
Route::post('/logout', [UserController::class, "logout"]);

// Blog Post Controllers

Route::get('/edit-blog-post/{blogPostId}', [BlogPostController::class, "editBlogPostPage"]);
Route::post('/create-blog-post', [BlogPostController::class, "createBlogPost"]);
Route::patch('/edit-blog-post/{blogPostId}', [BlogPostController::class, "editBlogPost"]);