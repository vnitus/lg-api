<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Order Line Items of this Vendor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderLineItems()
    {
        return $this->hasMany(OrderLineItem::class);
    }

    /**
     * Product Types this Vendor offer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productTypes()
    {
        return $this->belongsToMany(ProductType::class);
    }
}
