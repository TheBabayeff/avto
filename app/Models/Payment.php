<?php

namespace App\Models;

use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sum',
        'type',
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'type' => PaymentType::class,

    ];
}

