<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    public $table = 'reports';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        ];

    protected $fillable = [
        'code',
        'name',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getCategory()
    {
        return $this->belongsToMany('App\CategoriesReport', 'categories_report');
    }

    public function category()
    {
        return $this->belongsToMany('App\CategoriesReport', 'reports', 'id', 'category_id');
    }
}
