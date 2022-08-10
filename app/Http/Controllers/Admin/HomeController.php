<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Galary;
use App\Models\Message;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $newsRecord = News::getRecordMonthly();
        $newsCount = News::count();

        $categoriesRecord = Category::getRecordMonthly();
        $categoriesCount = Category::count();

        $galariesRecord = Galary::getRecordMonthly();
        $galariesCount = Galary::count();

        $messagesRecord = Message::getRecordMonthly();
        $messagesCount = Message::count();

        $latestNews = News::select(['id', 'image', 'title', 'content', 'category_id', 'created_by', 'created_at', 'updated_at'])
                    ->orderBy('created_at', 'desc')
                    ->with([
                        'user:id,name',
                        'category:id,name',
                    ])->take(5)
                    ->get();

        $latestCategories = Category::orderBy('created_at', 'desc')->take(5)->get();

        $latestGalaries = Galary::orderBy('created_at', 'desc')->take(5)->get();

        $latestMessages = Message::withCount(['readers' => function ($query) {
            $query->where('admin_id', Auth()->id());
        }])->orderBy('created_at', 'desc')->take(5)->get();

        // return $latestMessages;

        return view('admin.home', compact([
            'newsRecord',
            'newsCount',

            'categoriesRecord',
            'categoriesCount',

            'galariesRecord',
            'galariesCount',

            'messagesRecord',
            'messagesCount',

            'latestNews',
            'latestCategories',
            'latestGalaries',
            'latestMessages',
        ]));
    }
}
