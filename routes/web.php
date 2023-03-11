<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('posts/{post}', function ($slug) {

    // $path  = __DIR__ . "/../resources/posts/{$slug}.html";
    // // ddd('Hello');

    // if (!file_exists($path)) {
    //     return redirect('/');
    // }

    // $post = cache()->remember("posts.{$slug}", now()->addDays(1), function(){
    //     return file_get_contents($path);
    // });


    return view('post', [
        'post' => Post::find($slug)
    ]);
})->where('post', '[A-z_\-]+');
