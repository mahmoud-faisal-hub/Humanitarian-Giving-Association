<?php

namespace App\Models;

use App\Traits\ChartTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galary extends Model
{
    use HasFactory, Searchable, ChartTrait;

    protected $fillable = [
        'file',
        'extension',
        'description',
    ];

    protected $hidden = [];
}
