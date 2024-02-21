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
  <title>Sign up N*gga</title>
</head>
<body class="bg-[#121A2D]">
  <x-bladewind.notification />
  <div class="flex items-center justify-center min-h-screen flex-col gap-4">
    <h1 class="text-3xl font-bold text-center text-white">Sign up to N*gga</h1>
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
    <x-bladewind.card class="w-2/6 p-6">
      <form class="flex flex-col gap-2 signup-form" action="/signup" method="post">
        @csrf 
        <x-bladewind.input error_message="You will need to enter your name" required="true" label="Name" autofocus autocomplete="off" type="text" name="name"  />
        <x-bladewind.input error_message="You will need to enter your email" required="true" label="Email" autocomplete="off" name="email"  />
        <x-bladewind.input error_message="You will need to enter your password" required="true" label="Password" type="password" suffix="eye" viewable="true" name="password"  />
        <x-bladewind.button can_submit="true" size="small">Create account</x-bladewind.button>
      </form>
    </x-bladewind.card>
    <div class="flex items-center justify-center gap-2">
      <p class="text-[#7D87A9] text-xs font-medium">Have an account? </p>
      <a class="text-[#7D87A9] text-xs font-medium underline" href="/login">Sign in</a>
    </div>
  </div>
  </div>
  <script>
    dom_el('.signup-form').addEventListener('submit',  (e) => {
    e.preventDefault();
    const res = signUp();
    if (res == true) {
      e.target.submit();
    }
});
    const signUp = () => (validateForm('.signup-form'))// do this if not validated
  </script>
</body>
</html>