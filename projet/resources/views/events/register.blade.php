@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="max-w-xl mx-auto card p-8">

    <h1 class="text-2xl font-bold mb-6">
        Inscription — {{ $event->title }}
    </h1>

    {{-- Global Error (e.g., Capacity full) --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store', $event) }}" method="POST" class="space-y-4">
        @csrf {{-- CRITICAL FIX --}}

        <div>
            <label class="label">Nom complet</label>
            <input type="text" name="contact_name" 
                   value="{{ old('contact_name') }}" 
                   class="input @error('contact_name') border-red-500 @enderror">
            @error('contact_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="label">Email</label>
            <input type="email" name="contact_email" 
                   value="{{ old('contact_email') }}" 
                   class="input @error('contact_email') border-red-500 @enderror">
            @error('contact_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="label">Présence</label>
            <select name="presence" class="input">
                <option value="Oui" {{ old('presence') == 'Oui' ? 'selected' : '' }}>Oui</option>
                <option value="Non" {{ old('presence') == 'Non' ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div>
            <label class="label">Nombre d’accompagnants (sans vous)</label>
            <input id="guests_count" name="guests_count" type="number" min="0" max="5" 
                value="{{ old('guests_count', 0) }}" 
                class="input @error('guests_count') border-red-500 @enderror">
            @error('guests_count') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div id="guests-container" class="space-y-6 mt-4"></div>

        <div>
            <label class="label">Contraintes alimentaires</label>
            <textarea name="dietary_notes" class="input">{{ old('dietary_notes') }}</textarea>
        </div>

        <button class="btn-primary w-full">
            Confirmer l’inscription
        </button>

    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const guestsInput = document.getElementById('guests_count');
    const container = document.getElementById('guests-container');

    guestsInput.addEventListener('input', function() {
        const count = parseInt(this.value) || 0;
        const currentGuests = container.querySelectorAll('.guest-form').length;

        if (count > currentGuests) {
            // Ajouter des formulaires
            for (let i = currentGuests; i < count; i++) {
                addGuestForm(i);
            }
        } else {
            // Supprimer les formulaires en trop
            const forms = container.querySelectorAll('.guest-form');
            for (let i = currentGuests - 1; i >= count; i--) {
                forms[i].remove();
            }
        }
    });

    function addGuestForm(index) {
        const html = `
            <div class="guest-form p-4 border-l-4 border-blue-500 bg-gray-50 rounded shadow-sm">
                <h3 class="font-semibold mb-3 text-blue-700">Accompagnant n°${index + 1}</h3>
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label class="text-sm font-medium">Nom complet</label>
                        <input type="text" name="guests[${index}][name]" required class="input bg-white">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" name="guests[${index}][email]" required class="input bg-white">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Contraintes alimentaires</label>
                        <textarea name="guests[${index}][dietary]" class="input bg-white" rows="2"></textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }
});
</script>
@endsection