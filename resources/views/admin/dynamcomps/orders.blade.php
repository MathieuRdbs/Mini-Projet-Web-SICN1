@extends('layouts.admindash')
@section('title')
    Orders
@endsection
@section('main')
    <div class="form-container">
        <h1 class="page-title-c">Orders</h1>
    </div>
    <div>
        <div class="table-container-cat shadow">
            <table class="table table-responsive">
                <tr>
                    <th scope="col" class="table-active text-center">User</th>
                    <th scope="col" class="table-active text-center">Shipping Address</th>
                    <th scope="col" class="table-active text-center">Status</th>
                    <th scope="col" class="table-active text-center">Total</th>
                    <th scope="col" class="table-active text-center">Payment method</th>
                    <th scope="col" class="table-active text-center">Actions</th>
                </tr>
                @if($orders->isNotEmpty())
                    @foreach ($orders as $order)
                        <tr>
                            <td scope="row" class="text-center">{{$order->user->fullname}}</td>
                            <td scope="row" class="text-center">{{Str::limit($order->shipping_address, 10, '...')}}</td>
                            <td scope="row" class="text-center">{{$order->status}}</td>
                            <td scope="row" class="text-center">{{$order->total_price}} dh</td>
                            <td scope="row" class="text-center">{{$order->payment_methode}}</td>
                            <td scope="row" class="text-center">
                                @csrf
                                <button class="btn btn-primary show-btn" 
                                    data-order="{{json_encode($order)}}"
                                    data-cart="{{json_encode($order->carts)}}"> 
                                    show </button>
                                @if ($order->status == 'pendding')
                                    <a href="{{route('ordership', $order->id)}}"
                                        class="btn btn-success" > 
                                        ship 
                                    </a>
                                    <a href="{{route('ordercancel', $order->id)}}"
                                        class="text-center btn btn-danger" 
                                        onclick="confirmation(event, 'This order will be cancled!')">
                                        Cancel
                                    </a> 
                                @endif                   
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" scope="row" class="text-center">there is no order.</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="m-4">
            {{$orders->links()}}
        </div>
    </div>

    <div class="modal fade" id="ShowModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mhead">
                    {{-- header from js --}}
                </div>

                <div class="modal-body mbody">
                    {{-- order details --}}
                </div>
                    
                <div class="modal-footer">
                    <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/ordershowadmin.js')}}"></script>
@endsection