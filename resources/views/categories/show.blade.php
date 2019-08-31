@extends('layouts.global')

@section('title', 'Detail Category')
@section('page_title', 'Detail Category')


@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label for="name"><b>Category Name</b></label><br>
                {{ $category->name }}
                <br><br>

                <label for="slug"><b>Category Slug</b></label><br>
                {{ $category->slug }}
                <br><br>

                <label for="image"><b>Category Image</b></label><br>
                @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" width="120px">
                @endif
            </div>
        </div>
    </div>
@endsection
