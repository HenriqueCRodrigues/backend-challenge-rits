<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function store($data) {
        try {
    
            \DB::beginTransaction();
            $customer = Customer::create($data);

            if ($customer) {
                \DB::commit();
                return ['message' => $customer, 'status' => 200];
            }
            \DB::rollback();
            return ['message' => 'Product not updated', 'status' => 422];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }
}
