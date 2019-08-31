@extends('layouts.global')

@section('title', 'Trashed Category List')
@section('page_title', 'Trashed Category List')


@section('content')
<div class="row">
    <div class="col-md-6">
        <form action="{{ route('categories.index') }}">
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    name="name"
                    placeholder="Filter by category name">

                <div class="input-group-append">
                    <input type="submit"
                        value="filter"
                        class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a class="nav-link" href="
                    {{route('categories.index')}}">Published</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="
                    {{route('categories.trash')}}">Trash</a>
            </li>
        </ul>
    </div>
</div>
<hr class="my-3">
<div class="row">
    <div class="col-md-12">
        @if (session('status'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><b>Name</b></th>
                    <th><b>Slug</b></th>
                    <th><b>Image</b></th>
                    <th><b>Actions</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deleted_category as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                    width="48px">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('categories.restore', $category->id) }}"
                                    class="btn btn-success btn-sm">Restore</a>

                            <form
                                class="d-inline"
                                action="{{route('categories.delete-permanent', $category->id)}}"
                                onsubmit="return confirm('Delete this category permanently?')"
                                method="POST">

                                @csrf
                                @method('delete')

                                <input
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    value="Delete"/>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{ $deleted_category->appends(Request::all())->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
