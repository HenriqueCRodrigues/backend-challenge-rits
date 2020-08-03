<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function store($data) {
        try {
    
            \DB::beginTransaction();
            $product = Product::create($data);

            if ($product) {
                \DB::commit();
                return ['message' => $product, 'status' => 200];
            }
            
            \DB::rollback();
            return ['message' => 'Product not created', 'status' => 422];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }
}
