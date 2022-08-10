<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'about',
        'admin_id',
    ];

    protected $hidden = [];

    ########## Begin Relations ##########

    public function admin()
    {
        return $this -> belongsTo(Admin::class, 'admin_id');
    }

    ########## End Relations ##########
}
