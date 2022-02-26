<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    /**
     * Order Line Items of this Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderLineItems()
    {
        return $this->hasMany(OrderLineItem::class);
    }

    /**
     * User made this Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
