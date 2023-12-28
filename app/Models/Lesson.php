<?php

namespace App\Models;

use App\Enums\LessonStatusEnum;
use App\Enums\PeriodEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public const MONDAY_SCHEDULE = [
        ['09:30', '10:20'],
        ['10:30', '11:20'],
        ['12:00', '12:50'],
        ['13:00', '13:50'],
    ];

    public const REGULAR_SCHEDULE = [
        ['08:30', '09:20'],
        ['09:30', '10:20'],
        ['10:30', '11:20'],
        ['12:00', '12:50'],
        ['13:00', '13:50'],
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
        'starts',
        'ends',
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
        'starts' => 'datetime',
        'ends' => 'datetime',
        'extras' => 'array',
        'notify_teacher' => 'boolean',
        'period' => PeriodEnum::class,
        'status' => LessonStatusEnum::class,
    ];

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
}
