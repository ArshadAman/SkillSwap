@extends('base')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Requests I Sent</h1>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-emerald-50 text-emerald-700 px-4 py-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-md bg-rose-50 text-rose-700 px-4 py-3">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="divide-y divide-gray-100">
            @forelse($sentRequests as $req)
                <div class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="space-y-1">
                        <div class="text-sm text-gray-500">To</div>
                        <div class="font-semibold text-gray-900">{{ $req->receiver->name ?? 'User' }}</div>
                        <div class="text-sm text-gray-500">{{ $req->receiver->email ?? '' }}</div>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $badge = [
                                'pending' => 'bg-yellow-50 text-yellow-700',
                                'accepted' => 'bg-emerald-50 text-emerald-700',
                                'rejected' => 'bg-rose-50 text-rose-700',
                            ][$req->status] ?? 'bg-gray-50 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded {{ $badge }} text-sm capitalize">{{ $req->status }}</span>

                        @if($req->status === 'accepted')
                            <a href="mailto:{{ $req->receiver->email ?? '' }}" class="text-indigo-600 text-sm hover:text-indigo-700">Contact</a>
                        @endif

                        @if($req->status === 'pending')
                            <form method="POST" action="{{ route('delete_skill_request', $req->id) }}">
                                @csrf
                                <button class="text-rose-600 text-sm hover:text-rose-700 cursor-pointer" type="submit">Cancel</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">No sent requests yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Dashboard</a>
    </div>
</div>
@endsection