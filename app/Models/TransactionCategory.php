<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\TransactionCategory
 *
 * @property int $id
 * @property string $name
 * @property TransactionTypeEnum $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TransactionCategory newModelQuery()
 * @method static Builder|TransactionCategory newQuery()
 * @method static Builder|TransactionCategory onlyTrashed()
 * @method static Builder|TransactionCategory query()
 * @method static Builder|TransactionCategory whereCreatedAt($value)
 * @method static Builder|TransactionCategory whereId($value)
 * @method static Builder|TransactionCategory whereName($value)
 * @method static Builder|TransactionCategory whereType($value)
 * @method static Builder|TransactionCategory whereUpdatedAt($value)
 * @method static Builder|TransactionCategory withTrashed()
 * @method static Builder|TransactionCategory withoutTrashed()
 * @mixin Eloquent
 */
class TransactionCategory extends Model
{
    use HasFactory;
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = ['type' => TransactionTypeEnum::class];

    public static function boot(): void
    {
        parent::boot();

        // Protect Bank and Cash
        self::updating(fn (self $model) => $model->id > 4);
        self::deleting(fn (self $model) => $model->id > 4);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transaction_category_id');
    }
}
