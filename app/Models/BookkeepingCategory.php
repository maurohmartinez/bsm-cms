<?php

namespace App\Models;

use App\Enums\BookkeepingTypeEnum;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\BookkeepingCategory
 *
 * @property int $id
 * @property string $name
 * @property BookkeepingTypeEnum $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|BookkeepingCategory newModelQuery()
 * @method static Builder|BookkeepingCategory newQuery()
 * @method static Builder|BookkeepingCategory onlyTrashed()
 * @method static Builder|BookkeepingCategory query()
 * @method static Builder|BookkeepingCategory whereCreatedAt($value)
 * @method static Builder|BookkeepingCategory whereId($value)
 * @method static Builder|BookkeepingCategory whereName($value)
 * @method static Builder|BookkeepingCategory whereType($value)
 * @method static Builder|BookkeepingCategory whereUpdatedAt($value)
 * @method static Builder|BookkeepingCategory withTrashed()
 * @method static Builder|BookkeepingCategory withoutTrashed()
 * @mixin Eloquent
 */
class BookkeepingCategory extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = ['type' => BookkeepingTypeEnum::class];
}
