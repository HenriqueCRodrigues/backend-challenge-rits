<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name'  => $faker->name,
        'email' => $faker->safeEmail, 
        'telephone' => $faker->phoneNumber,
        'address' => $faker->streetAddress
    ];
});


$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'  => $faker->name,
        'price' => $faker->randomFloat(2, 3, 60),
        'quantity' => $faker->numberBetween(2, 12),
    ];
});

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_id'  => Customer::all()->random()->id,
        'status' => $faker->randomElement(['Pendente', 'Em preparo', 'Em entrega', 'Entregue', 'Cancelado']),
    ];
});

$factory->define(OrderProduct::class, function (Faker $faker) {
    $product = Product::all()->random();
    $order = Order::all()->random();

    return [
        'product_id'  => $product->id,
        'order_id'    => $order->id,
        'price' => $product->price,
        'quantity' => intval($product->quantity*0.75),
    ];
});