<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::paginate(5);

        $filterKeyword = $request->get('name');

        if ($filterKeyword) {
            $categories = Category::where("name", "LIKE", "%$filterKeyword%")
            ->paginate(5);
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');

        $new_category = new Category;
        $new_category->name = $name;

        if ($request->file('image'))
        {
            $image_path = savePhotoOriginal($name, $request->file('image'), 'category_image');

            $new_category->image = $image_path;
        } else {
            $new_category->image = "";
        }

        $new_category->created_by = \Auth::user()->id;

        $new_category->slug = str_slug($name, '-');

        $new_category->save();

        return redirect()->route('categories.create')->with('status', 'Category succefully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
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
        $name = $request->get('name');
        $slug = $request->get('slug');

        $category = Category::findOrFail($id);

        $category->name = $name;
        $category->slug = $slug;

        if ($request->file('image'))
        {
            if ($category->image && file_exists(storage_path('app/public/' . $category->image)))
            {
                Storage::delete('public/' . $category->image);
            }

            $new_image = savePhotoOriginal($name, $request->file('image'), 'category_image');

            $category->image = $new_image;
        }

        $category->save();

        return redirect()->route('categories.edit', ['id' => $id])->with('status', 'Category succefully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->categories) {
            Storage::delete('public/' . $category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')
        ->with('status', 'Category successfully moved to trash');
    }

    // untuk Menampilkan data didalam trash
    public function trash()
    {
        $deleted_category = Category::onlyTrashed()
        ->paginate(5);

        return view('categories.trash', compact('deleted_category'));
    }

    // untuk merestore/menampilkan data ygn sudah di delete
    public function restore($id)
    {
        $category = Category::withTrashed()
        ->findOrFail($id);

        if ($category->trashed())
        {
            $category->restore();
        } else {
            return redirect()
            ->route('categories.index')
            ->with('status', 'Category is not in trash');
        }

        return redirect()
            ->route('categories.index')
            ->with('status', 'Category succefully restored');
    }

    // menghapus data permanent
    public function deletePermanent($id)
    {
        $category = Category::withTrashed()
        ->findOrFail($id);

        if ($category->trashed())
        {
            $category->forceDelete();

            return redirect()
            ->route('categories.index')
            ->with('status', 'Category permanently deleted');

        } else {
            return redirect()
            ->route('categories.index')
            ->with('status', 'Category is not in trash');
        }
    }
}
