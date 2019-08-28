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
        <input type="text" class="form-control" placeholder="Fullname" name="name" id="name"/><br>

        <label for="username">
            Username
        </label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username"><br>

        <label for="">
            Roles
        </label><br>
        <input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
        <label for="ADMIN">
            Administrator
        </label>

        <input type="checkbox" name="roles[]" id="STAFF" value="STAFF">
        <label for="STAFF">
            Staff
        </label>

        <input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER">
        <label for="CUSTOMER">
            Customer
        </label><br>

        <label for="phone">
            Phone Number
        </label>
        <input type="text" class="form-control" name="phone" id="phone"><br>

        <label for="address">
            Address
        </label>
        <textarea class="form-control" name="address" id="address" cols="30" rows="5"></textarea><br>

        <label for="avatar">
            Avatar Image
        </label>
        <input type="file" class="form-control" name="avatar" id="avatar"><br>

        <hr class="my-3">

        <label for="email">
            E-mail
        </label>
        <input type="email" class="form-control" name="email" id="email" placeholder="user@mail.com"><br>

        <label for="password">
            Password
        </label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password"><br>

        <label for="password_confirmation">
            Password Confirmation
        </label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation"><br>

        <input class="btn btn-primary" type="submit" value="Save"/>
    </form>
</div>

@endsection
