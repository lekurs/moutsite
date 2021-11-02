<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Taxe
 *
 * @property int $id
 * @property string $tax
 * @property int $main
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxe whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Taxe extends Model
{
    protected $fillable = [
        'tax',
        'main'
    ];

}
