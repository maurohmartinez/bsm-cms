<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public static function addOne(
        Carbon $firstPeriodStarts,
        Carbon $firstPeriodEnds,
        Carbon $secondPeriodStarts,
        Carbon $secondPeriodEnds,
    ): void
    {
        self::query()
            ->create([
                'name' => '2024/2025',
                'first_period_starts' => $firstPeriodStarts,
                'first_period_ends' => $firstPeriodEnds,
                'second_period_starts' => $secondPeriodStarts,
                'second_period_ends' => $secondPeriodEnds,
            ]);
    }
}
