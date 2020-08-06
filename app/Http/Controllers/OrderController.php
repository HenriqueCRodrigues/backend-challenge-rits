<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Http\Requests\OrderRequest;
use App\Http\Responses\GenericResponse;
use App\DataTables\OrdersDataTable;
use App\Models\Order;

class OrderController extends Controller
{
    protected $orderRepository;
    
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function storeFromCustomer($customerId, OrderRequest $request) {
        $data = $request->all();
        $data['customer_id'] = $customerId;
        $response = $this->orderRepository->storeFromCustomer($data);
        return GenericResponse::response($response);
    }

    public function showFromCustomer($customerId, $orderId) {
        $response = $this->orderRepository->showFromCustomer($customerId, $orderId);
        return GenericResponse::response($response);
    }

    public function allFromCustomer($customerId, Request $request) {
        $response = $this->orderRepository->allFromCustomer($customerId, $request->all());
        return GenericResponse::response($response);
    }

    public function cancelFromCustomer($customerId, $orderId) {
        $response = $this->orderRepository->cancelFromCustomer($customerId, $orderId);
        return GenericResponse::response($response);
    }

    public function deleteFromCustomer($customerId, $orderId) {
        $response = $this->orderRepository->deleteFromCustomer($customerId, $orderId);
        return GenericResponse::response($response);
    }
    
    
    public function changeStatus($orderId, Request $request) {
        $response = $this->orderRepository->changeStatus($orderId, $request->all());
        return GenericResponse::response($response);
    }

    public function delete($orderId) {
        $response = $this->orderRepository->delete($orderId);
        return GenericResponse::response($response);
    }    

    //WEB
    public function webAll(OrdersDataTable $dataTable) {
        return $dataTable->render('orders.index');
    }

    public function webStatusOrder($orderId, Request $request) {
        $order = Order::find($orderId);
        if($order->update($request->all())) {
            return redirect()->route('web.orders.all')->with('message', 'Product updated successfully!');
        }

        return redirect()->route('web.orders.all');
    }

    public function webDeleteProduct($productId) {
        $product = Product::find($productId);
        if($product->delete()) {
            return redirect()->route('web.orders.all')->with('message', 'Product deleted successfully!');
        }
    }
}
