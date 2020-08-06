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
            \DB::rollback();
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }

    public function update($productId, $data) {
        try {
    
            \DB::beginTransaction();
            $product = Product::find($data);

            if ($product) {
                if ($product->update($data)) {
                    \DB::commit();
                    return ['message' => $product, 'status' => 200];
                }

                \DB::rollback();
                return ['message' => 'Product not updated', 'status' => 422];
            }
            
            \DB::rollback();
            return ['message' => 'Product not find', 'status' => 404];
        } catch (\Exception $e) {
            \DB::rollback();
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }

    public function show($productId) {
        try {
    
            $product = Product::find($productId);

            if ($product) {
                return ['message' => $product, 'status' => 200];
            }
            
            return ['message' => 'Product not find', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }

    public function all($data) {
        try {
    
            $product = Product::paginate(10);

            if ($product) {
                return ['message' => $product, 'status' => 200];
            }
            
            return ['message' => 'Product not find', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }

    
    public function delete($productId) {
        try {
    
            $product = Product::find($productId);

            if ($product) {
                if ($product->delete()) {
                    return ['message' => 'Product deleted', 'status' => 200];
                }

                return ['message' => 'Product not deleted', 'status' => 422];
            }
            
            return ['message' => 'Product not find', 'status' => 404];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }        
    }
}
