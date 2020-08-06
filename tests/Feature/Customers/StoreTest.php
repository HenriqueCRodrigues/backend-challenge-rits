<?php

namespace Tests\Feature\Customers;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreTest extends TestCase
{
    use DatabaseMigrations;

    private function storeCustomerThroughTheApi(Customer $customer = null) {
        $customer = $customer ?? collect([]);
        return $this->postJson(route('customers.store'), $customer->toArray());
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
        ->storeCustomerThroughTheApi($customer, $merge)
        ->assertStatus(422);
        */

        $this->storeCustomerThroughTheApi($customer, $merge)
        ->assertStatus(422);

        $merge['created_at'] = now(); 
        $merge['updated_at'] = now();
        $this->checkCustomerDatabaseMissing($customer, $merge);
    }

    public function it_should_store_in_authenticated() {
        $this->storeCustomerThroughTheApi()
        ->assertStatus(422);
        //->assertUnauthorized();
    }

    /** @test */
    public function it_should_store_in_database() {
        Carbon::setTestNow(now());

        $customer = factory(Customer::class)->make();

        $this->storeCustomerThroughTheApi($customer)
        ->assertSuccessful();
        
        $this->checkCustomerDatabaseHas($customer, ['created_at' => now(), 'updated_at' => now()]);
    }
    
    /** @test */
    public function name_input_field_is_required() {
        $this->unitInputApi('name');
    }

    /** @test */
    public function email_input_field_is_required() {
        $this->unitInputApi('email');
    }

    /** @test */
    public function email_input_field_is_email() {
        $this->unitInputApi('email', 'string');
    }

    /** @test */
    public function email_input_field_unique() {
        $this->unitInputApi('email', 'unique:customers,email');
    }
    
    /** @test */
    public function telephone_input_field_is_required() {
        $this->unitInputApi('telephone');
    }

    /** @test */
    public function address_input_field_is_required() {
        $this->unitInputApi('address');
    }
}
