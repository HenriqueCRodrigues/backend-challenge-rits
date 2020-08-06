@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <a href="{{route('web.customers.all')}}">Customers</a><br>
                    <a href="{{route('web.products.all')}}">Products</a><br>
                    <a href="{{route('web.orders.all')}}">Orders</a><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
