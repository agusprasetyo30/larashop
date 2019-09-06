@extends('layouts.global')

@section('title', 'Create User')
@section('page_title', 'Create New User')

@section('content')
<div class="col-md-8">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
        @csrf

        <label for="name">
            Name
        </label>
        <input type="text"
            class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
            placeholder="Fullname"
            name="name" id="name"
            value="{{ old('name') }}"/>

        <div class="invalid-feedback">
            {{ $errors->first('name') }}
        </div>
        <br>

        <label for="username">
            Username
        </label>
        <input type="text"
            class="form-control {{ $errors->first('username') ? 'is-invalid' : '' }}"
            name="username" id="username"
            placeholder="Username"
            value="{{ old('username') }}">

        <div class="invalid-feedback">
            {{ $errors->first('username') }}
        </div>
        <br>

        <label for="">
            Roles
        </label><br>
        <input type="checkbox"
            class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}"
            name="roles[]"
            id="ADMIN"
            value="ADMINISTRATOR">

        <label for="ADMIN">
            Administrator
        </label>

        <input type="checkbox"
            class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}"
            name="roles[]"
            id="STAFF"
            value="STAFF">

        <label for="STAFF">
            Staff
        </label>

        <input type="checkbox"
            class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}"
            name="roles[]"
            id="CUSTOMER"
            value="CUSTOMER">

        <label for="CUSTOMER">
            Customer
        </label>
        <div class="invalid-feedback">
            {{ $errors->first('roles') }}
        </div>
        <br>

        <label for="phone">
            Phone Number
        </label>
        <input type="text"
            class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}"
            name="phone"
            id="phone"
            value="{{ old('phone') }}">

        <div class="invalid-feedback">
            {{ $errors->first('phone') }}
        </div>
        <br>

        <label for="address">
            Address
        </label>
        <textarea
            class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}"
            name="address"
            id="address"
            cols="30" rows="5"></textarea>

        <div class="invalid-feedback">
            {{ $errors->first('address') }}
        </div>
        <br>

        <label for="avatar">
            Avatar Image
        </label>
        <input type="file"
            class="form-control {{ $errors->first('avatar') ? 'is-invalid' : '' }}"
            name="avatar"
            id="avatar">

        <div class="invalid-feedback">
            {{ $errors->first('avatar') }}
        </div>
        <br>

        <hr class="my-3">

        <label for="email">
            E-mail
        </label>
        <input type="email"
            class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"
            name="email"
            id="email"
            placeholder="user@mail.com"
            value="{{ old('email') }}">

        <div class="invalid-feedback">
            {{ $errors->first('email') }}
        </div>
        <br>

        <label for="password">
            Password
        </label>
        <input type="password"
            class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}"
            name="password"
            id="password"
            placeholder="Password">

        <div class="invalid-feedback">
            {{ $errors->first('password') }}
        </div>
        <br>

        <label for="password_confirmation">
            Password Confirmation
        </label>
        <input type="password"
            class="form-control {{ $errors->first('password_confirmation') ? 'is-invalid' : '' }}"
            name="password_confirmation"
            id="password_confirmation"
            placeholder="Password Confirmation">

        <div class="invalid-feedback">
            {{ $errors->first('password_confirmation') }}
        </div>
        <br>

        <input class="btn btn-primary" type="submit" value="Save"/>
    </form>
</div>

@endsection
