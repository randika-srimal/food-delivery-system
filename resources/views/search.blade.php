@extends('layouts.app')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css" rel="stylesheet">
@endsection
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
        <div class="col-lg-12">
            <input id="search-input" autofocus placeholder="Search by location to find packs near you" class="form-control">
            <br />
            <div class="text-center" id="spinner">
                <i class="fa fa-3x fa-spinner fa-spin"></i>
                <p>Searching...</p>
            </div>
            <div class="alert alert-warning" id="no-packs-warning">No Packs :(.</div>
            <div class="alert alert-info" id="select-pack-alert">Click on the pack to zoom.</div>
            <div class="card-columns" id="card-columns">
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="delivery-area-names" value="{{$areas}}" />
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
<script src="{{ asset('js/search.js') }}"></script>
@endsection
