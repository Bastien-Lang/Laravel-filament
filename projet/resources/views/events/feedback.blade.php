@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto card p-8">
    <h1 class="text-2xl font-bold mb-2">Votre avis nous intéresse</h1>
    <p class="text-gray-600 mb-6">Comment s'est passé l'événement <strong>{{ $event->title }}</strong> ?</p>

    <form action="{{ route('feedback.store', $registration->feedback_token) }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="label">Note (sur 5)</label>
            <div class="flex space-x-4">
                @foreach(range(1, 5) as $i)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                        <span class="w-10 h-10 flex items-center justify-center border rounded peer-checked:bg-blue-500 peer-checked:text-white">
                            {{ $i }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="mb-6">
            <label class="label">Votre commentaire (optionnel)</label>
            <textarea name="comment" rows="4" class="input" placeholder="Ce que vous avez aimé ou ce qu'on peut améliorer..."></textarea>
        </div>

        <button class="btn-primary w-full">Envoyer mon avis</button>
    </form>
</div>
@endsection