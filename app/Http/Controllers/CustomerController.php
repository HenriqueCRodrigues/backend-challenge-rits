<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use App\Http\Requests\CustomerRequest;
use App\Http\Responses\GenericResponse;
use App\DataTables\CustomersDataTable;
use App\Models\Customer;

class CustomerController extends Controller
{
    protected $customerRepository;
    
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function store(CustomerRequest $request) {
        $response = $this->customerRepository->store($request->all());
        return GenericResponse::response($response);
    }

    //WEB
    public function webAll(CustomersDataTable $dataTable) {
        return $dataTable->render('customers.index');
    }

    public function webCreateCustomer() {
        return view('customers.form');
    }

    public function webEditCustomer($customerId) {
        $customer = Customer::find($customerId);
        return view('customers.form', compact('customer'));
    }

    public function webStoreCustomer(Request $request) {
        if(Customer::create($request->all())) {
            return redirect()->route('web.customers.all')->with('message', 'Customer updated successfully!');
        }

        return view('customers.form');
    }

    public function webUpdateCustomer($customerId, Request $request) {
        $customer = Customer::find($customerId);
        if($customer->update($request->all())) {
            return redirect()->route('web.customers.all')->with('message', 'Customer updated successfully!');
        }

        return view('customers.form', compact('customer'));
    }

    public function webDeleteCustomer($customerId) {
        $customer = Customer::find($customerId);
        if($customer->delete()) {
            return redirect()->route('web.customers.all')->with('message', 'Customer deleted successfully!');
        }
    }
}
