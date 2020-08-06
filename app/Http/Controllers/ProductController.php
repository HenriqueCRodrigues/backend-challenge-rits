<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Responses\GenericResponse;
use App\DataTables\ProductsDataTable;

class ProductController extends Controller
{
    protected $productRepository;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(ProductRequest $request) {
        $response = $this->productRepository->store($request->all());
        return GenericResponse::response($response);
    }

    public function update($productId, ProductRequest $request) {
        $response = $this->productRepository->update($productId, $request->all());
        return GenericResponse::response($response);
    }

    public function show($productId) {
        $response = $this->productRepository->show($productId);
        return GenericResponse::response($response);   
    }

    public function all(Request $request) {
        $response = $this->productRepository->all($request->all());
        return GenericResponse::response($response);   
    }

    public function delete($productId) {
        $response = $this->productRepository->delete($productId);
        return GenericResponse::response($response);   
    }


    //WEB
    public function webAll(ProductsDataTable $dataTable) {
        return $dataTable->render('products.index');
    }

    public function webCreateProduct() {
        return view('products.form');
    }

    public function webEditProduct($productId) {
        $product = Product::find($productId);
        return view('products.form', compact('product'));
    }

    public function webStoreProduct(Request $request) {
        if(Product::create($request->all())) {
            return redirect()->route('web.products.all')->with('message', 'Product updated successfully!');
        }

        return view('products.form', compact('product'));
    }

    public function webUpdateProduct($productId, Request $request) {
        $product = Product::find($productId);
        if($product->update($request->all())) {
            return redirect()->route('web.products.all')->with('message', 'Product updated successfully!');
        }

        return view('products.form');
    }

    public function webDeleteProduct($productId) {
        $product = Product::find($productId);
        if($product->delete()) {
            return redirect()->route('web.products.all')->with('message', 'Product deleted successfully!');
        }
    }
    
}
