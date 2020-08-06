<?php

use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total = 5;
        factory(App\Models\Customer::class, $total)->create();
        factory(App\Models\Product::class, $total)->create();
        factory(App\Models\Order::class, $total)->create();
        factory(App\Models\OrderProduct::class, $total*5)->create();
    }
}
