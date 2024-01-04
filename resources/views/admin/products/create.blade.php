@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <h1>Create A Product</h1>
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label>Name*</label>
        <input type="text" name="name" class="form-control mb-3" value="{{ old('name') }}" required>
        @if($errors->has('name'))
        <div class="text-danger">{{ $errors->first('name') }}</div>
        @endif
        <label>SKU*</label>
        <input type="text" name="sku" class="form-control mb-3" value="{{ old('sku') }}" required>
        @if($errors->has('sku'))
        <div class="text-danger">{{ $errors->first('sku') }}</div>
        @endif
        <label>Description</label>
        <textarea name="description" class="form-control mb-3">{{ old('description') }}</textarea>
        @if($errors->has('description'))
        <div class="text-danger">{{ $errors->first('description') }}</div>
        @endif
        <label>Price*</label>
        <div class="input-group mb-3">
            <div class="input-group-text">$</div>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>
        @if($errors->has('price'))
        <div class="text-danger">{{ $errors->first('price') }}</div>
        @endif
        <label>Sale Price</label>
        <div class="input-group mb-3">
            <div class="input-group-text">$</div>
            <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
        </div>
        @if($errors->has('sale_price'))
        <div class="text-danger">{{ $errors->first('sale_price') }}</div>
        @endif
        <label>Category</label>
        <select name="product_category_id" class="form-control mb-3">
            <option value="">Select a category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        @if($errors->has('product_category_id'))
        <div class="text-danger">{{ $errors->first('product_category_id') }}</div>
        @endif
        <label>Images</label>
        <input type="file" name="images[]" class="form-control mb-3" multiple>
        @if($errors->has('images'))
        <div class="text-danger">{{ $errors->first('images') }}</div>
        @endif
        <button type="submit" class="btn btn-primary mb-5">Create</button>
    </form>
</div>
@endsection