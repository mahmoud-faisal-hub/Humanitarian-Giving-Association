<?php

namespace App\Providers;

use App\Models\AdminInfo;
use App\Models\Category;
use App\Models\Message;
use App\Models\MessageReader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('web.layouts.app', function ($view) {
            $max_cats = 30;
            $max_nav = 6;
            $view->with([
                'categories' => Category::select(['id', 'name'])->orderBy('created_at', 'asc')->take($max_cats)->get(),
                'max_cats' => $max_cats,
                'max_nav' => $max_nav,
            ]);
        });

        view()->composer('admin.layouts.master', function ($view) {
            $view->with([
                'unread_messages' => Message::select(['id', 'name', 'message', 'created_at'])
                                            ->whereDoesntHave('readers', function ($query) {
                                                $query->where('admin_id', Auth::id());
                                            })->orderBy('created_at', 'desc')
                                            ->get(),
            ]);
        });

        Paginator::useBootstrapFive();
    }
}
