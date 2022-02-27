<?php

namespace Database\Seeders;

use App\Models\Creative;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\PersonalAccessToken;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ask in terminal if we wanna seed extra data (beyond the test scope)
        $extraData = $this->command->ask('Do you want to seed extra data beyond the test? (y/n)');

        // Generate 3 initial seed product types (test data), 2 initial seed vendors (test data) and attach them
        $productType1 = ProductType::create([
            'name' => 'Fine Art Print',
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        $vendor1 = Vendor::create([
            'name' => 'Marco Fine Arts',
            'api_format' => 'json',
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        $vendor1->productTypes()->attach($productType1);

        $productType2 = ProductType::create([
            'name' => 'T-shirt',
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        $vendor2 = Vendor::create([
            'name' => 'DreamJunction',
            'api_format' => 'xml',
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        $vendor2->productTypes()->attach($productType2);

        ProductType::create(['name' => 'mug']);

        // Generate 1 initial seed admin user
        $adminUser = User::create([
            'name' => 'William',
            'email' => 'william Wallace <william.wallace@leafgroup.com>',
            'password' => '$2y$10$HwKpJl920MbZukc.a62YpOWtCRwLoW5i.SLvkIYxNBsKxeurIs6r6',
            'api_token' => 'ScukuepUoGL0ywMufxheQMscLJqi5BXa7s4LkbECiauOXj40krZyQcMjo7ZChIuxklkGBuOQnqN7f8Dm'
        ]);

        // Generate 2 initial seed vendor users (test data) and set personal access token to them
        $user = User::create([
            'name' => 'Macro Fine Arts user',
            'email' => 'macrofinearts@example.com',
            'password' => bcrypt('password'),
            'vendor_id' => 1
        ]);

        PersonalAccessToken::create([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'api_token',
            'token' => '074a99613158dbdcffabc4559c6cf000624a32a676ffca97b9a6f6469db18870', // plain text: 1|KC529tN2rZQhLvTt3gDceiHjI4chdadJ8Ss6mhdc
            'abilities' => '["*"]'
        ]);

        $user = User::create([
            'name' => 'Dreamjunction user',
            'email' => 'dreamjunction@example.com',
            'password' => bcrypt('password'),
            'vendor_id' => 2
        ]);

        PersonalAccessToken::create([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'api_token',
            'token' => 'b6ba7344060bc3a267c9a191f18d507f1add86e2cfdec68f1054dd7e4b49f201', // plain text: 2|aCR1QySwvBlwJmXEEKJGLzQdji4sT0UWjVQ0PmPS
            'abilities' => '["*"]'
        ]);

        // Generate 1 initial seed creative (test data)
        $creative = Creative::create([
            'user_id' => $adminUser->id,
            'image_url' => 'https://bucket.s3.amazonsaws.com/images/image.jpg',
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        // Generate 2 initial seed products (test data)
        $product1 = Product::create([
            'creative_id' => $creative->id,
            'product_type_id' => $productType1->id,
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        $product2 = Product::create([
            'creative_id' => $creative->id,
            'product_type_id' => $productType2->id,
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        // Generate 1 initial seed order (test data)
        $order = Order::create([
            'user_id' => $adminUser->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address_1' => '123 Main Street',
            'city' => 'Santa Monica',
            'state' => 'CA',
            'postal_code' => '90014',
            'country' => 'US',
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        // Generate 2 initial seed order line items (test data)
        OrderLineItem::create([
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'vendor_id' => $vendor1->id,
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        OrderLineItem::create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'quantity' => 3,
            'vendor_id' => $vendor2->id,
            'created_at' => '2021-06-08 00:00:00',
            'updated_at' => '2021-06-08 00:00:00'
        ]);

        // Generate extra data so we can test with big data outside the initial test scope
        if ($extraData === 'y' || $extraData === 'Y') {
            $this->extraData();
        }
    }

    /**
     * Seed extra data (beyond the test scope)
     *
     * @throws \Exception
     */
    private function extraData()
    {
        // Generate 10 extra vendors and 2 vendor users for each of them
        // Also generate 10 creative users and 5 creatives for each of them
        $this->call([
            VendorSeeder::class,
            UserSeeder::class,
        ]);

        // Generate a product for each creative for all product types
        $productTypes = ProductType::all();
        $creatives = Creative::all();
        foreach ($productTypes as $productType) {
            foreach ($creatives as $creative) {
                Product::create([
                    'creative_id' => $creative->id,
                    'product_type_id' => $productType->id
                ]);
            }
        }

        // Generate 10 extra regular (buyer) users, each made 0 - 5 orders, and each order has 1 - 5 order line items
        User::factory(10)->has(
            Order::factory(random_int(0, 5))
                ->has(OrderLineItem::factory(random_int(1, 5)))
        )->create();
    }
}
