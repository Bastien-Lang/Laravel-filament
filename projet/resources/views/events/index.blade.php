@extends('layouts.app')

@section('title', 'Événements')

@section('content')
<h1 class="text-3xl font-bold mb-8">Événements à venir</h1>
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
        <strong class="font-bold">Succès !</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($events as $event)
        <a href="{{ route('events.show', $event) }}"
           class="card hover-lift overflow-hidden">

            <img
                src="{{ $event->image_url ?? 'https://via.placeholder.com/600x400' }}"
                class="h-48 w-full object-cover">

            <div class="p-5 space-y-2">
                <h2 class="text-lg font-semibold">{{ $event->title }}</h2>

                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                    — {{ $event->location }}
                </p>

                <span class="text-indigo-600 font-medium">
                    Voir l’événement →
                </span>
            </div>
        </a>
    @endforeach
    @if($events->hasPages())
        <div class="md:col-span-3">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection