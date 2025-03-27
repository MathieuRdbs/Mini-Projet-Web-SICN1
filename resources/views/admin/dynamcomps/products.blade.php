@extends('layouts.admindash')
@section('title')
    Products
@endsection

@section('main')
    <div class="form-container">
        <h1 class="page-title-c">Products</h1>
        @csrf
        <div>
            <button class="btn btn-primary add-btn">
                Add Product
            </button>
        </div>
    </div>
    <div>
        <div class="table-container-cat shadow">
            <table class="table table-responsive">
                <tr class="">
                    <th scope="col" class="table-active text-center">image</th>
                    <th scope="col" class="table-active text-center">name</th>
                    <th scope="col" class="table-active text-center">description</th>
                    <th scope="col" class="table-active text-center">category</th>
                    <th scope="col" class="table-active text-center">price</th>
                    <th scope="col" class="table-active text-center">quantity</th>
                    <th scope="col" class="table-active text-center">Actions</th>
                </tr>
                @if($products->isNotEmpty())
                    @foreach($products as $product)
                        <tr>
                            <td scope="row" class="text-center">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" width="50" height="50">
                                @endif
                            </td>
                            <td scope="row" class="text-center">{{ $product->name }}</td>
                            <td scope="row" class="text-center">{{ Str::limit($product->description, 50) }}</td>
                            <td scope="row" class="text-center">{{ $product->category->category_name}}</td>
                            <td scope="row" class="text-center">{{ $product->price }}</td>
                            <td scope="row" class="text-center">{{ $product->quantity }}</td>
                            <td scope="row" class="text-center">
                                @csrf
                                <button class="btn btn-success modify-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-description="{{ $product->description }}"
                                    data-price="{{ $product->price }}"
                                    data-quantity="{{ $product->quantity }}"
                                    data-category="{{ $product->category_id }}"
                                    data-image="{{ $product->image }}">
                                    Modify
                                </button>
                                <a href="{{ route('productdelete', $product->id) }}" 
                                    class="text-center btn btn-danger" onclick="confirmation(event, 'This product will be deleted permanently!')">
                                    Delete
                                </a>                          
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" scope="row" class="text-center">there is no Product.</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="productForm" method="POST" enctype="multipart/form-data">
                    @csrf                   
                    <div class="modal-body">
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        <input type="hidden" id="productId" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productPrice" class="form-label">Price</label>
                                    <input type="number" step="0.01" class="form-control" id="productPrice" name="price" required>
                                </div>                               
                                <div class="mb-3">
                                    <label for="productQuantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="productQuantity" name="quantity" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productCategory" class="form-label">Category</label>
                                    <select class="form-select" id="productCategory" name="category_id" required>
                                        <option>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Product Image</label>
                                    <input type="file" class="form-control" id="productImage" name="image" accept="image/*">
                                    <div class="mt-2" id="imagePreviewContainer" style="display: none;">
                                        <img id="imagePreview" src="#" alt="Preview" style="max-height: 100px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset('js/productmodifadd.js')}}"></script>
@endsection