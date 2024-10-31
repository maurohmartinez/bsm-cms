<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class Student extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Notifications\Notifiable;
    use \Laravel\Sanctum\HasApiTokens;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    public const GUARD = 'students';

    protected $fillable = [
        'name',
        'year_id',
        'email',
        'languages',
        'country',
        'city',
        'birth',
        'personal_code',
        'passport',
        'images',
        'password',
    ];

    protected $casts = ['birth' => 'date', 'languages' => 'array', 'password' => 'hashed'];

    protected $hidden = ['password', 'remember_token'];

    public static function boot(): void
    {
        parent::boot();

        self::deleting(function (self $student) {
            $student->transactions()->delete();
            $student->attendance()->delete();
            Cache::flush();
        });
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'student_id', 'id');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function subjects(): HasManyThrough
    {
        return $this->hasManyThrough(
            Subject::class,
            Year::class,
            'id',
            'year_id',
            'year_id',
            'id',
        );
    }

    protected function countryCity(): Attribute
    {
        return Attribute::make(get: fn () => $this->country . ' ' . $this->city);
    }

    protected function tuition(): Attribute
    {
        return Attribute::make(get: fn () => '€ ' . $this->year->cost - ($this->transactions()->sum('amount') / 100));
    }
}
