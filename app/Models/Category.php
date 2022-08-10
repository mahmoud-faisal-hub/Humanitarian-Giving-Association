<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;


    protected $table = "categories";

    protected $fillable = [
        'name',
    ];

    protected $hidden = [];

    ########## Begin Relations ##########

    public function news()
    {
        return $this -> hasMany(News::class, 'category_id');
    }

    ########## End Relations ##########

    ########## Begin Custom ##########

    public static function getRecordDaily($days = 30)
    {
        $chartDatas = Category::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
        ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $chartDataByDay = array();
        foreach($chartDatas as $data) {
            $chartDataByDay[$data->date] = $data->count;
        }

        $date = new Carbon;
        for($i = 0; $i < $days; $i++) {
            $dateString = $date->format('Y-m-d');
            if(!isset($chartDataByDay[ $dateString ])) {
                $chartDataByDay[ $dateString ] = 0;
            }
            $date->subDay();
        }

        ksort($chartDataByDay);

        return $chartDataByDay;
    }

    public static function getRecordMonthly($months = 12)
    {
        $chartDatas = Category::select([
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
        ->whereBetween('created_at', [Carbon::now()->subMonths($months), Carbon::now()])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        // return $chartDatas;

        $chartDataByMonth = array();
        foreach($chartDatas as $data) {
            $chartDataByMonth[$data->date] = $data->count;
        }

        $date = new Carbon;
        for($i = 0; $i < $months; $i++) {
            $dateString = $date->format('Y-m');
            if(!isset($chartDataByMonth[ $dateString ])) {
                $chartDataByMonth[ $dateString ] = 0;
            }
            $date->subMonth();
        }

        ksort($chartDataByMonth);

        return $chartDataByMonth;
    }

    ########## End Custom ##########

    public static function boot() {
        parent::boot();

        static::deleting(function($category) {
            $newsImages = $category->news()->select('image')->pluck('image');
            if ($newsImages) {
                foreach ($newsImages as $image) {
                    if (Storage::disk('public')->exists('images/news/' . $image)) {
                        Storage::disk('public')->delete('images/news/' . $image);
                    }
                }
            }
        });
    }
}
