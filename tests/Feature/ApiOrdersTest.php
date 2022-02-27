<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiOrdersTest extends TestCase
{
    /**
     * Test the /api/orders API end-point with a vendor's token from a vendor that accepts JSON API format
     *
     * @return void
     */
    public function test_marco_fine_arts()
    {
        $plainTextToken = '1|KC529tN2rZQhLvTt3gDceiHjI4chdadJ8Ss6mhdc';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $plainTextToken,
        ])->get('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'orders' => [
                        '*' => [
                            'external_order_id',
                            'buyer_first_name',
                            'buyer_last_name',
                            'buyer_shipping_address_1',
                            'buyer_shipping_address_2',
                            'buyer_shipping_city',
                            'buyer_shipping_state',
                            'buyer_shipping_postal',
                            'buyer_shipping_country',
                            'print_line_items' => [
                                '*' => [
                                    'external_order_line_item_id',
                                    'product_id',
                                    'quantity',
                                    'image_url'
                                ]
                            ]
                        ]
                    ]
                ]
            ])
            ->assertJsonPath('data.orders.0.external_order_id', '12345')
            ->assertJsonPath('data.orders.0.buyer_first_name', 'John')
            ->assertJsonPath('data.orders.0.print_line_items.0.external_order_line_item_id', '45678')
        ;
    }
}
