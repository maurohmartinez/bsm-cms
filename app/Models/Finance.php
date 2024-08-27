<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Barryvdh\LaravelIdeHelper\Eloquent;

/**
 * App\Models\Finance
 *
 * @property int $id
 * @property int $bookkeeping_id
 * @property int $bank_statement
 * @property int $cash_statement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Bookkeeping $bookkeeping
 * @method static Builder|Finance newModelQuery()
 * @method static Builder|Finance newQuery()
 * @method static Builder|Finance onlyTrashed()
 * @method static Builder|Finance query()
 * @method static Builder|Finance whereBankStatement($value)
 * @method static Builder|Finance whereBookkeepingId($value)
 * @method static Builder|Finance whereCashStatement($value)
 * @method static Builder|Finance whereCreatedAt($value)
 * @method static Builder|Finance whereId($value)
 * @method static Builder|Finance whereUpdatedAt($value)
 * @method static Builder|Finance withTrashed()
 * @method static Builder|Finance withoutTrashed()
 * @mixin Eloquent
 */
class Finance extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'bookkeeping_id',
        'bank_statement',
        'cash_statement',
    ];

    public function bookkeeping(): BelongsTo
    {
        return $this->belongsTo(Bookkeeping::class);
    }
}
