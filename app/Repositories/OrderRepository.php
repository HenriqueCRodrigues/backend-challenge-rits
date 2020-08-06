<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;

class OrderRepository
{
    public function storeFromCustomer($data) {
        try {
    
            \DB::beginTransaction();
            $order = Order::create($data);

            if ($order) {
                $data = $this->insertProductsInOrder($data['products'], $order->id);
                if ($data['status'] == 200) {
                    \DB::commit();
                    return ['message' => $order, 'status' => 200];
                }
            }
            
            \DB::rollback();
            return ['message' => 'Order not created', 'status' => 422];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }

    public function insertProductsInOrder($data, $orderId) {
        try {

            $orderProducts = [];
            \DB::beginTransaction();
            foreach($data as $product) {
                $orderProducts[] = [
                    'order_id' => $orderId,
                    'product_id' => $product['id'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                ];
            }

            if (OrderProduct::insert($orderProducts)) {
                \DB::commit();
                return ['message' => 'OrderProduct created', 'status' => 200];
            }
            
            \DB::rollback();
            return ['message' => 'OrderProduct not created', 'status' => 422];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }   
    }

    public function showFromCustomer($customerId, $orderId) {
        try {
            $order = Order::where('customer_id', $customerId)
            ->where('id', $orderId)
            ->first();

            if ($order) {
                return ['message' => $order, 'status' => 200];
            }

            return ['message' => 'Pedido não encontrado', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }      
    }

    public function allFromCustomer($customerId, $data) {
        try {
            $orders = Order::where('customer_id', $customerId)
            ->paginate(10);
            return ['message' => $orders, 'status' => 200];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }      
    }

    public function cancelFromCustomer($customerId, $orderId) {
        try {
            $order = Order::find($orderId);

            if ($order) {
                if ($order->where('customer_id', $customerId)->update(['status' => 'Cancelado'])) {
                    return ['message' => 'Pedido Cancelado', 'status' => 200];
                }
                return ['message' => 'Não tem autorização para realizar essa ação', 'status' => 401];
            }

            return ['message' => 'Pedido não encontrado', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }      
    }

    public function deleteFromCustomer($customerId, $orderId) {
        try {
            $order = Order::find($orderId);

            if ($order) {
                if ($order->where('customer_id', $customerId)->delete()) {
                    return ['message' => 'Pedido Deletado', 'status' => 200];
                }
                return ['message' => 'Não tem autorização para realizar essa ação', 'status' => 401];
            }

            return ['message' => 'Pedido não encontrado', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }      
    }

    public function changeStatus($orderId, $data) {
        try {
            $order = Order::find($orderId);

            if ($order->update($data)) {
                return ['message' => 'Pedido Alterado', 'status' => 200];
            }

            return ['message' => 'Pedido não encontrado', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }      
    }

    public function delete($orderId) {
        try {
            $order = Order::find($orderId);

            if ($order->delete()) {
                return ['message' => 'Pedido Deletado', 'status' => 200];
            }

            return ['message' => 'Pedido não encontrado', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }      
    }
}
