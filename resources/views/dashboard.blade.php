@extends('base')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8">Welcome, {{ $user->name ?? '-' }}</h1>

    <div class="grid md:grid-cols-3 gap-8 mb-10">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">My Profile</h2>
            <p>Name: {{ $user->name ?? '-' }}</p>
            <p>Email: {{ $user->email ?? '-' }}</p>
            <p>Contact: {{ $user->contact_info ?? '-' }}</p>
            <a href="#" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">Edit Profile</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Skills I Have</h2>
            <ul class="mb-4">
                @foreach($skillsHave as $skill)
                <li class="mb-2 flex justify-between"><p>{{ $skill->skill_name }}</p> <span class="text-red-600 cursor-pointer deleteModal" data-id="{{ $skill->id }}">Delete</span> </li>
                @endforeach
            </ul>
            <button id="addSkill" class="text-indigo-600 hover:underline text-sm cursor-pointer">Add Skill</button>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Skills I Want</h2>
            <ul class="mb-4">
                @foreach($skillsWant as $skill_w)
                <li class="mb-2 flex justify-between"><p>{{ $skill_w->skill_name }}</p> <span class="text-red-600 cursor-pointer deleteModal" data-id="{{ $skill_w->id }}">Delete</span> </li>
                @endforeach
            </ul>
            <button id="addSkill2" class="text-indigo-600 hover:underline text-sm cursor-pointer">Add Skill</button>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-10">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Requests I Sent</h2>
            <ul>
                <li class="mb-2">[Request to User X] - [Status]</li>
                <li class="mb-2">[Request to User Y] - [Status]</li>
            </ul>
            <a href="#" class="text-indigo-600 hover:underline text-sm">View All Sent Requests</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Requests I Received</h2>
            <ul>
                <li class="mb-2">[Request from User A] - [Pending/Accepted/Rejected]</li>
                <li class="mb-2">[Request from User B] - [Pending/Accepted/Rejected]</li>
            </ul>
            <a href="#" class="text-indigo-600 hover:underline text-sm">View All Received Requests</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-10">
        <h2 class="text-xl font-semibold mb-4">Find New Matches</h2>
        <div class="space-y-4">
            @if(isset($matchedUsers) && $matchedUsers->count() > 0)
                @foreach($matchedUsers as $matchedUser)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $matchedUser->name }}</h3>
                            </div>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition text-sm">
                                Send Request
                            </button>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium text-green-700 mb-2">They Have (You Want):</h4>
                                <ul class="text-sm">
                                    @foreach($matchedUser->skills->where('type', 'have') as $skill)
                                        @if(in_array($skill->skill_name, $skillsWant->pluck('skill_name')->toArray()))
                                            <li class="bg-green-100 text-green-800 px-2 py-1 rounded mb-1 inline-block mr-1">
                                                {{ $skill->skill_name }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-blue-700 mb-2">They Want (You Have):</h4>
                                <ul class="text-sm">
                                    @foreach($matchedUser->skills->where('type', 'want') as $skill)
                                        @if(in_array($skill->skill_name, $skillsHave->pluck('skill_name')->toArray()))
                                            <li class="bg-blue-100 text-blue-800 px-2 py-1 rounded mb-1 inline-block mr-1">
                                                {{ $skill->skill_name }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 mb-2">No matches found yet</p>
                    <p class="text-sm text-gray-400">Add more skills to find potential matches!</p>
                </div>
            @endif
        </div>
    </div>

    <div class="fixed left-[50%] top-[50%] -translate-x-[50%] -translate-y-[50%] bg-opacity-50 flex items-center justify-center z-50 hidden" id="skillModal">
        <div class="bg-blue-500 text-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Add New Skill</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                </button>
            </div>
            
            <form action="/add-skill" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="skill_name" class="block text-sm font-medium text-white mb-2">Skill Name</label>
                    <input type="text" id="skill_name" name="skill_name" required 
                           class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="e.g., Guitar, Cooking, Python">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-white mb-2">Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="type" value="have" checked class="mr-2">
                            <span>I Have This</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="want" class="mr-2">
                            <span>I Want This</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition">
                        Add Skill
                    </button>
                    <button type="button" id="cancelModal" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 transition cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
        <div class="fixed left-[50%] top-[50%] -translate-x-[50%] -translate-y-[50%] bg-opacity-50 flex items-center justify-center z-50 hidden" id="deleteSkillModal">
        <div class="bg-red-500 text-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">   
            <form action="/delete-skill" method="POST">
                @csrf
                <input type="hidden" id="deleteSkillId" name="skill_id">
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition">
                        Delete Skill
                    </button>
                    <button type="button" id="cancelDeleteModal" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 transition cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection