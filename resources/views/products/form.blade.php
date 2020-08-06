<html> 
    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Products</title> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> 

    </head> 
    <body> 
        <div class="container"> <br /> 
            <h3 align="center">Products</h3> <br /> 
            <div class="table-responsive"> 
                <div class="panel panel-default"> 
                    <div class="panel-heading"></div> 
                    <div class="panel-body"> 
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br />
                    @endif
                    
                    
                    <form method="POST" action="{{isset($product) ? route('web.products.update', ['productId' => $product->id]) : route('web.products.store')}}">
                    
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputname1">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputname1" aria-describedby="nameHelp" placeholder="Enter name" value="{{isset($product) ? $product->name : ''}}">
                            <small id="nameHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputprice1">Price</label>
                            <input type="text" name="price" class="form-control" id="exampleInputprice1" aria-describedby="priceHelp" placeholder="Enter price" value="{{isset($product) ? $product->price : ''}}">
                            <small id="priceHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputquantity1">Quantity</label>
                            <input type="text" name="quantity" class="form-control" id="exampleInputquantity1" aria-describedby="quantityHelp" placeholder="Enter quantity" value="{{isset($product) ? $product->quantity : ''}}">
                            <small id="quantityHelp" class="form-text text-muted"></small>
                        </div>

                        <a href="{{route('web.products.all')}}" class="btn btn-primary">Back</a>
                        @if (isset($product))
                            <button type="submit" class="btn btn-primary">Update</button>
                        @else
                            <button type="submit" class="btn btn-primary">Create</button>
                        @endif
                        </form>
                    </div> 
                </div> 
            </div> <br /> <br /> 
        </div> 
    </body> 
</html>