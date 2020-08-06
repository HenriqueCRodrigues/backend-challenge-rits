<?php

namespace Tests\Feature\Orders;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActionTest extends TestCase
{
    use DatabaseMigrations;

    private function orderStatusChangeThroughTheApi($orderId = 0, array $data = []) {
        return $this->withHeaders([
            'Accept', 'application/json'
          ])->putJson(route('orders.change', ['orderId' => $orderId]), $data);
    }

    private function checkOrderDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('orders', $item);
    }

    /** @test */
    public function it_should_store_in_authenticated() {
        $this->orderStatusChangeThroughTheApi()
        ->assertUnauthorized();
    }

    /** @test */
    public function it_should_order_change_status_in_database() {
        Carbon::setTestNow(now());
        $user = factory(User::class)->create();
        \Auth::login($user);
        $customer = factory(Customer::class)->create();
        $order = factory(Order::class)->create();
        $data = ['Pendente', 'Em preparo', 'Em entrega', 'Entregue', 'Cancelado'];
        $index = array_rand($data);

        $this->orderStatusChangeThroughTheApi($order->id, ['status' => $data[$index]])
        ->assertSuccessful();
        $order->status = $data[$index]; 
        $this->checkOrderDatabaseHas($order, ['created_at' => now(), 'updated_at' => now()]);
    } 
}
