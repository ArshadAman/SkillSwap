@extends('base')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

        <header>
            <h1 class="text-2xl font-bold text-gray-900">Skill Requests</h1>
            <p class="text-sm text-gray-500 mt-1">Review incoming requests and track what you’ve sent.</p>
        </header>

        @if(session('success'))
            <div class="rounded-md bg-emerald-50 text-emerald-700 px-4 py-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded-md bg-rose-50 text-rose-700 px-4 py-3">{{ session('error') }}</div>
        @endif

        <!-- Received Requests -->
        <section class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Requests I Received</h2>
                <p class="text-sm text-gray-500">Accept or reject pending requests.</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recievedRequests ?? [] as $req)
                    @if ($req->status == "pending")
                        <div class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="space-y-1">
                                <div class="text-sm text-gray-500">From</div>
                                <div class="font-semibold text-gray-900">{{ $req->sender?->name ?? 'User' }}</div>
                                <div class="text-sm text-gray-500">{{ $req->sender?->email ?? '' }}</div>
                            </div>

                            <div class="flex items-center gap-3">
                                @if($req->status === 'pending')
                                    <form method="POST" action="{{ route('update_skill_request', $req->id) }}">
                                        @csrf
                                        <input type="hidden" value="accept" name="action">
                                        <button type="submit"
                                            class="text-emerald-600 cursor-pointer text-sm hover:text-emerald-700">Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('update_skill_request', $req->id) }}">
                                        @csrf
                                        <input type="hidden" value="reject" name="reject">
                                        <button type="submit"
                                            class="text-rose-600 text-sm hover:text-rose-700 cursor-pointer">Reject</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="p-8 text-center text-gray-500">No incoming requests.</div>
                @endforelse
            </div>
        </section>
        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Dashboard</a>
        </div>
    </div>
@endsection