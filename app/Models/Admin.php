<?php

namespace App\Models;

use App\Traits\ChartTrait;
use App\Traits\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Storage;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Searchable, ChartTrait;

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

    public static function boot() {
        parent::boot();

        static::deleting(function($user) {
            $newsImages = $user->news()->select('image')->pluck('image');
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
