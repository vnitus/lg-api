<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderLineItem>
 */
class OrderLineItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $products = Product::all();
        $vendors = Vendor::all();

        return [
            'product_id' => $products->random()->id,
            'quantity' => random_int(1, 10),
            'vendor_id' => $vendors->random()->id,
        ];
    }
}
