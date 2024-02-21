<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{

    public function editBlogPostPage(Request $request, $blogPostId) {
        $blogPost = BlogPost::find($blogPostId);
        if (!$blogPost) {
            return view("/edit-blog-post", ["blogPost" => "[]"]);
        }
        return view("/edit-blog-post", ["blogPost" => $blogPost]);
    }

    public function createBlogPost(Request $request) {
        $requestBody = $request->validate([
            "title" => ["required", "min:8", "max:20", Rule::unique("blog_posts", "title")],
            "content" => ["required", "min:10", "max:100"]
        ]);

        $requestBody['title'] = strip_tags($requestBody['title']);
        $requestBody['content'] = strip_tags($requestBody['content']);
        $requestBody['user_id'] = auth()->id();

        BlogPost::create($requestBody);

        return redirect("/");
    }

    public function editBlogPost(Request $request, $blogPostId) {
        $requestBody = $request->validate([
            "title" => ["required", "min:8", "max:20", Rule::unique("blog_posts", "title")],
            "content" => ["required", "min:10", "max:100"]
        ]);

        $requestBody['title'] = strip_tags($requestBody['title']);
        $requestBody['content'] = strip_tags($requestBody['content']);
        $requestBody['user_id'] = auth()->id();

        $blogPost = BlogPost::find($blogPostId);

        $blogPost->title = $requestBody['title'];
        $blogPost->content =  $requestBody['content'];
        $blogPost->save();

        return view("edit-blog-post", ["blogPost" => $blogPost, "successMessage" => "Blog post has been edited."]);
    }
}
