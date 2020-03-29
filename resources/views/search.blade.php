@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-{{ session('status') }} alert-dismissible fade show main-alert" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <input id="search-input" value="{{$city?$city->name_en:''}}" autofocus
                placeholder="Search by city to find services" class="form-control">
            <br />
            <button type="button" id="share-btn" class="mb-3 btn btn-md btn-info">
                <i class="fa fa-facebook"></i> <span id="share-btn-text">Share on Facebook</span>
            </button>
            <div class="text-center" id="spinner">
                <i class="fa fa-3x fa-spinner fa-spin"></i>
                <p>Searching...</p>
            </div>
            <div class="alert alert-warning d-none" id="no-packs-warning">No Packs :(.</div>
            <div class="card-columns" id="card-columns">
            </div>
        </div>
    </div>
</div>
<a href="javascript:void(0)" data-toggle="modal" data-target="#add-pack-modal" class="float">
    <i class="fa fa-plus my-float"></i>
</a>
<input type="hidden" id="delivery-area-names" value="{{$areas}}" />
<input type="hidden" id="auth-user-id" value="{{Auth::check()?Auth::user()->id:null}}" />
@endsection
