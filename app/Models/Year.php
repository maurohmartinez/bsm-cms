<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_period_starts',
        'first_period_ends',
        'second_period_starts',
        'second_period_ends',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_period_starts' => 'datetime',
        'first_period_ends' => 'datetime',
        'second_period_starts' => 'datetime',
        'second_period_ends' => 'datetime',
    ];
}
