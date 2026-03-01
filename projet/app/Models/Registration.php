<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\GuestStatusEnum;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'contact_name',
        'contact_email',
        'status',
        'feedback_token',   
        'feedback_rating',  
        'feedback_comment'
    ];

    protected $casts = [
        'status' => GuestStatusEnum::class,
    ];

    public function event() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

        public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
