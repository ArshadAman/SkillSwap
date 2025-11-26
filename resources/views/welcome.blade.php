@extends('base')
@section('content')
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-6">
                Learn something new.<br>
                <span class="text-indigo-600">Teach what you know.</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                SkillSwap connects you with people who want to learn your skills and can teach you theirs in return. No money involved, just knowledge exchange.
            </p>
            <div class="flex justify-center gap-4">
                @auth
                    <a href="" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Find a Match
                    </a>
                @else
                    <a href="{{ url('/register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Get Started
                    </a>
                    <a href="#how-it-works" class="bg-white text-indigo-600 border border-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                        How it Works
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div id="how-it-works" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Simple & Direct</h2>
                <p class="mt-2 text-gray-600">Three steps to start learning.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl font-bold mb-4">1</div>
                    <h3 class="text-xl font-semibold mb-2">Create Profile</h3>
                    <p class="text-gray-600">List the skills you are good at and the skills you want to learn.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl font-bold mb-4">2</div>
                    <h3 class="text-xl font-semibold mb-2">Find a Match</h3>
                    <p class="text-gray-600">Search for someone who wants your skill and has the skill you need.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl font-bold mb-4">3</div>
                    <h3 class="text-xl font-semibold mb-2">Connect</h3>
                    <p class="text-gray-600">Send a request. Once accepted, you get their contact info to arrange the lesson.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Why SkillSwap?</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="flex items-start space-x-4">
                    <div class="text-indigo-600 text-2xl">✓</div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Free to Use</h3>
                        <p class="text-gray-600">No fees, no subscriptions. Just connect and learn.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-indigo-600 text-2xl">✓</div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Direct Connection</h3>
                        <p class="text-gray-600">No middleman. You deal directly with your skill partner.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-indigo-600 text-2xl">✓</div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Mutual Benefit</h3>
                        <p class="text-gray-600">Both parties learn something new. Everyone wins.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-indigo-600 text-2xl">✓</div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Flexible Schedule</h3>
                        <p class="text-gray-600">Arrange lessons at your own pace and convenience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-indigo-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to start learning?</h2>
            <p class="text-indigo-100 mb-8">Join SkillSwap today and find your perfect skill exchange partner.</p>
            @guest
                <a href="{{ url('/register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Create Free Account
                </a>
            @endguest
        </div>
    </div>
@endsection
