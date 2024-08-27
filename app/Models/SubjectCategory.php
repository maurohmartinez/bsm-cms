<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Support\Carbon;

/**
 * App\Models\SubjectCategory
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|SubjectCategory newModelQuery()
 * @method static Builder|SubjectCategory newQuery()
 * @method static Builder|SubjectCategory onlyTrashed()
 * @method static Builder|SubjectCategory query()
 * @method static Builder|SubjectCategory whereCode($value)
 * @method static Builder|SubjectCategory whereCreatedAt($value)
 * @method static Builder|SubjectCategory whereDeletedAt($value)
 * @method static Builder|SubjectCategory whereId($value)
 * @method static Builder|SubjectCategory whereName($value)
 * @method static Builder|SubjectCategory whereUpdatedAt($value)
 * @method static Builder|SubjectCategory withTrashed()
 * @method static Builder|SubjectCategory withoutTrashed()
 * @property-read mixed $full_name
 * @mixin Eloquent
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
