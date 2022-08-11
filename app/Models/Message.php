<?php

namespace App\Models;

use App\Traits\ChartTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, ChartTrait;

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
}
