@extends('base')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Accepted Requests</h1>

        @if(session('success'))
            <div class="mb-4 rounded-md bg-emerald-50 text-emerald-700 px-4 py-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-md bg-rose-50 text-rose-700 px-4 py-3">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="p-6 border-b border-gray-100">
                <p class="text-sm text-gray-500">These swaps are confirmed. Use the contact info to coordinate.</p>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse(($acceptedRequests ?? collect()) as $req)
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
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Dashboard</a>
        </div>
    </div>
@endsection