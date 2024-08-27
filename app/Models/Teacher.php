<?php

namespace App\Models;

use App\Enums\LanguagesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Barryvdh\LaravelIdeHelper\Eloquent;

/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $image
 * @property string $country
 * @property LanguagesEnum $language
 * @property bool $is_local
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|Teacher newModelQuery()
 * @method static Builder|Teacher newQuery()
 * @method static Builder|Teacher onlyTrashed()
 * @method static Builder|Teacher query()
 * @method static Builder|Teacher whereCountry($value)
 * @method static Builder|Teacher whereCreatedAt($value)
 * @method static Builder|Teacher whereDeletedAt($value)
 * @method static Builder|Teacher whereEmail($value)
 * @method static Builder|Teacher whereId($value)
 * @method static Builder|Teacher whereImage($value)
 * @method static Builder|Teacher whereIsLocal($value)
 * @method static Builder|Teacher whereLanguage($value)
 * @method static Builder|Teacher whereName($value)
 * @method static Builder|Teacher wherePhone($value)
 * @method static Builder|Teacher whereUpdatedAt($value)
 * @method static Builder|Teacher withTrashed()
 * @method static Builder|Teacher withoutTrashed()
 * @mixin Eloquent
 */
class Teacher extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Illuminate\Notifications\Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'language',
        'is_local',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'language' => LanguagesEnum::class,
        'is_local' => 'boolean',
    ];
}
