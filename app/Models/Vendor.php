<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Barryvdh\LaravelIdeHelper\Eloquent;

/**
 * App\Models\Vendor
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Vendor newModelQuery()
 * @method static Builder|Vendor newQuery()
 * @method static Builder|Vendor onlyTrashed()
 * @method static Builder|Vendor query()
 * @method static Builder|Vendor whereCreatedAt($value)
 * @method static Builder|Vendor whereDescription($value)
 * @method static Builder|Vendor whereId($value)
 * @method static Builder|Vendor whereName($value)
 * @method static Builder|Vendor whereUpdatedAt($value)
 * @method static Builder|Vendor withTrashed()
 * @method static Builder|Vendor withoutTrashed()
 * @mixin Eloquent
 */
class Vendor extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];
}
