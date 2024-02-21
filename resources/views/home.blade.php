<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>Home N*gga</title>
</head>
<body>
  @auth
  <nav class="p-8 w-full">
    <ul class="flex justify-between items-center w-full">
      <li>
        <h1 class="text-2xl font-bold">N*gga</h1>
      </li>
      <li><form action="/logout" method="post">
        @csrf
        <button class="font-bold text-sm border rounded-md px-4 py-2 bg-gray-950 text-white">
         Log out
        </button>
      </form>
    </ul>
  </nav>
  <div class="p-8 flex items-center justify-center flex-col gap-4">
    <h1 class="text-4xl font-bold">Hello from home!</h1>
    <button class="font-bold text-sm border rounded-md px-4 py-2 shadow-md">
      <a href="/getting-started">Get started</a>
    </button>
    <form action="/create-blog-post" method="post" class="flex flex-col gap-2 p-4 border rounded-md shadow-lg w-2/4">
      @csrf
      <h2 class="text-xl font-bold">Create post</h2>
      <label class="font-bold text-sm" for="title">Title</label>
      <input autofocus id="title" type="text" name="title" class="text-sm font-medium w-full p-2 rounded-md border outline-1 outline">
      <label class="font-bold text-sm" for="content">Content</label>
      <textarea id="content" name="content" class="text-sm font-medium w-full p-2 rounded-md border outline-1 outline"></textarea>
      <button class="font-bold text-sm border rounded-md px-4 py-2 bg-gray-950 text-white">
       Create post
      </button>
       @if ($errors->any())
       <ul class="p-4 border border-red-600 bg-red-400 rounded-md w-max mx-auto">
           @foreach ($errors->all() as $error)
               <li class="text-white font-semibold text-sm">{{ $error }}</li>
           @endforeach
       </ul>
       @endif
    </form>
    <div class="border shadow-lg rounded-md w-2/4 p-6">
      @if ($blogPosts != null)
      <div class="flex flex-col gap-4">
        @foreach ($blogPosts as $post)
        <div>
          <div class="flex w-full justify-between items-center">
            <p class="font-bold text-lg capitalize">{{ $post->title }}</p>
            <p class="font-semibold text-sm">{{ date('d-m-Y', strtotime($post->created_at)) }}</p>
          </div>
          <div class="flex items-center justify-between">
            <p class="font-semibold text-sm italic">"{{ $post->content }}"</p>
            <button class="font-bold text-sm underline">
              <a href="/edit-blog-post/{{ $post->id }}">Edit</a>
            </button>
          </div>
        </div>
        @endforeach
      </div>
      @else
        <p class="font-medium">No posts to show</p>
      @endif
    </div>
  </div>
  @else
  <a href="/login">Click here to redirect</a>
  @endauth
</body>
</html>