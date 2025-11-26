{{-- filepath: resources/views/base.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Trade Skills, Not Money</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-indigo-600">SkillSwap</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <form method="GET" action="{{ route('logout') }}" class="inline cursor-pointer">
                                @csrf
                                <button type="submit" class="text-white rounded-full font-medium ml-4 cursor-pointer bg-red-400 py-2 px-4">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">Sign up</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="text-xl font-bold text-gray-800">SkillSwap</span>
                <p class="text-sm text-gray-500 mt-1">© {{ date('Y') }} SkillSwap Project.</p>
            </div>
            <div class="flex space-x-6 text-sm text-gray-500">
                <a href="#" class="hover:text-gray-900">About</a>
                <a href="#" class="hover:text-gray-900">Privacy</a>
                <a href="#" class="hover:text-gray-900">Contact</a>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/customjs.js') }}"></script>
</body>
</html>