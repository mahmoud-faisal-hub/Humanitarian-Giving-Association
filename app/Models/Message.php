<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'created_by',
        'category_id',
    ];

    protected $hidden = [];

    ########## Begin Relations ##########

    public function readers()
    {
        return $this -> hasMany(MessageReader::class, 'message_id');
    }

    ########## End Relations ##########

    ########## Begin Custom ##########

    public static function getRecordDaily($days = 30)
    {
        $chartDatas = Message::select([
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
        $chartDatas = Message::select([
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
}
