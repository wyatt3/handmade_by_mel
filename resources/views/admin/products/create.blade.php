@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <h1>Create A Product</h1>
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        <label>Name*</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        <label>SKU*</label>
        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        <label>Price*</label>
        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
        <label>Sale Price</label>
        <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
        <label>Category</label>
        <select name="product_category_id" class="form-control">
            <option value="">Select a category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <label>Images</label>
        <input type="file" name="images[]" class="form-control" multiple>
        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
@endsection