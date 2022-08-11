<?php

namespace App\Models;

use App\Traits\ChartTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory, ChartTrait;

    protected $table = "news";

    protected $fillable = [
        'image',
        'title',
        'content',
        'article',
        'created_by',
        'category_id',
    ];

    protected $hidden = [];

    ########## Begin Relations ##########

    public function category()
    {
        return $this -> belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this -> belongsTo(Admin::class, 'created_by');
    }

    ########## End Relations ##########
}
