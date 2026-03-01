<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Mail\EventAttendanceConfirmation;
use App\Http\Controllers\FeedbackController;
use App\Models\User;
use App\Models\Event;

    Route::get('/', [EventController::class, 'index'])->name('index');


Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');

    Route::get('/{event}/register', [EventController::class, 'register'])->name('register');
    Route::post('/{event}/register', [EventController::class, 'store'])->name('store');

    Route::get('/{event}/confirmation', [EventController::class, 'confirmation'])->name('confirmation');
});


Route::get('/registration/{event}/cancel', [RegistrationController::class, 'cancel'])->name('registration.cancel');

Route::get('/mail-preview', function () {
    $event = Event::findOrFail(1); 
    $user = User::where('email', $event->organizer->email)->firstOrFail();

    return new EventAttendanceConfirmation($event, $user);
});

Route::get('/feedback/{token}', [FeedbackController::class, 'show'])->name('feedback.show');
Route::post('/feedback/{token}', [FeedbackController::class, 'store'])->name('feedback.store');