<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 10 creative users, each made 5 creatives
        User::factory()
            ->count(10)
            ->hasCreatives(5)
            ->create();
    }
}
