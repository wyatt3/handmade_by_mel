@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1>Products</h1>
    <a class="btn btn-primary" href="{{ route('products.create') }}">Create</a>
    <product-list></product-list>
</div>
@endsection