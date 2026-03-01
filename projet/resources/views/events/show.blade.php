@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

    <div class="lg:col-span-2 space-y-6">
        <img
            src="{{ $event->image_url ?? 'https://via.placeholder.com/900x400' }}"
            class="rounded-xl w-full object-cover">

        <h1 class="text-3xl font-bold">{{ $event->title }}</h1>

        <p class="text-gray-600 leading-relaxed">
            {{ $event->description }}
        </p>
    </div>

    <div class="card p-6 space-y-4">
        <div>
            <p class="text-sm text-gray-500">Date</p>
            <p class="font-medium">
                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Lieu</p>
            <p class="font-medium">{{ $event->location }}</p>
        </div>

        {{-- On n'affiche le bouton d'inscription que si l'événement est PUBLIC --}}
        @if($event->visibility === 'PUBLIC')
            <a
                href="{{ route('events.register', $event) }}"
                class="btn-primary text-center"
            >
                S’inscrire
            </a>
        @else
            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                <p class="text-blue-700 text-sm text-center font-medium">
                    ✨ Vous êtes invité à cet événement privé.
                </p>
            </div>
        @endif
    </div>

</div>
<div class="mt-12 border-t pt-8">
    <h3 class="text-2xl font-bold mb-6">Avis des participants</h3>

    @if($event->feedbacks->count() > 0)
        <div class="flex items-center mb-8 bg-blue-50 p-4 rounded-lg">
            <div class="text-4xl font-bold text-blue-600 mr-4">
                {{ $event->averageRating() }} / 5
            </div>
            <div class="text-gray-600">
                Basé sur {{ $event->feedbacks->count() }} avis
            </div>
        </div>

        <div class="space-y-6">
            @foreach($event->feedbacks as $feedback)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-2">
                        <div class="font-semibold text-gray-800">
                            {{ $feedback->contact_name }}
                        </div>
                        <div class="flex text-yellow-400">
                            @foreach(range(1, 5) as $i)
                                @if($i <= $feedback->feedback_rating)
                                    ★
                                @else
                                    <span class="text-gray-300">★</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    @if($feedback->feedback_comment)
                        <p class="text-gray-600 italic">
                            "{{ $feedback->feedback_comment }}"
                        </p>
                    @else
                        <p class="text-gray-400 text-sm">L'utilisateur n'a pas laissé de commentaire écrit.</p>
                    @endif
                    
                    <div class="text-xs text-gray-400 mt-3">
                        Publié le {{ $feedback->updated_at->format('d/m/Y') }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 p-8 rounded-lg text-center text-gray-500 italic">
            Aucun avis n'a encore été publié pour cet événement.
        </div>
    @endif
</div>
@endsection