<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>Edit Blog Post {{ $blogPost->id }}</title>
</head>
<body>
  <div class="p-6">
    <button class="font-bold text-sm border rounded-md px-4 py-2 shadow-md">
      <a class="w-full" href="/" >Go back</a>
    </button>
    <div class="w-full flex items-center justify-center">
      <div class="shadow-lg border flex flex-col gap-4 p-6 w-2/4">
        <h2 class="text-2xl font-bold capitalize">Edit {{ $blogPost->title }}</h2>
        <form class="flex flex-col gap-2" action="/edit-blog-post/{{ $blogPost->id }}" method="POST">
          @csrf
          {{ method_field('PATCH') }}
          <label class="font-bold text-sm" for="title">Title</label>
          <input value="{{ $blogPost->title }}" autofocus id="title" type="text" name="title" class="capitalize text-sm font-medium w-full p-2 rounded-md border outline-1 outline">
          <label class="font-bold text-sm" for="content">Content</label>
          <input value="{{ $blogPost->content }}" id="content" name="content" class="text-sm font-medium w-full p-2 rounded-md border outline-1 outline"></input>
          <button class="w-full font-bold text-sm border rounded-md px-4 py-2 bg-gray-950 text-white">Edit</button>
        </form>
        @if ($errors->any())
        <ul class="p-4 border border-red-600 bg-red-400 rounded-md w-max mx-auto">
            @foreach ($errors->all() as $error) 
                <li class="text-white font-semibold text-sm">{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <p class="text-green-600 font-bold text-sm">{{ $successMessage ?? "" }}</p>
      </div>
    </div>
  </div>
</body>
</html>