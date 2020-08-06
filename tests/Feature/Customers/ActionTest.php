<?php

namespace Tests\Feature\Customers;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActionTest extends TestCase
{
    use DatabaseMigrations;

    private function orderCreateCustomerThroughTheApi($customerId, array $data = null) {
        return $this->postJson(route('customers.orders.create', ['customerId' => $customerId]), $data);
    }

    private function showOrderThroughTheApi($customerId, $orderId) {
        return $this->get(route('customers.orders.show', ['customerId' => $customerId, 'orderId' => $orderId]));
    }

    private function loginUserThroughTheApi($user) {
        $token = $user->createToken(['TestToken'], [])->accessToken;

        return $this->withHeaders([
            'X-Access-Token' => $token,
        ]);
    }

    private function checkCustomerDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('customers', $item);
    }

    private function checkCustomerDatabaseMissing($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseMissing('customers', $item);
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
            } else if ($meta[0] == 'unique') {
                $customer = factory(Customer::class)->create();
                $merge = [$input => $customer->email];
            }
        }

        $customer = factory(Customer::class)->make($merge);
        
        /*
        $this->loginUserThroughTheApi($user)
        ->orderCreateCustomerThroughTheApi($customer, $merge)
        ->assertStatus(422);
        */

        $this->orderCreateCustomerThroughTheApi($customer, $merge)
        ->assertStatus(422);

        $merge['created_at'] = now(); 
        $merge['updated_at'] = now();
        $this->checkCustomerDatabaseMissing($customer, $merge);
    }

    /** @test */
    public function it_should_order_create_in_database() {
        $customer = factory(Customer::class)->create();
        $products = factory(Product::class, 10)->create()->shuffle()->random(3)->toArray();

        $order = factory(Order::class)->make(['customer_id' => $customer->id])->toArray();
        $order['products'] = $products;

        $this->orderCreateCustomerThroughTheApi($customer->id, $order)
        ->assertSuccessful();
    } 

    /** @test */
    public function it_should_show_order_in_database() {
        $customer = factory(Customer::class)->create();
        $products = factory(Product::class, 10)->create();
        $order = factory(Order::class)->create();
        $orderProduct = factory(OrderProduct::class, 3)->create();

        $this->showOrderThroughTheApi($customer->id, $order->id)
        ->assertSuccessful();
    }
}
