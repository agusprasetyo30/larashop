<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Category;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';

        if ($status) {
            $books = Book::with('categories')
                ->where('status', strtoupper($status))
                ->where("title", "LIKE", "%$keyword%")
                ->paginate(5);

        } else {
            $books = Book::with('categories')
                ->where("title", "LIKE", "%$keyword%")
                ->paginate(5);
        }

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_slug = str_slug($request->get('title'));

        $new_book = new Book;
        $new_book->title = $request->get('title');
        $new_book->description = $request->get('description');
        $new_book->author = $request->get('author');
        $new_book->publisher = $request->get('publisher');
        $new_book->price = $request->get('price');
        $new_book->stock = $request->get('stock');

        $new_book->status = $request->get('save_action');

        $cover = $request->file('cover');

        if ($cover)
        {
            $cover_path = savePhotoOriginal($data_slug, $cover, 'book-covers');

            $new_book->cover = $cover_path;

        } else {

            $new_book->cover = "";
        }

        $new_book->slug = $data_slug;

        $new_book->created_by = \Auth::user()->id;

        $new_book->save();

        $new_book->categories()->attach($request->get('categories'));

        if ($request->get('save_action') == 'PUBLISH')
        {
            return redirect()
                ->route('books.create')
                ->with('status', 'Book successfully saved and published');

        } else {
            return redirect()
                ->route('books.create')
                ->with('status', 'Book saved as draft');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $book->title = $request->get('title');
        $book->slug  = $request->get('slug');
        $book->description  = $request->get('description');
        $book->author  = $request->get('author');
        $book->publisher  = $request->get('publisher');
        $book->stock  = $request->get('stock');
        $book->price  = $request->get('price');

        $new_cover = $request->file('cover');

        if ($new_cover)
        {
            if ($book->cover && file_exists(storage_path('app/public/' . $book->cover)))
            {
                Storage::delete('public/' . $book->cover);
            }

            $new_cover_path = savePhotoOriginal($request->get('title'), $new_cover, 'book-covers');
            $book->cover = $new_cover_path;
        }

        $book->updated_by = \Auth::user()->id;

        $book->status = $request->get('status');

        $book->save();

        // Melakukan singkronisasi pada tabel relasi
        $book->categories()->sync($request->get('categories'));

        return redirect()
        ->route('books.edit', ['id' => $book->id])
        ->with('status', 'Book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()
        ->route('books.index')
        ->with('status', 'Book moved to trash');
    }

    // Menampilkan data dalam trash
    public function trash(Request $request)
    {
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';

        $books = Book::onlyTrashed()
            ->where("title", "LIKE", "%$keyword%")
            ->paginate(5);

        return view('books.trash', compact('books'));

    }

    // Merestore data
    public function restore($id)
    {
        $book = Book::withTrashed()
                ->findOrFail($id);

        if ($book->trashed())
        {
            $book->restore();
            return redirect()
            ->route('books.trash')
            ->with('status', 'Book successfully restored');

        } else {
            return redirect()
            ->route('books.trash')
            ->with('status', 'Book is not in trash');
        }
    }

    // Menghapus permanent
    public function deletePermanent($id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        if (!$book->trashed())
        {
            return redirect()
                ->route('books.trash')
                ->with('status', 'Book is not in trash')
                ->with('status_type', 'alert');

        } else {

            // Menghapus relasi pada tabel relasi
            $book->categories()->detach();
            $book->forceDelete();
            return redirect()
                ->route('books.trash')
                ->with('status', 'Book permanently deleted!');
        }
    }
}
