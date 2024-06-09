<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts App</title>
      <!-- Tailwind CSS CDN -->
      <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">
    <nav class="bg-blue-500 p-6">
        <div class="container mx-auto">
            <a href="{{ route('posts.index') }}" class="text-white font-bold text-4xl">Noticy</a>
        </div>
    </nav>

    <main class="py-8">
        @yield('content')
    </main>

</body>

</html>
