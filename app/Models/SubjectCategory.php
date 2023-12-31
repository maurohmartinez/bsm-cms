<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubjectCategory
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectCategory withoutTrashed()
 * @mixin \Eloquent
 */
class SubjectCategory extends Model
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
        'code',
    ];

    protected $appends = ['full_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name.' ('.$this->code.')',
        );
    }
}
