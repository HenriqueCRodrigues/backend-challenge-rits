<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function storeFromCustomer($data) {
        try {
    
            \DB::beginTransaction();
            $order = Order::create($data);

            if ($order) {
                \DB::commit();
                return ['message' => $order, 'status' => 200];
            }
            
            \DB::rollback();
            return ['message' => 'Order not created', 'status' => 422];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }
}
