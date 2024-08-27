<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Support\Carbon;

/**
 * App\Models\Interpreter
 *
 * @property int $id
 * @property string $name
 * @property int $year_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Year $year
 * @method static Builder|Interpreter newModelQuery()
 * @method static Builder|Interpreter newQuery()
 * @method static Builder|Interpreter onlyTrashed()
 * @method static Builder|Interpreter query()
 * @method static Builder|Interpreter whereCreatedAt($value)
 * @method static Builder|Interpreter whereDeletedAt($value)
 * @method static Builder|Interpreter whereId($value)
 * @method static Builder|Interpreter whereName($value)
 * @method static Builder|Interpreter whereUpdatedAt($value)
 * @method static Builder|Interpreter whereYearId($value)
 * @method static Builder|Interpreter withTrashed()
 * @method static Builder|Interpreter withoutTrashed()
 * @mixin Eloquent
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
