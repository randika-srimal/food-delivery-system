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
            <input id="search-input" autofocus placeholder="Search by location to find packs near you"
                class="form-control">
            <br />
            <div class="text-center" id="spinner">
                <i class="fa fa-3x fa-spinner fa-spin"></i>
                <p>Searching...</p>
            </div>
            <div class="alert alert-warning d-none" id="no-packs-warning">No Packs :(.</div>
            <div class="text-left mb-3 text-dark bg-secondry" id="select-pack-alert">Click on the pack to zoom.</div>
            <div class="card-columns" id="card-columns">
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="delivery-area-names" value="{{$areas}}" />
<input type="hidden" id="auth-user-id" value="{{Auth::check()?Auth::user()->id:null}}"/>
@endsection
