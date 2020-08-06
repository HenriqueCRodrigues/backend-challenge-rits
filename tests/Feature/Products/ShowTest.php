<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowTest extends TestCase
{
    use DatabaseMigrations;

    private function showProductThroughTheApi(Product $product = null) {
        return $this->withHeaders([
            'Accept', 'application/json'
          ])->getJson(route('products.show', ['productId' => $product->id]));
    }

    private function allProductThroughTheApi(Product $product = null) {
        return $this->withHeaders([
            'Accept', 'application/json'
          ])->postJson(route('products.all'));
    }

    private function checkProductDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('products', $item);
    }

    /** @test */
    public function it_should_show_in_authenticated() {
        $product = factory(Product::class)->create();
        $this->showProductThroughTheApi($product)
        ->assertUnauthorized();
    }


    /** @test */
    public function it_should_show_in_database() {
        Carbon::setTestNow(now());

        $user = factory(User::class)->create();
        \Auth::login($user);
        $product = factory(Product::class)->create();

        $this->showProductThroughTheApi($product)
        ->assertSuccessful();

        $this->checkProductDatabaseHas($product, ['created_at' => now(), 'updated_at' => now()]);
    }


    /** @test */
    public function it_should_all_in_database() {
        Carbon::setTestNow(now());
        $user = factory(User::class)->create();
        \Auth::login($user);
        $product = factory(Product::class)->create();

        $this->allProductThroughTheApi($product)
        ->assertSuccessful();

        $this->checkProductDatabaseHas($product, ['created_at' => now(), 'updated_at' => now()]);
    }
}
