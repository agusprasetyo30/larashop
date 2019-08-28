@extends('layouts.global')

@section('title', 'Edit User')
@section('page_title', 'Edit User')

@section('content')

<div class="col-md-8">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="bg-white shadow-sm p-3" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        <label for="name">Name</label>
        <input class="form-control" type="text" name="name" placeholder="Full Name" value="{{ $user->name }}" id="name"/><br>

        <label for="status">Status</label><br>

        <input {{ $user->status == 'ACTIVE' ? 'checked' : '' }} type="radio" class="form-control" value="ACTIVE" id="active" name="status">
        <label for="active">Active</label>

        <input {{ $user->status == 'INACTIVE' ? 'checked' : '' }} type="radio" class="form-control" value="INACTIVE" id="inactive" name="status">
        <label for="inactive">Inactive</label><br/>

        <label for="username">Username</label>
        <input class="form-control" type="text" name="username" placeholder="Username" value="{{ $user->username }}" id="username" disabled/><br>

        <label for="">Roles</label><br>
        <input type="checkbox" name="roles[]" value="ADMIN" id="ADMIN"
            {{ in_array("ADMIN", json_decode($user->roles)) ? "checked" : "" }}/>
        <label for="ADMIN">Administrator</label>

        <input type="checkbox" name="roles[]" value="STAFF" id="STAFF"
            {{ in_array("STAFF", json_decode($user->roles)) ? "checked" : "" }}/>
        <label for="STAFF">Staff</label>

        <input type="checkbox" name="roles[]" value="CUSTOMER" id="CUSTOMER"
            {{ in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : "" }}/>
        <label for="CUSTOMER">Customer</label><br/>

        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}"><br>

        <label for="address">Address</label>
        <textarea class="form-control" name="address" id="address" cols="30" rows="5">{{ $user->address }}</textarea><br/>

        <label for="avatar">Avatar image</label>
        <br/>
        Current avatar : <br/>
        @if ($user->avatar)
            <img src="{{ asset('storage/'. $user->avatar) }}" width="120px"><br/>
        @else
            No Avatar
        @endif
        <br/>
        <input type="file" name="avatar" id="avatar" class="form-control">
        <small class="text-muted">Kosongkan jika tidak ingin merubah avatar</small>

        <hr class="my-3">
        <label for="email">Email</label>
        <input class="form-control" type="email" name="email" placeholder="Email" value="{{ $user->email }}" id="email" disabled/><br>

        <input class="btn btn-primary" type="submit" value="Save">
    </form>
</div>
@endsection
