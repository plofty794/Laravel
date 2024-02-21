<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>Login N*gga</title>
</head>
<body>
  @auth
      <script>
        window.location.href = "/"
      </script>
  @endauth
  <div class="flex items-center justify-center min-h-screen flex-col gap-4">
    <h1 class="text-3xl font-bold text-center">Welcome N*gga</h1>
    <form class="border rounded-lg p-6 flex flex-col gap-2 shadow-lg" action="/login" method="post">
      @csrf 
      <label class="font-semibold text-sm" for="email">Email</label>
      <input class="border px-4 py-2 rounded-md" autofocus autocomplete="off" type="text" name="email" id="email" >
      <label class="font-semibold text-sm" for="password">Password</label>
      <input class="border px-4 py-2 rounded-md" type="password" name="password" id="password">
      <button class="bg-gray-950 w-max px-4 py-2 rounded-md text-white font-semibold" type="submit" > 
      Sign in
    </button>
    </form>
    <div class="flex items-center justify-center gap-2">
      <p class="text-xs font-medium">New to Welcome N*gga? </p>
      <a class="text-xs font-medium underline" href="/signup">Sign up</a>
    </div>
    @if ($errors->any())
          <ul class="p-4 border border-red-600 bg-red-400 rounded-md w-max">
              @foreach ($errors->all() as $error)
                  <li class="text-white font-semibold text-sm">{{ $error }}</li>
              @endforeach
          </ul>
    @endif
  </div>
  </div>
</body>
</html>