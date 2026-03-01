@extends('layouts.app')

@section('title', 'Confirmation')

@section('content')
<div class="max-w-lg mx-auto card p-10 text-center space-y-4">

    <h1 class="text-3xl font-bold text-indigo-600">🎉 Merci !</h1>

    <p class="text-gray-600">
        Votre inscription a bien été prise en compte.
    </p>

    <p class="text-sm text-gray-500">
        Vous recevrez un email de confirmation prochainement.
    </p>

    <a href="{{ route('events.index') }}" class="text-indigo-600 font-medium">
        ← Retour aux événements
    </a>

</div>
@endsection