@extends('base')

@section('content')
<div class="bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Log in to your account</h1>

        <form method="POST" action="{{ route('login.user') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       class="mt-2 w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       required autofocus>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password"
                       class="mt-2 w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       required>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700">Forgot password?</a>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-indigo-700 transition cursor-pointer">
                Log in
            </button>

            <p class="text-sm text-gray-600 text-center">
                New here?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium cursor-pointer">Create an account</a>
            </p>
        </form>
    </div>
</div>
@endsection