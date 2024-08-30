<?php

namespace App\Models;

use App\Enums\AccountEnum;
use App\Enums\TransactionTypeEnum;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Transaction
 *
 * @property integer $amount
 * @property-read TransactionCategory|null $transactionCategory
 * @property-read Customer|null $customer
 * @property-read Vendor|null $vendor
 * @property Carbon $when
 * @property AccountEnum $account
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction onlyTrashed()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction withTrashed()
 * @method static Builder|Transaction withoutTrashed()
 * @method static Builder|Transaction expense()
 * @method static Builder|Transaction income()
 * @mixin Eloquent
 */
class Transaction extends Model
{
    use HasFactory;
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'transaction_category_id',
        'customer_id',
        'vendor_id',
        'amount',
        'account',
        'description',
        'images',
        'when',
    ];

    protected $casts = ['images' => 'array', 'when' => 'date', 'account' => AccountEnum::class];

    public static function boot(): void
    {
        parent::boot();

        // Clear related cache
        self::created(fn (self $model) => self::clearRelatedCache($model));
        self::updated(fn (self $model) => self::clearRelatedCache($model));
        self::deleted(fn (self $model) => self::clearRelatedCache($model));
    }

    public function transactionCategory(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn (string $val) => self::toCurrency($val),
            set: fn (string $val) => self::fromCurrency($val),
        );
    }

    public function scopeExpense(Builder $query): Builder
    {
        return $query->whereHas('transactionCategory', fn (Builder $q) => $q->where('type', TransactionTypeEnum::EXPENSE->value));
    }

    public function scopeIncome(Builder $query): Builder
    {
        return $query->whereHas('transactionCategory', fn (Builder $q) => $q->where('type', TransactionTypeEnum::INCOME->value));
    }

    public function getCacheKey(): string
    {
        return 'transaction_' . strtolower($this->transactionCategory->type->value) . '_' . $this->when->month;
    }

    public static function toCurrency(int $value): string
    {
        $number = '';
        $numbers = str_split($value);

        foreach ($numbers as $key => $numb) {
            if ($key > 0 && $key - count($numbers) === -5) {
                $number .= '.';
            }
            if ($key - count($numbers) === -2) {
                $number .= $key === 0 ? '0' : '';
                $number .= ',';
            }
            $number .= $numb;
        }

        return $number;
    }

    public static function fromCurrency(string $value): int
    {
        return (int)str_replace(',', '', str_replace('.', '', str_replace('€', '', trim($value))));
    }

    private static function clearRelatedCache(self $model): void
    {
        Cache::forget($model->getCacheKey());
        Cache::forget('transaction_' . strtolower($model->account->value) . '_' . $model->when->year);
    }
}
