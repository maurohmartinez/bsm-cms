<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Interpreter
 *
 * @property int $id
 * @property string $name
 * @property int $year_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Year $year
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter whereYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Interpreter withoutTrashed()
 * @mixin \Eloquent
 */
class Interpreter extends Model
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
        'year_id',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
