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
                                        data-name="{{ $category->category_name }}">
                                    Modify
                                </button>
                                <a href="{{route('categorydelete',$category->id)}}" class="text-center btn btn-danger" onclick="confirmation(event)">Delete</a>                          
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="modifyForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="text" name="category_name" id="categoryNameInput" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Modify button click handler
        $(document).ready(function() {
            $('.modify-btn').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#modifyForm').attr('action', `/categories/${id}`);
                $('#categoryNameInput').val(name);
                $('#modifyModal').modal('show');
            });
            $('#modifyForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modifyModal').modal('hide');
                        toastr.success(response.success);
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            });
        });
        function confirmation(event){
            event.preventDefault();
            var url = event.currentTarget.getAttribute('href');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This category will be deleted permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', 
                cancelButtonColor: '#3085d6', 
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
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