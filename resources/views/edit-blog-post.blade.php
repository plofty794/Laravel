<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
  <title>Edit Blog Post {{ $blogPost->title }}</title>
</head>
<body class="bg-[#121A2D]">
  <div class="p-6">
    <x-bladewind.button tag="a" href="/" size="small" >Go back</x-bladewind.button>
    @if ($errors->any())
      @foreach ($errors->all() as $error)
        <div class="w-1/4 mx-auto">
          <x-bladewind.alert
          class="text-sm font-semibold"
            type="error">
            {{ $error }}
          </x-bladewind.alert>  
        </div>
      @endforeach
    @endif
    <x-bladewind.card class="w-2/4 m-8 mx-auto" title="Edit {{ $blogPost->title }}">
        <div class="flex flex-col gap-2 w-full">
          <form class="flex flex-col gap-2" action="/edit-blog-post/{{ $blogPost->id }}" method="POST">
            @csrf
            {{ method_field('PATCH') }}
            <x-bladewind.input value="{{ $blogPost->title }}" error_message="Title is required" label="Title" autofocus type="text" name="title" required="true" />
            <x-bladewind.input value="{{ $blogPost->content }}" name="content" error_message="Content is required" label="Content" required="true" />
            <x-bladewind.button size="small" name="btn-edit" can_submit="true" >
              Edit
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
              </svg>
            </x-bladewind.button>
          </form>
          <form action="/delete-blog-post/{{ $blogPost->id }}" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <x-bladewind.button size="small" name="btn-edit" can_submit="true" class="w-full" color="red" >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>
              Delete
            </x-bladewind.button>
          </form>
          <p class="text-green-600 font-bold text-sm">{{ $successMessage ?? "" }}</p>
        </div>
      </div>
  </x-bladewind.card>
</body>
</html>