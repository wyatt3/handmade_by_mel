@extends('layouts.app')

@section('content')

<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <a href="{{ route('home') }}" class="d-block mb-2 text-dark"><i class="bi bi-arrow-left-circle"></i> back to all products</a>
        <product-page :product="{{ json_encode($product) }}"></product-page>
    </div>
</section>
<!-- Related items section-->
<section class="py-5 bg-secondary">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder text-tertiary mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-lg-4 justify-content-center">
            @foreach ($related as $relatedProduct)
            <listing :product="{{ json_encode($relatedProduct) }}"></listing>
            @endforeach
        </div>
    </div>
</section>

@endsection
