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

Auth::routes();

Route::match(['get', 'post'], '/register', function () {
    return redirect("/login");
})->name("register");

Route::get('/home', 'HomeController@index')->name('home');

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

Route::resource('categories', 'CategoryController');


