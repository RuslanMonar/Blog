<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Post;
use App\Category;
use App\Comment;
#use Auth;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Date::setlocale(config('app.locale'));
        view()->composer('pages._sidebar', function($view){
            $view->with('popularPosts',  Post::orderBy('views' , 'desc')->take(3)->get());
            $view->with('featuredPosts', Post::where('is_featured', 1)->take(3)->get());
            $view->with('recentPosts', Post::orderBy('date', 'desc')->take(4)->get());
            $view->with('categories', Category::all());
        });
        view()->composer('admin._sidebar', function($view){
            $view->with('newCommentsCount', Comment::where('status' , 0)->count());
        });
         view()->composer('admin.posts.*' , function($view){
            $view->with('current_user', Auth::user());
        }); 
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
