<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Barryvdh\LaravelIdeHelper\Eloquent;

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
 * @property-read Collection<int, Lesson> $lessons
 * @property-read int|null $lessons_count
 * @property-read Collection<Student> $students
 * @property-read int $cost
 * @method static Builder|Year newModelQuery()
 * @method static Builder|Year newQuery()
 * @method static Builder|Year onlyTrashed()
 * @method static Builder|Year query()
 * @method static Builder|Year whereCreatedAt($value)
 * @method static Builder|Year whereDeletedAt($value)
 * @method static Builder|Year whereFirstPeriodEndsAt($value)
 * @method static Builder|Year whereFirstPeriodStartsAt($value)
 * @method static Builder|Year whereId($value)
 * @method static Builder|Year whereName($value)
 * @method static Builder|Year whereSecondPeriodEndsAt($value)
 * @method static Builder|Year whereSecondPeriodStartsAt($value)
 * @method static Builder|Year whereUpdatedAt($value)
 * @method static Builder|Year withTrashed()
 * @method static Builder|Year withoutTrashed()
 * @mixin Eloquent
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
        'cost',
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

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public static function addOne(
        string $name,
        int    $cost,
        Carbon $firstPeriodStarts,
        Carbon $firstPeriodEnds,
        Carbon $secondPeriodStarts,
        Carbon $secondPeriodEnds,
    ): void
    {
        self::query()
            ->create([
                'name' => $name,
                'cost' => $cost,
                'first_period_starts_at' => $firstPeriodStarts,
                'first_period_ends_at' => $firstPeriodEnds,
                'second_period_starts_at' => $secondPeriodStarts,
                'second_period_ends_at' => $secondPeriodEnds,
            ]);
    }

    public static function getCurrent(): Year
    {
        return self::query()
            ->whereDate('first_period_starts_at', '<', now())
            ->whereDate('second_period_ends_at', '>', now())
            ->first()
            ?? self::query()
            ->whereDate('first_period_starts_at', '>', now())
            ->first()
            ?? self::query()
                ->whereDate('first_period_starts_at', '<', now())
                ->first();
    }

    protected function tuitionLeft(): Attribute
    {
        return Attribute::make(
            get: function () {
                $total = $this->cost * $this->students->count() * 100;

                foreach ($this->students as $student) {
                    $total -= $student->transactions()->sum('amount');
                }

                return Transaction::toCurrency($total);
            },
        );
    }
}
