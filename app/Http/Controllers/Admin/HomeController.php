<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Galary;
use App\Models\Message;
use App\Models\News;
use Auth;
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

        $adminsRecord = Admin::getRecordMonthly();

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

        $dates = array_keys($newsRecord);
        $dates = collect($dates)->map(function ($item) {
            return arabicDate(arabicNumbers(Carbon::createFromFormat('Y-m', $item)->format('M Y')));
        })->all();

        $chartjs = null;
        $chartjs_datasets = [];
        if (Auth::user()->can('عرض إحصائيات الأعضاء')) {
            array_push($chartjs_datasets, [
                "label" => "الأعضاء",
                'backgroundColor' => 'rgba(99, 111, 142, 0.9)',
                'data' => array_values($adminsRecord)
            ]);
        }

        if (Auth::user()->can('عرض إحصائيات الرسائل')) {
            array_push($chartjs_datasets, [
                "label" => "الرسائل",
                'backgroundColor' => 'rgba(247, 106, 45, 0.9)',
                'data' => array_values($messagesRecord)
            ]);
        }

        if (Auth::user()->can('عرض إحصائيات المعرض')) {
            array_push($chartjs_datasets, [
                "label" => "الوسائط",
                'backgroundColor' => 'rgba(2, 150, 102, 0.9)',
                'data' => array_values($galariesRecord)
            ]);
        }

        if (Auth::user()->can('عرض إحصائيات الأقسام')) {
            array_push($chartjs_datasets, [
                "label" => "الأقسام",
                'backgroundColor' => 'rgba(259, 58, 90, 0.9)',
                'data' => array_values($categoriesRecord)
            ]);
        }

        if (Auth::user()->can('عرض إحصائيات الأخبار')) {
            array_push($chartjs_datasets, [
                "label" => "الأخبار",
                'backgroundColor' => 'rgba(0, 91, 234, 0.9)',
                'data' => array_values($newsRecord)
            ]);
        }

        if (Auth::user()->canAny(['عرض إحصائيات الأخبار', 'عرض إحصائيات الأقسام', 'عرض إحصائيات المعرض', 'عرض إحصائيات الرسائل', 'عرض إحصائيات الأعضاء'])) {
            $chartjs = app()->chartjs
            ->name('barChart')
            ->type('bar')
            ->size(['width' => 500, 'height' => 130])
            ->labels($dates)
            ->datasets($chartjs_datasets)
            ->options([
                'legend' => [
                    'display' => false,
                ],
            ]);
        }

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

            'chartjs'
        ]));
    }
}
