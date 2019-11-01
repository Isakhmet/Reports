<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CategoriesReport extends Model
{

    public $table = 'categories_report';

    protected $dates = [
        'updated_at',
        'created_at',
        ];

    protected $fillable = [
        'code',
        'name',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getReports()
    {
        return $this->hasMany('App\Report', 'category_id', 'id');
    }

}
