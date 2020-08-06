<?php

namespace Tests\Feature\Orders;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteTest extends TestCase
{
    use DatabaseMigrations;
    
    private function deleteOrderThroughTheApi(Order $order = null) {
        $order = $order ?? collect([]);
        return $this->withHeaders([
            'Accept' => 'application/json'
          ])->delete(route('orders.delete', ['orderId' => $order->id]), $order->toArray());
    }

    private function checkOrderDatabaseMissing($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseMissing('orders', $item);
    }

    /** @test */
    public function it_should_delete_in_authenticated() {
        $customer = factory(Customer::class)->create();
        $order = factory(Order::class)->create();

        $this->deleteOrderThroughTheApi($order)
        ->assertUnauthorized();
    }

    /** @test */
    public function it_should_delete_in_database() {
        Carbon::setTestNow(now());
        $user = factory(User::class)->create();
        \Auth::login($user);
        $customer = factory(Customer::class)->create();
        $order = factory(Order::class)->create();

        $this->deleteOrderThroughTheApi($order)
        ->assertSuccessful();

        $this->checkOrderDatabaseMissing($order, ['created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()]);
    }
}
