<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string $name
 * @property int $hours
 * @property bool $is_official
 * @property string|null $notes
 * @property array|null $files
 * @property string $color
 * @property int $teacher_id
 * @property int $category_id
 * @property int $year_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\SubjectCategory $category
 * @property-read \App\Models\Lesson|null $lessons
 * @property-read \App\Models\Teacher $teacher
 * @property-read \App\Models\Year $year
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereIsOfficial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject withoutTrashed()
 * @mixin \Eloquent
 */
class Subject extends Model
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
        'hours',
        'is_official',
        'notes',
        'files',
        'teacher_id',
        'category_id',
        'color',
        'year_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_official' => 'boolean',
        'teacher_id' => 'integer',
        'files' => 'array',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SubjectCategory::class, 'category_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name.' '.$this->year->name,
        );
    }
}
