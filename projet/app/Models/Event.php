<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Registration;

class Event extends Model
{

    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'event_date',
        'location',
        'image_url',
        'visibility',
        'max_capacity',
        'status',
    ];

    public function organizer() {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Guest::class, Registration::class);
    }

    public function guests()
    {
        return $this->hasManyThrough(Guest::class, Registration::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Registration::class, 'event_id', 'event_id')
                    ->whereNotNull('feedback_rating')
                    ->orderBy('created_at', 'desc');
    }

    public function averageRating()
    {
        return round($this->feedbacks()->avg('feedback_rating'), 1);
    }
}
