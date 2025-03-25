@extends('layouts.admindash')
@section('title')
    Categories
@endsection

@section('main')
    <div class="form-container">
        <h1 class="page-title-c">Categories</h1>
        <form action="{{route('categoriespost')}}" method="post">
            @csrf
            <div>
                <input type="text" name="category_name">
                <input type="submit" value="Add categorie" class="btn btn-primary">
            </div>
        </form>
    </div>
    <div>
        <div class="table-container-cat shadow">
            <table class="table table-responsive">
                <tr class="">
                    <th scope="col" class="table-active text-center">Category</th>
                    <th scope="col" class="table-active text-center">Actions</th>
                </tr>
                @if($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <tr>
                            <td scope="row" class="text-center">{{$category->category_name}}</td>
                            <td scope="row" class="text-center">
                                @csrf
                                <button class="btn btn-success modify-btn" 
                                        data-id="{{ $category->id }}"
                                        data-label="{{ $category->category_name }}">
                                    Modify
                                </button>
                                <a href="{{route('categorydelete',$category->id)}}" 
                                    class="text-center btn btn-danger" onclick="confirmation(event, 'This category will be deleted permanently!')">
                                    Delete
                                </a>                          
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" scope="row" class="text-center">there is no category.</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

    <!-- Modal for Modification -->
    <div class="modal fade" id="modifyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modify Category</h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="modifyForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="text" name="category_name" id="categoryNameInput" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="modifyForm" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/confirmationmsg.js')}}"></script>
    <script src="{{asset('js/categoriesmodify.js')}}"></script>
@endsection