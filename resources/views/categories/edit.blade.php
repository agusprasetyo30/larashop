@extends('layouts.global')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')


@section('content')
    <div class="col-md-8">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('categories.update', $category->id) }}"
            method="post"
            class="bg-white shadow-sm p-3"
            enctype="multipart/form-data">

            @csrf
            @method("put")

            <label>Category name</label> <br>
            <input
                type="text"
                class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                value="{{ old('name') ? old('name') : $category->name }}"
                name="name">
            <div class="invalid-feedback">
                {{$errors->first('name')}}
            </div>
            <br>

            <label>Category slug</label>
            <input
                type="text"
                class="form-control {{ $errors->first('slug') ? 'is-invalid' : '' }}"
                value="{{ old('slug') ? old('slug') : $category->slug }}"
                name="slug">
            <div class="invalid-feedback">
                {{$errors->first('sluh')}}
            </div>
            <br>

            <span>Current image</span><br>
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" width="120px">
            @else
                No Image
            @endif

            <br><br>
            <input
                type="file"
                class="form-control"
                name="image">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
            <br><br>

            <input type="submit" class="btn btn-primary" value="Update">

        </form>
    </div>
@endsection
