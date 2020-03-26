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
    <form method="POST" action="{{ route('users.add') }}">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Name :</label>
            <input required type="text" value="{{ old('name') }}" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label>Username :</label>
            <input required type="text" value="{{ old('username') }}" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label>Password :</label>
            <input required type="text" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Contact details :</label>
            <textarea name="agent_contact_details" class="form-control" rows="3">{{ old('agent_contact_details') }}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Delivery Areas :</label>
            <textarea required placeholder="Comma Separated" name="areas" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('areas') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Save</button>
    </form>
</div>
@endsection
