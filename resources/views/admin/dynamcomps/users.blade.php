@extends('layouts.admindash')
@section('title')
    Users
@endsection

@section('main')
    <div class="form-container">
        <h1 class="page-title-c">Users</h1>
    </div>
    <div>
        <div class="table-container-cat shadow">
            <table class="table table-responsive">
                <tr class="">
                    <th scope="col" class="table-active text-center">Username</th>
                    <th scope="col" class="table-active text-center">email</th>
                    <th scope="col" class="table-active text-center">Phone number</th>
                    <th scope="col" class="table-active text-center">Action</th>
                </tr>
                @if($users->isNotEmpty())
                    @foreach ($users as $user)
                        <tr>
                            <td scope="row" class="text-center">{{$user->fullname}}</td>
                            <td scope="row" class="text-center">{{$user->email}}</td>
                            <td scope="row" class="text-center">{{$user->phonenumber}}</td>
                            <td scope="row" class="text-center">
                                <a href="{{route('userdelete', $user->id)}}" 
                                    class="text-center btn btn-danger" onclick="confirmation(event, 'The user {{$user->fullname}} will be deleted permanently!')">
                                    Delete
                                </a>                          
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" scope="row" class="text-center">there is no users.</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection