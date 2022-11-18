<!DOCTYPE html>
<html>
<head>
    <title>Task 1</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<style>
    .item{
        color:black !important;
    }
</style>
<body>
    <h3 class="text-center text-light bg-info p-2">Product Searching</h3>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <h5>Search Product</h5>
            <hr>
            <h6 class="text-info">Keyword</h6>
            <input class="form-control" type="text" name="keywword" id="keyword">
            <h6 class="text-info">Category</h6>
            <ul class="list-group">
                @foreach ($categories as $category)
                <li class="list-group-item">
                    <div class="form-check">
                        <label class="form-check-item">
                            <input type="checkbox" class="form-check-input product_check" value="{{ $category->id }}" id="category_id">{{ $category->name }}
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
            <h6 class="text-info">User</h6>
            <ul class="list-group">
                @foreach ($users as $user)
                <li class="list-group-item">
                    <div class="form-check">
                        <label class="form-check-item">
                            <input type="checkbox" class="form-check-input product_check" value="{{ $user->id }}"  id="user">{{ $user->name }}
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
            <h6 class="text-info">Time Range</h6>
            <ul class="list-group">
                @foreach ($time_ranges as $time)
                <li class="list-group-item">
                    <div class="form-check">
                        <label class="form-check-item">
                            <input type="checkbox" class="form-check-input time_check" value="{{ $time }}"  id="time">{{ $time }}
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
            <h6 class="text-info">Date Range</h6>
            <div class="row">
                <div class="col-md-4">

                    <input class="form-control datepicker" type="text" placeholder="Start Date" name="start_date" id="start_date">
                </div>
                <div class="col-md-4">
                    <input class="form-control datepicker" type="text" name="end_date" placeholder="End Date" id="end_date">
                </div>
                <div class="col-md 4">
                    <button class="btn btn-info" type="submit" id="search_date">Search</button>
                </div>
            </div>
            <br>
            <div class="text-center">
                <a href="{{ url('/') }}" class="btn btn-info">Back</a>
            </div>
        </div>
        <div class="col-md-8">
            <h5 class="text-center text-info text_change">All Products</h5>
            <hr>
            <div class="text-center">
                <img src="{{ asset("images/loader.gif") }}"  width="200" id="loader" style="display: none">
            </div>
            <div class="row" id="result">
                @foreach ($products as $product)

                <div class="cl-md-3 mb-2 mr-2">
                    <div class="card-dect">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                              <h5 class="card-title">{{ $product->name }}</h5>
                              <h6 class="card-subtitle mb-2 text-muted">Price : {{ $product->price }}</h6>
                              <p class="card-text">{{ $product->description }}</p>
                              <a href="#" class="card-link">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-md-3">
                <h6 class="text-center text-light p-2  bg-info"><span class="count">{{ count($products) }}</span> Items found</h6>
            </div>
        </div>

    </div>
</div><br>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>
    $(function () {
  $(".datepicker").datepicker({
        autoclose: true,
        //todayHighlight: true
  });
});

    $(document).ready(function(){

        //filter_data();

        function filter_data()
        {

            var keyword = $('#keyword').val();
            $("#loader").show();
            var category = get_filter('category_id');
            var user = get_filter('user');
            var time = $('#time:checked').val();
            var start_date = $('#start_date').val();
            var end_date   = $('#end_date').val();
            $.ajax({
                url: '{{url("autocomplete")}}',
                method:"GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{keyword:keyword,category:category, user:user,time:time,start_date:start_date,end_date:end_date},
                success:function(data){
                    $("#loader").hide();
                    var output = "";
                    $(data).each(function( index,value ) {
                       output += `
                       <div class="cl-md-3 mb-2 mr-2">
                            <div class="card-dect">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                    <h5 class="card-title">${value.name}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted"> Price : ${value.price}</h6>
                                    <p class="card-text">${value.description}</p>
                                    <a href="#" class="card-link">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                       `;
                    });
                    $('#result').html(output);
                    $(".count").text(data.length);
                }
            });
        }

        function get_filter(text_id)
        {
            var filter = [];
            $('#'+text_id+':checked').each(function(){
                filter.push($(this).val());
            });
            return filter;
        }

        $('.product_check').click(function(){
            filter_data();
        });
        $('.time_check').click(function(){
            filter_data();
        });
        $('#keyword').on('keyup',function(){
        //$('#search').click(function(){
            filter_data();
        });
        $('#search_date').click(function(){
            filter_data();
        });
    });
    </script>

</body>
