<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteTest extends TestCase
{
    use DatabaseMigrations;
    
    private function deleteProductThroughTheApi(Product $product = null) {
        $product = $product ?? collect([]);
        return $this->withHeaders([
            'Accept', 'application/json'
          ])->deleteJson(route('products.delete', ['productId' => $product->id]), $product->toArray());
    }

    private function checkProductDatabaseMissing($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseMissing('products', $item);
    }

    /** @test */
    public function it_should_delete_in_authenticated() {
        $product = factory(Product::class)->create();
        $this->deleteProductThroughTheApi($product)
        ->assertUnauthorized();
    }

    /** @test */
    public function it_should_delete_in_database() {
        Carbon::setTestNow(now());

        $user = factory(User::class)->create();
        \Auth::login($user);
        $product = factory(Product::class)->create();

        $this->deleteProductThroughTheApi($product)
        ->assertSuccessful();

        $this->checkProductDatabaseMissing($product, ['created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()]);
    }
}
