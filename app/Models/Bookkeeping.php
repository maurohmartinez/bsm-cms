<?php

namespace App\Models;

use App\Enums\BookkeepingAccountEnum;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Bookkeeping
 *
 * @property-read BookkeepingCategory|null $bookkeepingCategory
 * @property-read Customer|null $customer
 * @property-read Vendor|null $vendor
 * @method static Builder|Bookkeeping newModelQuery()
 * @method static Builder|Bookkeeping newQuery()
 * @method static Builder|Bookkeeping onlyTrashed()
 * @method static Builder|Bookkeeping query()
 * @method static Builder|Bookkeeping withTrashed()
 * @method static Builder|Bookkeeping withoutTrashed()
 * @mixin Eloquent
 */
class Bookkeeping extends Model
{
    use HasFactory;
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'bookkeeping';

    protected $fillable = [
        'bookkeeping_category_id',
        'customer_id',
        'vendor_id',
        'amount',
        'account',
        'description',
        'images',
        'when',
    ];

    protected $casts = ['images' => 'array', 'when' => 'date', 'account' => BookkeepingAccountEnum::class];

    public function bookkeepingCategory(): BelongsTo
    {
        return $this->belongsTo(BookkeepingCategory::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
