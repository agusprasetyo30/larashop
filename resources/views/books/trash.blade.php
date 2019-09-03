@extends('layouts.global')

@section('title', 'Trashed Books')

@section('page_title', 'Trashed Books')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form action="{{route('books.trash')}}">
                    <div class="input-group">
                        <input name="keyword" type="text"
                            value="{{ Request::get('keyword') }}" class="form-control" placeholder="Filter by title">

                            <div class="input-group-append">
                            <input type="submit" value="Filter" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a href="{{ route('books.index') }}"
                            class="nav-link
                                {{ Request::path() == 'books'
                                    && Request::get('status') == null ? 'active' : '' }}">All</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('books.index', ['status' => 'publish']) }}"
                            class="nav-link {{ Request::get('status') == 'publish' ? 'active' : '' }}">Publish</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('books.index', ['status' => 'draft']) }}"
                            class="nav-link {{ Request::get('status') == 'draft' ? 'active' : '' }}">Draft</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('books.trash') }}"
                            class="nav-link {{ Request::path() == 'books/trash' ? 'active' : '' }}">Trash</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="my-3">

        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th><b>Cover</b></th>
                    <th><b>Title</b></th>
                    <th><b>Author</b></th>
                    <th><b>Categories</b></th>
                    <th><b>Stock</b></th>
                    <th><b>Price</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>
                            @if($book->cover)
                                <img src="{{asset('storage/' . $book->cover)}}"
                                    width="96px"/>
                            @endif
                        </td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>
                            <ul class="pl-3">
                                @foreach($book->categories as $category)
                                    <li>{{ $category->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $book->stock }}</td>
                        <td>{{ $book->price }}</td>
                        <td>
                            <form action="{{ route('books.restore', $book->id) }}"
                                class="d-inline"
                                method="post">

                            @csrf

                            <input type="submit"
                                class="btn btn-success btn-sm"
                                value="Restore">
                            </form>

                            <form action="{{ route('books.delete-permanent', $book->id) }}"
                                class="d-inline"
                                method="post"
                                onsubmit="return confirm('Delete this book permanently?')">

                                @csrf
                                @method('delete')

                                <input type="submit"
                                    class="btn btn-danger btn-sm"
                                    value="Delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{$books->appends(Request::all())->links()}}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection
