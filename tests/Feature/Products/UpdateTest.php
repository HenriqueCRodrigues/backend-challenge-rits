<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Str;
use Spatie\Activitylog\ActivityLogger;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateTest extends TestCase
{
    use DatabaseMigrations;

    private function updateProductThroughTheApi(Product $product = null) {
        $product = $product ?? collect([]);
        return $this->withHeaders([
            'Accept', 'application/json'
          ])->putJson(route('products.update'), $product->toArray());
    }

    private function loginUserThroughTheApi($user) {
        $token = $user->createToken(['TestToken'], [])->accessToken;

        return $this->withHeaders([
            'X-Access-Token' => $token,
        ]);
    }

    private function checkProductDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('products', $item);
    }

    private function checkProductDatabaseMissing($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseMissing('products', $item);
    }

    private function unitInputApi($input, $meta = null) {
        Carbon::setTestNow(now());


        $merge = [];

        $merge[$input] = $meta;
        if ($meta) {
            $meta = explode(':', $meta);
            if ($meta[0] == 'max') {
                $merge[$input] = Str::random($meta[1]+1);
            } else if ($meta[0] == 'exists') {
                $meta[1] = explode(',', $meta[1]);
                return $this->assertDatabaseMissing($meta[1][0], [$meta[1][1] => '']);
            }
        }

        $product = factory(Product::class)->make($merge);

        $user = factory(User::class)->create();
        \Auth::login($user);
        
        $this->updateProductThroughTheApi($product, $merge)
        ->assertStatus(422);

        $merge['created_at'] = now(); 
        $merge['updated_at'] = now();
        $this->checkProductDatabaseMissing($product, $merge);
    }

    /** @test */
    public function it_should_store_in_authenticated() {
        $this->updateProductThroughTheApi()
        ->assertUnauthorized();
    }

    /** @test */
    public function it_should_store_in_database() {
        Carbon::setTestNow(now());
        $user = factory(User::class)->create();
        \Auth::login($user);
        $product = factory(Product::class)->create();

        $this->checkProductDatabaseHas($product, ['created_at' => now(), 'updated_at' => now()]);
    }
    
    /** @test */
    public function name_input_field_is_required() {
        $this->unitInputApi('name');
    }

    /** @test */
    public function price_input_field_is_required() {
        $this->unitInputApi('price');
    }

    /** @test */
    public function price_input_field_is_numeric() {
        $this->unitInputApi('price', 'string');
    }
}
