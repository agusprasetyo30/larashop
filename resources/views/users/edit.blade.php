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

    <form class="bg-white shadow-sm p-3" action="{{ route('users.update', $user->id) }}"
            method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        <input type="hidden" name="">

        <label for="name">Name</label>
        <input class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
            type="text"
            name="name"
            placeholder="Full Name"
            value="{{ old('name') ? old('name') : $user->name }}"
            id="name"/>

        <div class="invalid-feedback">
            {{$errors->first('name')}}
        </div>
        <br>

        <label for="status">Status</label><br>

        <input {{ $user->status == 'ACTIVE' ? 'checked' : '' }}
            type="radio"
            class="form-control"
            value="ACTIVE"
            id="active" name="status">
        <label for="active">Active</label>

        <input {{ $user->status == 'INACTIVE' ? 'checked' : '' }}
            type="radio"
            class="form-control"
            value="INACTIVE"
            id="inactive" name="status">
        <label for="inactive">Inactive</label><br/>

        <label for="username">Username</label>
        <input class="form-control"
            type="text"
            name="username"
            placeholder="Username"
            value="{{ $user->username }}"
            id="username" disabled/><br>

        <label for="">
            Roles
        </label><br>

        <input type="checkbox"
            {{ in_array("ADMIN", json_decode($user->roles)) ? "checked" : "" }}
            name="roles[]" id="ADMIN"
            value="ADMIN"
            class="form-control {{$errors->first('roles') ? 'is-invalid' : '' }}"/>

        <label for="ADMIN">
            Administrator
        </label>

        <input type="checkbox"
            {{ in_array("STAFF", json_decode($user->roles)) ? "checked" : "" }}
            name="roles[]"
            value="STAFF" id="STAFF"
            class="form-control {{$errors->first('roles') ? 'is-invalid' : '' }}"/>

        <label for="STAFF">
            Staff
        </label>

        <input type="checkbox"
            {{ in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : "" }}
            name="roles[]" id="CUSTOMER"
            value="CUSTOMER"
            class="form-control {{$errors->first('roles') ? 'is-invalid' : '' }}"/>

        <label for="CUSTOMER">
            Customer
        </label>

        <div class="invalid-feedback">
            {{$errors->first('roles')}}
        </div><br/>

        <label for="phone">
            Phone Number
        </label>

        <input type="text"
            class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}"
            name="phone" id="phone"
            value="{{ old('phone') ? old('phone') : $user->phone }}">

        <div class="invalid-feedback">
            {{$errors->first('phone')}}
        </div>

        <br>

        <label for="address">
            Address
        </label>

        <textarea class="form-control {{ $errors->first('address') ? 'is-invalid' : ''}}"
            name="address" id="address"
            cols="30" rows="5">{{ old('address') ? old('address') : $user->address }}</textarea>

        <div class="invalid-feedback">
            {{$errors->first('address')}}
        </div>

        <br/>

        <label for="avatar">
            Avatar image
        </label>

        <br/>

        Current avatar : <br/>
            @if ($user->avatar)
                <img src="{{ asset('storage/'. $user->avatar) }}" width="120px"><br/>
            @else
                No Avatar
            @endif
        <br/>
        <input type="file"
            name="avatar"
            id="avatar"
            class="form-control">

        <small class="text-muted">Kosongkan jika tidak ingin merubah avatar</small>

        <hr class="my-3">
        <label for="email">
            Email
        </label>

        <input type="email"
            class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}"
            name="email" id="email"
            placeholder="Email"
            value="{{ $user->email }}" disabled/><br>

        <input class="btn btn-primary" type="submit" value="Save">
    </form>
</div>
@endsection
