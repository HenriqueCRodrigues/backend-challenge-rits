<html> 
    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Customers</title> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> 

    </head> 
    <body> 
        <div class="container"> <br /> 
            <h3 align="center">Customers</h3> <br /> 
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
                    
                    
                    <form method="POST" action="{{isset($customer) ? route('web.customers.update', ['customerId' => $customer->id]) : route('web.customers.store')}}">
                    
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputname1">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputname1" aria-describedby="nameHelp" placeholder="Enter name" value="{{isset($customer) ? $customer->name : ''}}">
                            <small id="nameHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputemail1">Email</label>
                            <input type="text" name="email" class="form-control" id="exampleInputemail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{isset($customer) ? $customer->email : ''}}">
                            <small id="emailHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtelephone1">Telephone</label>
                            <input type="text" name="telephone" class="form-control" id="exampleInputtelephone1" aria-describedby="telephoneHelp" placeholder="Enter telephone" value="{{isset($customer) ? $customer->telephone : ''}}">
                            <small id="telephoneHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputaddress1">Address</label>
                            <input type="text" name="address" class="form-control" id="exampleInputaddress1" aria-describedby="addressHelp" placeholder="Enter address" value="{{isset($customer) ? $customer->address : ''}}">
                            <small id="addressHelp" class="form-text text-muted"></small>
                        </div>

                        <a href="{{route('web.customers.all')}}" class="btn btn-primary">Back</a>
                        @if (isset($customer))
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