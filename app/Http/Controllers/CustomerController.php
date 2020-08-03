<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use App\Http\Requests\CustomerRequest;
use App\Http\Responses\GenericResponse;

class CustomerController extends Controller
{
    protected $customerRepository;
    
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function store(CustomerRequest $request) {
        $data = $this->customerRepository->store($request->all());
        return GenericResponse::response($data);
    }
}
