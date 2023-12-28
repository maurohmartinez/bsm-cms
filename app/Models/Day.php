<?php

namespace App\Models;

use App\Enums\PeriodEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Day extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day',
        'week_number',
        'period',
        'extras',
        'year_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'day' => 'date',
        'week_number' => 'integer',
        'extras' => 'array',
        'period' => PeriodEnum::class,
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
