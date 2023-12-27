<?php

namespace App\Models;

use App\Enums\LanguagesEnum;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'language' => LanguagesEnum::class,
    ];
}
