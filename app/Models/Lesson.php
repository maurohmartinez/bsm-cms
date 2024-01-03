<?php

namespace App\Models;

use App\Enums\LessonStatusEnum;
use App\Enums\PeriodEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Lesson
 *
 * @property int $id
 * @property int $year_id
 * @property int|null $teacher_id
 * @property int|null $subject_id
 * @property int|null $interpreter_id
 * @property array|null $extras
 * @property LessonStatusEnum $status
 * @property bool $notify_teacher
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property PeriodEnum $period
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Interpreter|null $interpreter
 * @property-read \App\Models\Subject|null $subject
 * @property-read \App\Models\Teacher|null $teacher
 * @property-read \App\Models\Year $year
 * @method static Builder|Lesson available()
 * @method static Builder|Lesson confirmed()
 * @method static Builder|Lesson firstSemester()
 * @method static Builder|Lesson newModelQuery()
 * @method static Builder|Lesson newQuery()
 * @method static Builder|Lesson onlyTrashed()
 * @method static Builder|Lesson query()
 * @method static Builder|Lesson secondSemester()
 * @method static Builder|Lesson toConfirm()
 * @method static Builder|Lesson whereCreatedAt($value)
 * @method static Builder|Lesson whereDeletedAt($value)
 * @method static Builder|Lesson whereEndsAt($value)
 * @method static Builder|Lesson whereExtras($value)
 * @method static Builder|Lesson whereId($value)
 * @method static Builder|Lesson whereInterpreterId($value)
 * @method static Builder|Lesson whereNotifyTeacher($value)
 * @method static Builder|Lesson wherePeriod($value)
 * @method static Builder|Lesson whereStartsAt($value)
 * @method static Builder|Lesson whereStatus($value)
 * @method static Builder|Lesson whereSubjectId($value)
 * @method static Builder|Lesson whereTeacherId($value)
 * @method static Builder|Lesson whereUpdatedAt($value)
 * @method static Builder|Lesson whereYearId($value)
 * @method static Builder|Lesson withForeignTeacher()
 * @method static Builder|Lesson withLocalTeacher()
 * @method static Builder|Lesson withTrashed()
 * @method static Builder|Lesson withoutChapels()
 * @method static Builder|Lesson withoutTrashed()
 * @method static Builder|Lesson year(int $yearId)
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public const MONDAY_SCHEDULE = [
        ['09:30', '10:20'],
        ['10:30', '11:20'],
        ['12:00', '12:50'],
        ['13:00', '13:50'],
        ['19:00', '21:00'],
    ];

    public const REGULAR_SCHEDULE = [
        ['08:30', '09:20'],
        ['09:30', '10:20'],
        ['10:30', '11:20'],
        ['12:00', '12:50'],
        ['13:00', '13:50'],
        ['19:00', '21:00'],
    ];

    public const FRIDAY_SCHEDULE = [
        ['08:30', '09:20'],
        ['09:30', '10:20'],
        ['11:00', '11:50'],
        ['12:00', '12:50'],
    ];

    public const SCHEDULE = [
        1 => self::MONDAY_SCHEDULE,
        2 => self::REGULAR_SCHEDULE,
        3 => self::REGULAR_SCHEDULE,
        4 => self::REGULAR_SCHEDULE,
        5 => self::FRIDAY_SCHEDULE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'starts_at',
        'ends_at',
        'period',
        'year_id',
        'teacher_id',
        'subject_id',
        'interpreter_id',
        'extras',
        'status',
        'notify_teacher',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'extras' => 'array',
        'notify_teacher' => 'boolean',
        'period' => PeriodEnum::class,
        'status' => LessonStatusEnum::class,
    ];

    protected $appends = ['is_chapel'];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function interpreter(): BelongsTo
    {
        return $this->belongsTo(Interpreter::class);
    }

    public function scopeWithoutChapels(Builder $query): void
    {
        $query->whereNotIn('status', LessonStatusEnum::chapelsStatuses());
    }

    public function scopeAvailable(Builder $query): void
    {
        $query->where('status', LessonStatusEnum::AVAILABLE->value);
    }

    public function scopeConfirmed(Builder $query): void
    {
        $query->where('status', LessonStatusEnum::CONFIRMED->value);
    }

    public function scopeToConfirm(Builder $query): void
    {
        $query->where('status', LessonStatusEnum::TO_CONFIRM->value);
    }

    public function scopeFirstSemester(Builder $query): void
    {
        $query->where('period', PeriodEnum::FIRST->value);
    }

    public function scopeSecondSemester(Builder $query): void
    {
        $query->where('period', PeriodEnum::SECOND->value);
    }

    public function scopeWithLocalTeacher(Builder $query): void
    {
        $query->whereHas('teacher', function (Builder $q) {
            $q->where('is_local', true);
        });
    }

    public function scopeWithForeignTeacher(Builder $query): void
    {
        $query->whereHas('teacher', function (Builder $q) {
            $q->where('is_local', false);
        });
    }

    public function scopeYear(Builder $query, int $yearId): void
    {
        $query->where('lessons.year_id', $yearId);
    }

    protected function isChapel(): Attribute
    {
        return Attribute::make(
            get: fn () => in_array($this->status->value, array_keys(LessonStatusEnum::chapelsStatuses())),
        );
    }
}
