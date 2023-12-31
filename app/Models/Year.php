<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Year
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $first_period_starts_at
 * @property \Illuminate\Support\Carbon $first_period_ends_at
 * @property \Illuminate\Support\Carbon $second_period_starts_at
 * @property \Illuminate\Support\Carbon $second_period_ends_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lesson> $lessons
 * @property-read int|null $lessons_count
 * @method static \Illuminate\Database\Eloquent\Builder|Year newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Year query()
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereFirstPeriodEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereFirstPeriodStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereSecondPeriodEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereSecondPeriodStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Year withoutTrashed()
 * @mixin \Eloquent
 */
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
        string $name,
        Carbon $firstPeriodStarts,
        Carbon $firstPeriodEnds,
        Carbon $secondPeriodStarts,
        Carbon $secondPeriodEnds,
    ): void
    {
        self::query()
            ->create([
                'name' => $name,
                'first_period_starts_at' => $firstPeriodStarts,
                'first_period_ends_at' => $firstPeriodEnds,
                'second_period_starts_at' => $secondPeriodStarts,
                'second_period_ends_at' => $secondPeriodEnds,
            ]);
    }
}
