@extends('layouts.global')

@section('title', 'Create Category')
@section('page_title', 'Create Category')


@section('content')
<div class="col-md-8">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form
        class="bg-white shadow-sm p-3"
        action="{{ route('categories.store') }}"
        method="post"
        enctype="multipart/form-data">

        @csrf

        <label for="name">Category Name</label><br>
        <input type="text"
            class="form-control"
            name="name"
            id="name">
        <br>

        <label for="image">Category Image</label><br>
        <input type="file"
            class="form-control"
            name="image"
            id="image">
        <br>

        <input type="submit"
            class="btn btn-primary"
            value="Save">
    </form>
</div>

@endsection
