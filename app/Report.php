<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

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
        'title',
        'description',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
/**
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
 */
}
