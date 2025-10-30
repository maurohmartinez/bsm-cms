<?php

namespace App\Models;

use App\Observers\SubjectObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string $name
 * @property int $hours
 * @property bool $is_official
 * @property bool $is_pass_fail
 * @property string|null $notes
 * @property array|null $files
 * @property string $color
 * @property int $teacher_id
 * @property int $category_id
 * @property int $year_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read SubjectCategory $category
 * @property-read Lesson|null $lessons
 * @property-read Teacher $teacher
 * @property-read Year $year
 * @property-read mixed $full_name
 * @property-read int|null $lessons_count
 * @method static Builder|Subject newModelQuery()
 * @method static Builder|Subject newQuery()
 * @method static Builder|Subject onlyTrashed()
 * @method static Builder|Subject query()
 * @method static Builder|Subject whereCategoryId($value)
 * @method static Builder|Subject whereColor($value)
 * @method static Builder|Subject whereCreatedAt($value)
 * @method static Builder|Subject whereDeletedAt($value)
 * @method static Builder|Subject whereFiles($value)
 * @method static Builder|Subject whereHours($value)
 * @method static Builder|Subject whereId($value)
 * @method static Builder|Subject whereIsOfficial($value)
 * @method static Builder|Subject whereName($value)
 * @method static Builder|Subject whereNotes($value)
 * @method static Builder|Subject whereTeacherId($value)
 * @method static Builder|Subject whereUpdatedAt($value)
 * @method static Builder|Subject whereYearId($value)
 * @method static Builder|Subject withTrashed()
 * @method static Builder|Subject withoutTrashed()
 * @mixin Eloquent
 */

#[ObservedBy([SubjectObserver::class])]
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
        'notes',
        'files',
        'teacher_id',
        'category_id',
        'color',
        'year_id',
        'extras',
    ];

    protected $casts = [
        'id' => 'integer',
        'teacher_id' => 'integer',
        'files' => 'array',
        'extras' => 'array',
    ];

    protected array $fakeColumns = ['extras'];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function studentGrades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            Year::class,
            'id',
            'year_id',
            'year_id',
            'id',
        );
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

    public function attendance(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name.' '.$this->year->name . ' (' . $this->lessons()->count() . ')',
        );
    }

    protected function isOfficial(): Attribute
    {
        return Attribute::make(
            get: fn () => (bool) $this->extras['is_official'] ?? false,
        );
    }

    protected function isPassFail(): Attribute
    {
        return Attribute::make(
            get: fn () => (bool) $this->extras['is_pass_fail'] ?? false,
        );
    }
}
