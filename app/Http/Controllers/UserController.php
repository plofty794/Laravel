<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlogPost;
use App\Rules\ValidateEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getBlogPosts(Request $request) {
        if (auth()->check()) {
            $blogPosts = auth()->user()->currentUserBlogPosts()->latest()->get();
            return view("home", ["blogPosts" => $blogPosts->count() > 0 ? $blogPosts : null, "status" => null]);
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
        event(new Registered($user));
        auth()->login($user);
        return redirect('/');
    }

    public function updateUserProfile(Request $request) {
        $requestBody = $request->validate([
            "name" => ["required", "min:6", "max:15", Rule::unique("users", "name")],
            "email" => ["required", "email", Rule::unique("users", "email"), new ValidateEmail],
        ]);

        
        if ($request->file('avatar')) {
            $avatar = Storage::disk('public')->put("/", $request->file('avatar'));
            auth()->user()->name = $requestBody["name"];
            auth()->user()->email = $requestBody["email"];
            auth()->user()->avatar = $avatar;
            auth()->user()->save();
        }

        auth()->user()->name = $requestBody["name"];
        auth()->user()->email = $requestBody["email"];
        auth()->user()->save();

        return back()->with("success", "Profile has been updated");
    }

    public function logout() {
       auth()->logout();
       return redirect("/login");
    }
};
