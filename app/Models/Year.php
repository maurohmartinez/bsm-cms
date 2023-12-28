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
        'first_period_starts_at',
        'first_period_ends_at',
        'second_period_starts_at',
        'second_period_ends_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_period_starts_at' => 'datetime',
        'first_period_ends_at' => 'datetime',
        'second_period_starts_at' => 'datetime',
        'second_period_ends_at' => 'datetime',
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
                'first_period_starts_at' => $firstPeriodStarts,
                'first_period_ends_at' => $firstPeriodEnds,
                'second_period_starts_at' => $secondPeriodStarts,
                'second_period_ends_at' => $secondPeriodEnds,
            ]);
    }
}
