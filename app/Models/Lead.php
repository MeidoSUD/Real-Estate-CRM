<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'property_offer_id',
        'message',
        'status',
        'assigned_to',
        'notes',
    ];

    public function propertyOffer(): BelongsTo
    {
        return $this->belongsTo(PropertyOffer::class, 'property_offer_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
