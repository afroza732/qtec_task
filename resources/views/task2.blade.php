<!DOCTYPE html>
<html>
<head>
    <title>Task 2</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<style>
    .item{
        color:black !important;
    }
</style>
<body>
    <h3 class="text-center text-light bg-info p-2">Pattern match</h3>
<div class="container-fluid">
    <h3>The pattern {{ $pattern }} occurs {{ $count }} times in the text {{ $text }}</h3>
</div><br>
<div class="text-center">
    <a href="{{ url('/') }}" class="btn btn-info">Back</a>
</div>

</body>
