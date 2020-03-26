@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row">

        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-12 mb-2">
                    <div class="card text-dark bg-warning">
                        <div class="card-header">
                            Placed/Accepted Orders
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-dark table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Area</th>
                                        <th>Pack Name</th>
                                        <th>Other</th>
                                        <th>Created At</th>
                                        <th>Required On</th>
                                        <th></th>
                                    </tr>
                                    @foreach ($placedOrders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->user->name}}</td>
                                        <td>{{$order->address}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>{{$order->area->name}}</td>
                                        <td>{{$order->pack->title}}- Rs: {{$order->pack->price}}</td>
                                        <td style="white-space: pre-wrap;">{{$order->other}}</td>
                                        <td>{{$order->created_at->diffForHumans()}}</td>
                                        <td>{{$order->required_date}}</td>
                                        <td>
                                            @if($order->status=='Placed')
                                            <a class="btn btn-sm btn-warning"
                                                href="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Accepted']) }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('order-deliver-form').submit();">Accept</a>

                                            <form id="order-deliver-form"
                                                action="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Accepted']) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>

                                            <a class="btn btn-sm btn-danger"
                                                href="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Rejected']) }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('order-deliver-form').submit();">Reject</a>

                                            <form id="order-deliver-form"
                                                action="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Rejected']) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            @elseif($order->status=='Accepted')
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Delivered']) }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('order-deliver-form').submit();">Mark as
                                                delivered</a>

                                            <form id="order-deliver-form"
                                                action="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Delivered']) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            {{ $placedOrders->links() }}
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-sm-12 mb-2">
                    <div class="card text-dark bg-warning">
                        <div class="card-header">
                            Delivered/Closed Orders
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-dark table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Area</th>
                                        <th>Pack Name</th>
                                        <th>Other</th>
                                        <th>Created At</th>
                                        <th>Required On</th>
                                        <th></th>
                                    </tr>
                                    @foreach ($otherOrders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->user->name}}</td>
                                        <td>{{$order->address}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>{{$order->area->name}}</td>
                                        <td>{{$order->pack->title}}- Rs: {{$order->pack->price}}</td>
                                        <td style="white-space: pre-wrap;">{{$order->other}}</td>
                                        <td>{{$order->created_at->diffForHumans()}}</td>
                                        <td>{{$order->required_date}}</td>
                                        <td>
                                            @if($order->status=='Delivered')
                                            <button class="btn btn-sm btn-success" type="button"
                                                disabled>Delivered</button>
                                            @elseif($order->status=='Rejected')
                                            <button class="btn btn-sm btn-danger" type="button" disabled>Order
                                                Rejected</button>
                                            @elseif($order->status=='Received')
                                            <button class="btn btn-sm btn-success" type="button" disabled>Customer
                                                Received</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            {{ $otherOrders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">

            <div class="card text-dark bg-success">
                <div class="card-header">
                    Add New Food Pack
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('packs.add') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Pack Name :</label>
                            <input required type="text" class="form-control" name="title" placeholder="Enter pack name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Price :</label>
                            <input required type="text" class="form-control" name="price" placeholder="Enter price">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Items :</label>
                            <textarea required name="items" class="form-control" id="exampleFormControlTextarea1"
                                rows="3" placeholder="Add items (Press Enter after each item)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </form>
                    <br />
                    <div id="agent-packs-wrapper">
                        <table class="table table-striped table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Items</th>
                                <th></th>
                            </tr>
                            @foreach ($packs as $pack)
                            @if($pack->is_active)
                            <tr>
                                <td>{{$pack->title}}</td>
                                <td>{{$pack->price}}</td>
                                <td style="white-space: pre-wrap;font-size: 0.7rem;">{{$pack->items}}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger"
                                        href="{{ route('packs.delete',['id'=>$pack->id]) }}" onclick="event.preventDefault();
                                    document.getElementById('pack-delete-form').submit();">X</a>

                                    <form id="pack-delete-form" action="{{ route('packs.delete',['id'=>$pack->id]) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
