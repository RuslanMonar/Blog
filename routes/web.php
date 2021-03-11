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
//use Symfony\Component\Routing\Route;
//use Illuminate\Support\Facades\Route;
 
 Route::get('/', 'HomeController@index');
 Route::get('/post/{slug}' , 'HomeController@show')->name('post.show');
 Route::get('/tag/{slug}' , 'HomeController@TagOrCategory')->name('tag.show');
 Route::get('/category/{slug}' , 'HomeController@TagOrCategory')->name('category.show');
 Route::post('/subscribe', 'SubscribeController@subscribe');

 Route::group(['middleware' => 'guest'], function(){
 Route::get('/register', 'AuthController@registerForm');
 Route::post('/register', 'AuthController@register');
 Route::get('/login', 'AuthController@loginForm')->name('login');
 Route::post('/login', 'AuthController@login');
}); 
 Route::group(['middleware' => 'auth'], function(){
 Route::get('/profile', 'ProfileController@index');
 Route::post('/profile', 'ProfileController@store');
 Route::get('/logout', 'AuthController@logout');
 Route::post('/comment' , 'CommentsController@store');
 Route::get('/create_post' , 'Admin\PostsController@create');
 Route::get('/user_posts/user_posts' , 'Admin\PostsController@user_posts')->name('user_posts.user_posts');
 Route::resource('/user_posts' , 'Admin\PostsController');
 Route::post('/reply' , 'CommentsController@reply')->name('comment.reply');
}); 
 

 Route::group(['prefix'=>'admin','namespace'=>'Admin' , 'middleware' => 'admin'], function(){
    Route::get('/', 'DashboardController@index');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/users', 'UsersController');
    Route::resource('/posts', 'PostsController');
    Route::resource('/comments', 'CommentsController');
    Route::get('/comments/toggle/{id}', 'CommentsController@toggle');
}); 