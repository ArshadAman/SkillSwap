@extends('base')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <header class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ $user->name ?? '-' }}</h1>
                <p class="text-sm text-gray-500 mt-1">Manage your skills and find good matches</p>
            </div>
            <div class="hidden md:flex items-center gap-4 text-sm">
                <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">Have: {{ $skillsHave->count() }}</span>
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700">Want: {{ $skillsWant->count() }}</span>
            </div>
        </header>

        <div class="grid md:grid-cols-3 gap-6">
            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">My Profile</h2>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Name</dt>
                        <dd class="text-gray-900">{{ $user->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Email</dt>
                        <dd class="text-gray-900">{{ $user->email ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Contact</dt>
                        <dd class="text-gray-900">{{ $user->contact_info ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Skills I Have</h2>
                    <button id="addSkill"
                        class="text-sm px-3 py-1 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Add</button>
                </div>
                <ul class="flex flex-wrap gap-2">
                    @forelse($skillsHave as $skill)
                        <li
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-800 text-sm">
                            <span>{{ $skill->skill_name }}</span>
                            <button class="deleteModal text-red-500 hover:text-red-600" data-id="{{ $skill->id }}"
                                title="Delete">&times;</button>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">No skills yet</li>
                    @endforelse
                </ul>
            </section>

            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Skills I Want</h2>
                    <button id="addSkill2"
                        class="text-sm px-3 py-1 rounded-md bg-emerald-600 text-white hover:bg-emerald-700">Add</button>
                </div>
                <ul class="flex flex-wrap gap-2">
                    @forelse($skillsWant as $skill_w)
                        <li
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-sm">
                            <span>{{ $skill_w->skill_name }}</span>
                            <button class="deleteModal text-red-500 hover:text-red-600" data-id="{{ $skill_w->id }}"
                                title="Delete">&times;</button>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">No wishes yet</li>
                    @endforelse
                </ul>
            </section>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Requests I Sent</h2>
                <ul class="space-y-2 text-sm">
                    @forelse($sentRequests as $req)
                        <li class="flex items-center justify-between border border-gray-100 rounded-md p-3">
                            <span>Request sent to {{ $req->receiver?->name }}</span>
                            @php
                                $badge = [
                                    'pending' => 'bg-yellow-50 text-yellow-700',
                                    'accepted' => 'bg-emerald-50 text-emerald-700',
                                    'rejected' => 'bg-rose-50 text-rose-700',
                                ][$req->status] ?? 'bg-gray-50 text-gray-700';
                            @endphp
                            <span class="px-2 py-0.5 rounded {{ $badge }} capitalize">
                                {{ $req->status }}
                            </span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">You have not sent any request</li>
                    @endforelse
                </ul>
                <a href="{{ route('view_sent_request') }}" class="mt-4 text-indigo-600 hover:text-indigo-700 text-sm">View
                    all</a>
            </section>

            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Requests I Received</h2>
                <div class="space-y-3 mb-4">
                    @if(session('success-update'))
                        <div class="rounded-md bg-emerald-50 text-emerald-700 px-4 py-3">{{ session('success-update') }}</div>
                    @endif
                    @if(session('error-update'))
                        <div class="rounded-md bg-rose-50 text-rose-700 px-4 py-3">{{ session('error-update') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="rounded-md bg-amber-50 text-amber-800 px-4 py-3">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <ul class="space-y-2 text-sm">
                    @forelse($recievedRequests as $req)
                        @if ($req->status = "pending")
                            <li class="flex items-center justify-between border border-gray-100 rounded-md p-3">
                                <div>
                                    <div>{{ $req->sender?->name }}</div>
                                    <span>Have: </span>
                                    @foreach ($req->sender?->skills as $skill)
                                        @if ($skill->type == "have" && $user->skills->where('type', 'want')->pluck('skill_name')->contains($skill->skill_name))
                                            <span>{{ $skill->skill_name }}</span> |
                                        @endif
                                    @endforeach
                                    <span>Want: </span>
                                    @foreach ($req->sender?->skills as $skill)
                                        @if ($skill->type == "want" && $user->skills->where('type', 'have')->pluck('skill_name')->contains($skill->skill_name))
                                            <span>{{ $skill->skill_name }}</span> |
                                        @endif
                                    @endforeach
                                </div>
                                @if($req->status == 'pending')
                                    <div class="flex space-x-3">
                                        <form method="POST" action="{{ route('update_skill_request', $req->id) }}">
                                            @csrf
                                            <input type="hidden" value="accept" name="action">
                                            <button type="submit"
                                                class="text-emerald-600 cursor-pointer text-sm hover:text-emerald-700">Accept</button>
                                        </form>
                                        <form method="POST" action="{{ route('update_skill_request', $req->id) }}">
                                            @csrf
                                            <input type="hidden" value="reject" name="action">
                                            <button type="submit"
                                                class="text-rose-600 text-sm hover:text-rose-700 cursor-pointer">Reject</button>
                                        </form>
                                    </div>
                                @endif
                            </li>
                        @endif
                    @empty
                        <li class="text-sm text-gray-500">You have not recieved any request</li>
                    @endforelse
                </ul>
                <a href="{{ route("view_recieved_request") }}"
                    class="mt-4 text-indigo-600 hover:text-indigo-700 text-sm">View all</a>
            </section>
        </div>

        <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Matched Users</h2>
            </div>
            <div class="space-y-4">
                @forelse(($matchedUsers ?? collect()) as $req)
                    <div class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Partner</div>
                            <div class="font-semibold text-gray-900">
                                {{ $req->sender_id === auth()->id() ? ($req->receiver?->name ?? 'User') : ($req->sender?->name ?? 'User') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $req->sender_id === auth()->id() ? ($req->receiver?->email ?? '') : ($req->sender?->email ?? '') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $req->sender_id === auth()->id() ? ($req->receiver?->contact_info ?? '-') : ($req->sender?->contact_info ?? '-') }}
                            </div>
                        </div>
                        <div>
                            <span>Have: </span>
                            @foreach ($req->sender?->skills as $skill)
                                @if ($skill->type == "have" && $user->skills->where('type', 'want')->pluck('skill_name')->contains($skill->skill_name))
                                    <span>{{ $skill->skill_name }}</span> |
                                @endif
                            @endforeach
                            <span>Want: </span>
                            @foreach ($req->sender?->skills as $skill)
                                @if ($skill->type == "want" && $user->skills->where('type', 'have')->pluck('skill_name')->contains($skill->skill_name))
                                    <span>{{ $skill->skill_name }}</span> |
                                @endif
                            @endforeach
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 text-sm">Accepted</span>
                            <a class="text-indigo-600 text-sm hover:text-indigo-700"
                                href="mailto:{{ $req->sender_id === auth()->id() ? ($req->receiver?->email ?? '') : ($req->sender?->email ?? '') }}">
                                Email
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">No accepted requests yet.</div>
                @endforelse
                <a href="{{ route("view_accepted") }}" class="mt-4 text-indigo-600 hover:text-indigo-700 text-sm">View
                    all</a>
            </div>
        </section>

        <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Find New Matches</h2>
            </div>

            <div class="space-y-3 mb-4">
                @if(session('success'))
                    <div class="rounded-md bg-emerald-50 text-emerald-700 px-4 py-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="rounded-md bg-rose-50 text-rose-700 px-4 py-3">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="rounded-md bg-amber-50 text-amber-800 px-4 py-3">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                @if(isset($eligibleMatches) && $eligibleMatches->count() > 0)
                    @foreach($eligibleMatches as $eligibleMatch)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $eligibleMatch->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $eligibleMatch->email }}</p>
                                </div>
                                <form action="/send-request/{{ $user->id }}/" method="post" class="flex-none">
                                    @csrf
                                    <input type="hidden" name="matched_user_id" value="{{ $eligibleMatch->id }}">
                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-3 py-2 rounded-md text-sm hover:bg-indigo-700 cursor-pointer">
                                        Send Request
                                    </button>
                                </form>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">They have (you want)</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($eligibleMatch->skills->where('type', 'have') as $skill)
                                            @if(in_array($skill->skill_name, $skillsWant->pluck('skill_name')->toArray()))
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700">{{ $skill->skill_name }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">They want (you have)</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($eligibleMatch->skills->where('type', 'want') as $skill)
                                            @if(in_array($skill->skill_name, $skillsHave->pluck('skill_name')->toArray()))
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-emerald-50 text-emerald-700">{{ $skill->skill_name }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500">No matches yet. Add more skills to improve your matches.</p>
                    </div>
                @endif
            </div>
        </section>

        <div id="skillModal" class="fixed left-[50%] top-[50%] -translate-x-[50%] -translate-y-[50%] z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-xl border border-gray-200 shadow-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">Add New Skill</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>

                <form action="/add-skill" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="skill_name" class="block text-sm font-medium text-gray-700">Skill Name</label>
                        <input id="skill_name" name="skill_name" type="text" required
                            class="mt-2 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="e.g., Guitar, Python, Cooking">
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-2">Type</span>
                        <div class="flex items-center gap-6 text-sm">
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="type" value="have" checked>
                                <span>I have this</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="type" value="want">
                                <span>I want this</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">
                            Add Skill
                        </button>
                        <button type="button" id="cancelModal"
                            class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Skill Modal (centered, no backdrop) -->
        <div id="deleteSkillModal" class="fixed left-[50%] top-[50%] -translate-x-[50%] -translate-y-[50%] z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-xl border border-gray-200 shadow-2xl p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Delete skill</h3>
                <p class="text-sm text-gray-600 mb-6">This action cannot be undone.</p>

                <form action="/delete-skill" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" id="deleteSkillId" name="skill_id">
                    <div class="flex items-center gap-3">
                        <button type="submit" class="flex-1 bg-rose-600 text-white py-2 rounded-md hover:bg-rose-700">
                            Delete
                        </button>
                        <button type="button" id="cancelDeleteModal"
                            class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection