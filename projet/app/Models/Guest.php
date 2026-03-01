<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\GuestStatusEnum;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'full_name',
        'dietary_notes',
        'is_primary',
        'email',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function registration(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function inviter() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function getRegistrationStatusAttribute() : GuestStatusEnum
    {
        return $this->registration ? $this->registration->status : 'N/A';
    }

    // public function invitees() : \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(Guest::class, 'invited_by_id');
    // }

}
