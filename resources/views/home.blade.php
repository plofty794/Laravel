<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
  <title>Home N*gga</title>
</head>
<body class="bg-[#121A2D]">
  <x-bladewind.notification />
  <x-bladewind.modal
    size="large"
    name="edit-profile"
    ok_button_action="saveProfile()"
    ok_button_label="Update"
    close_after_action="false"
    >
    <h1 class="mb-4">Edit Your Profile</h1>
    @if (Auth::user()->avatar)
      <div class="w-max mx-auto mb-4">
        <x-bladewind.avatar size="omg" image="{{ Storage::url(Auth::user()->avatar) }}" />
      </div>
    @else
      <div class="w-max mx-auto mb-4">
        <x-bladewind.avatar size="huge" image="{{ asset('vendor/bladewind/images/avatar.png') }}" />
      </div>
    @endif
    <form method="post" action="/update-user-profile/{{ Auth::user()->id }}" class="profile-form" enctype="multipart/form-data">
      @csrf
      {{ method_field('PATCH') }}
      <x-bladewind.input value="{{ Auth::user()->name }}" required="true" name="name"
        error_message="Please enter your name" label="Name" />
      <x-bladewind.input value="{{ Auth::user()->email }}" required="true" name="email"
        error_message="Please enter your email" label="Email address" />
      <x-bladewind.filepicker class="w-full h-52" max_file_size="1" name="avatar" placeholder="Upload your avatar" accepted_file_types="image/*" />
    </form>
  </x-bladewind.modal>
  <nav class="px-8 py-4 w-full bg-[#0F172A] border-b border-slate-800">
    <ul class="flex justify-between items-center w-full">
      <li>
        @if (Auth::user()->avatar)
          <x-bladewind.avatar size="small" image="{{ Storage::url(Auth::user()->avatar) }}" />
        @else
          <x-bladewind.avatar size="small" image="{{ asset('vendor/bladewind/images/avatar.png') }}" />
        @endif
      </li>
      <li>
        <x-bladewind.dropmenu>
          <x-bladewind.dropmenu-item>
            <x-bladewind.button onclick="showModal('edit-profile')" class="w-full" type="secondary" size="tiny">Edit Profile</x-bladewind.button>
          </x-bladewind.dropmenu-item>
          <x-bladewind.dropmenu-item>
            <form class="w-full" action="/logout" method="post">
              @csrf
              <x-bladewind.button class="w-full" can_submit="true" size="tiny" color="red" >Log out</x-bladewind.button>
            </form>
          </x-bladewind.dropmenu-item>
        </x-bladewind.dropmenu>
      </li>
    </ul>
  </nav>
  <div class="p-8 flex items-center justify-center flex-col gap-4">
    @if ($errors->any())
      @foreach ($errors->all() as $error)
        <div class="w-2/7">
          <x-bladewind.alert
          class="text-sm font-semibold"
            type="error">
            {{ $error }}
          </x-bladewind.alert>  
        </div>
      @endforeach
    @endif
    @if (session('success'))
      <div class="w-1/4 mx-auto">
        <x-bladewind.alert
          type="success">
          {{ session('success') }}
        </x-bladewind.alert>
      </div>
    @endif
    @if (session('created'))
      <div class="w-1/4 mx-auto">
        <x-bladewind.alert
          type="success">
          {{ session('created') }}
        </x-bladewind.alert>
      </div>
    @endif
    @if (session('deleted'))
      <div class="w-1/4 mx-auto">
        <x-bladewind.alert
          type="success">
          {{ session('deleted') }}
        </x-bladewind.alert>
      </div>
    @endif
    <x-bladewind.card title="Create post" class="p-4 w-2/4">
      <form action="/create-blog-post" method="post" class="flex flex-col gap-2 create-post">
        @csrf
        <x-bladewind.input error_message="Title is required" label="Title" autofocus id="title" type="text" name="title" required="true" />
        <x-bladewind.textarea error_message="Content is required" required="true" label="Content" id="content" name="content" />
        <x-bladewind.button class="flex items-center justify-center" name="btn-create" has_spinner="true" can_submit="true">
          Create post
          <x-bladewind.icon name='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
          </svg>
          '/>
        </x-bladewind.button>
      </form>
    </x-bladewind.card>
    <x-bladewind.card class="w-2/4 p-6" title="recent posts">
      @if ($blogPosts != null)
        <div class="flex flex-col gap-4">
          @foreach ($blogPosts as $post)
            <div>
              <div class="flex w-full justify-between items-center">
                <p class="font-bold text-lg capitalize text-white">{{ $post->title }}</p>
                <p class="font-semibold text-sm text-white">{{ date('d-m-Y', strtotime($post->created_at)) }}</p>
              </div>
              <div class="flex items-center justify-between">
                <p class="font-semibold text-sm italic text-white">"{{ $post->content }}"</p>
                <x-bladewind.button size="small" tag="a" href="/edit-blog-post/{{ $post->id }}">
                  Edit
                </x-bladewind.button>
              </div>
            </div>
            @endforeach
        </div>
      @else
        <x-bladewind.empty-state
          message="Awesome! You have no blog posts yet.">
        </x-bladewind.empty-state>
      @endif
    </x-bladewind.card>

    <x-bladewind.modal
    name="create-postz"
    show_action_buttons="false">

      <x-bladewind.processing
        name="processing-create"
        message="Loading..."
        hide="false" />

    </x-bladewind.modal>

  </div>
  <script>
    dom_el('.create-post').addEventListener('submit',  (e) => {
      e.preventDefault();
      createPost(e);
    });

    createSuccess = () => {
      hide('.processing-create');
      showModal('create-postz');
      unhide('.processing-create');
    }

    createPost = (e) => {
      if (validateForm('.create-post')) {
        unhide('.btn-create .bw-spinner');
        createSuccess();
        e.target.submit();
      } else {
        hide('.btn-save .bw-spinner')
      }
    }

    saveProfile = () => {
      if(validateForm('.profile-form')){
          domEl('.profile-form').submit();
      } else {
          return false;
      }
    }
  
  </script>
</body>
</html>
