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
        <div class="table-container-cat">
            <table class="table table-responsive table-bordered">
                <tr>
                    <th scope="col" class="table-active text-center">Category</th>
                    <th scope="col" class="table-active text-center">Actions</th>
                </tr>
                @if($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <tr>
                            <td scope="row" class="text-center">{{$category->category_name}}</td>
                            <td scope="row" class="text-center">
                                @csrf
                                <a href="{{route('categorydelete',$category->id)}}" class="text-center btn btn-danger" onclick="confirmation(event)">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" scope="row" class="text-center">there is no category.</td>
                    </tr>
                @endempty
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function confirmation(event){
            event.preventDefault();
            var url = event.currentTarget.getAttribute('href');
            swal({
                icon: 'warning',
                title: 'Are you sure you want to delete this!',
                text: 'this category will be deleted permanently',
                buttons: true,
                dangermode : true
            }).then(
                (willcancel)=>{
                    if (willcancel) {
                        window.location.href = url;
                    }
                }
            );
        }
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
        };
    </script>
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
@endsection