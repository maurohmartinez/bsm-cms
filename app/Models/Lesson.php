<?php

namespace App\Models;

use App\Enums\LessonStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day_id',
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
        'extras' => 'array',
        'status' => LessonStatusEnum::class,
        'notify_teacher' => 'boolean',
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
