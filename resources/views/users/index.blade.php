@extends('layouts.global')

@section('title', 'User List')
@section('page_title', 'User List')

@section('content')
<div class="col-md-12">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('users.index') }}">
                <div class="input-group mb-3">
                    <input type="text"
                    name="keyword"
                    value="{{ Request::get('keyword') }}"
                    class="form-control col-md-10"
                    placeholder="Filter berdasarkan email">

                    <div class="input-group-append">
                        <input type="submit"
                        value="Filter"
                        class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md 12 text-right">
            <a
            href="{{ route('users.create') }}"
            class="btn btn-primary">Create User</a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Username</b></th>
                <th><b>Email</b></th>
                <th><b>Avatar</b></th>
                <th><b>Action</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="align-middle">
                        {{ $user->name }}
                    </td>
                    <td class="align-middle">
                        {{ $user->username }}
                    </td>
                    <td class="align-middle">
                        {{ $user->email }}
                    </td>
                    <td>
                        @if ( $user->avatar )
                            <img src="{{ asset('storage/'. $user->avatar) }}" width="70px" alt="{{ $user->name }}">
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="align-middle">
                        <a class="btn btn-info text-white btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>

                        <form
                        onsubmit="return confirm('Delete this user permanenly ?')"
                        class="d-inline"
                        action="{{ route('users.destroy', $user->id) }}"
                        method="post">
                            @csrf
                            @method('delete')

                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                        </form>

                        <a href="{{ route('users.show', $user->id) }}"
                            class="btn btn-primary btn-sm">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
