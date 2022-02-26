<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creative_id',
        'product_type_id',
    ];

    /**
     * Order Line Items of this Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderLineItems()
    {
        return $this->hasMany(OrderLineItem::class);
    }

    /**
     * Product Type of this Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Creative this Product is made from
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creative()
    {
        return $this->belongsTo(Creative::class);
    }
}
