<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected $with = ['info'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    ########## Begin Relations ##########

    public function info()
    {
        return $this -> hasOne(AdminInfo::class, 'admin_id');
    }

    public function news()
    {
        return $this -> hasMany(News::class, 'created_by');
    }

    public function read()
    {
        return $this -> hasMany(MessageReader::class, 'admin_id');
    }

    ########## End Relations ##########

    ########## Begin Custom ##########

    public static function getRecordDaily($days = 30)
    {
        $chartDatas = Admin::select([
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
        $chartDatas = Admin::select([
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
