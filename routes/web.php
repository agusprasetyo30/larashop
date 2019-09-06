<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// menentukan halaman ketika awal masuk
Route::get('/', function () {
    return view('auth.login');
});

Route::match(['get', 'post'], '/register', function () {
    return redirect("/login");
})->name("register");

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => ['role:ADMINISTRATOR|STAFF']], function () {

        Route::resource('users', 'UserController');

        // Delete
        Route::get('categories/trash', 'CategoryController@trash')
            ->name('categories.trash');

        // Restore
        Route::get('users/{id}/restore', 'CategoryController@restore')
            ->name('categories.restore');

        // Delete Permanent
        Route::delete('users/{id}/delete-permanent', 'CategoryController@deletePermanent')
            ->name('categories.delete-permanent');

        // Untuk menampilkan kategori ketika menggunakna select2
        Route::get('ajax/categories/search', 'CategoryController@ajaxSearch');

        Route::resource('categories', 'CategoryController');

        // Menghapus & Restore buku
        Route::get('books/trash', 'BookController@trash')->name('books.trash');
        Route::post('books/{id}/restore', 'BookController@restore')->name('books.restore');
        Route::delete('books/{id}/delete-permanent', 'BookController@deletePermanent')->name('books.delete-permanent');

        // CRUD Buku
        Route::resource('books', 'BookController');

        // Untuk orders
        Route::resource('orders', 'OrderController');


    });
});
