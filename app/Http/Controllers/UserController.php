<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlogPost;
use App\Rules\ValidateEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getBlogPosts(Request $request) {
        if (auth()->check()) {
            $blogPosts = auth()->user()->currentUserBlogPosts()->latest()->get();
            return view("home", ["blogPosts" => $blogPosts->count() > 0 ? $blogPosts : null]);
        }
        return redirect("/login");
    }

    public function login(Request $request) {
        $requestBody = $request->validate([
            "email" => ["required", "email", new ValidateEmail],
            "password" => "required",
        ]);

        if (auth()->attempt(["email" => $requestBody['email'], "password" => $requestBody['password']])) {
            $request->session()->regenerate();
            return redirect('/');
        };
        return back()->withErrors(['Invalid login credentials!'])->withInput();
    }

    public function signup(Request $request) {
        $requestBody = $request->validate([
            "name" => ["required", "min:6", "max:15", Rule::unique("users", "name")],
            "email" => ["required", "email", Rule::unique("users", "email"), new ValidateEmail],
            "password" => ["required", "min:8", "max:15"],
        ]);
        $requestBody['password'] = bcrypt($requestBody['password']);
        $user = User::create($requestBody);
        auth()->login($user);
        return redirect('/');
    }

    public function logout() {
       auth()->logout();
       return redirect("/login");
    }
};
