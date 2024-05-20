<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Events\OrderStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($order) {
            if ($order->isDirty('status') && $order->status === OrderStatus::Delivered && is_null($order->delivered_at)) {
                event(new OrderStatusUpdated($order));
            }
        });
    }
    protected $fillable = [
        'number',
        'total_price',
        'status',
        'delivered_at',
        'notes',
    ];

    protected $casts = [
        'status' => OrderStatus::class,

    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

}
