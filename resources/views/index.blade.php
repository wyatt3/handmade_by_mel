@extends('layouts.app')

@section('content')
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-tertiary">
            <h1 class="display-4 fw-bolder">Shop Handmades</h1>
            <p class="lead fw-normal text-tertiary-50 mb-0"></p>
        </div>
    </div>
</header>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <listings></listings>
    </div>
</section>
@endsection