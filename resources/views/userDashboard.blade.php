@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-7">
            <input id="search-input" placeholder="Search by area to find packs near" class="form-control">
            <br />
            <div class="text-center" id="spinner">
                <i class="fa fa-3x fa-spinner fa-spin"></i>
                <p>Searching...</p>
            </div>
            <div class="alert alert-warning" id="no-packs-warning">No Packs :(.</div>
            <div class="alert alert-info" id="select-pack-alert">Click on the pack you want.</div>
            <div class="card-columns" id="card-columns">
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card text-dark bg-warning">
                <div class="card-header">
                    Previous Orders
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-dark">
                            <tr>
                                <th>Pack</th>
                                <th>Ordered At</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{$order->pack->title}}</td>
                                <td>{{$order->created_at->diffForHumans()}}</td>
                                <td>
                                    @if($order->status=='Delivered')
                                    <a class="btn btn-sm btn-success"
                                        href="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Received']) }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('order-deliver-form').submit();">Mark as received</a>

                                    <form id="order-deliver-form"
                                        action="{{ route('orders.changeStatus',['id'=>$order->id,'status'=>'Received']) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    @else
                                    <span class="badge badge-light">{{$order->status}}</span>
                                    @endif
                                </td>
                                <td>
                                <button data-items="{{$order->pack->items}}" data-name="{{$order->pack->user->name}}" data-details="{{$order->pack->user->agent_contact_details}}" class="btn btn-sm btn-info view-agent">View</button>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="delivery-area-names" value="{{$areas}}" />
<div class="modal fade" id="order-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pack-order-form" method="POST" action="{{ route('packs.addOrder') }}">
                    @csrf
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label for="date">Required Date (mm/dd/yyyy / Today is default)</label>
                        <input type="date" id="date" class="form-control" name="required_date"
                            placeholder="Required Date (mm/dd/yyyy)">
                    </div>
                    <div class="form-group">
                        <label for="other">Other Items</label>
                        <textarea name="other" class="form-control" id="other" rows="3"
                            placeholder="Other items"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea required name="address" class="form-control" id="address" rows="3"
                            placeholder="Enter address"></textarea>
                    </div>
                    <input type="hidden" id="pack_id" name="pack_id">
                    <input type="hidden" id="area_name" name="area_name">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a class="btn btn-success" href="{{ route('packs.addOrder') }}" onclick="event.preventDefault();
                    document.getElementById('pack-order-form').submit();">Submit</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/system.js') }}"></script>
@endsection
