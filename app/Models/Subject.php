<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $appends = ['full_name'];

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

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name.' '.$this->year,
        );
    }
}
