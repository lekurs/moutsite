<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property string $title
 * @property string $number
 * @property string $amount
 * @property int $paid
 * @property int $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $year
 * @property-read \App\Models\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimation[] $estimations
 * @property-read int|null $estimations_count
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice notPaid()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereAmount($value)
 * @method static Builder|Invoice whereClientId($value)
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereNumber($value)
 * @method static Builder|Invoice wherePaid($value)
 * @method static Builder|Invoice whereTitle($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereYear($value)
 * @mixin \Eloquent
 * @property string $reference
 * @property int $advance
 * @property string|null $amount_no_tax
 * @property string|null $amount_tax
 * @property string $month
 * @property string|null $observation
 * @property string|null $paiment_date
 * @property int $estimation_id
 * @property-read \App\Models\Estimation $estimation
 * @method static Builder|Invoice isAdvance()
 * @method static Builder|Invoice whereAdvance($value)
 * @method static Builder|Invoice whereAmountNoTax($value)
 * @method static Builder|Invoice whereAmountTax($value)
 * @method static Builder|Invoice whereEstimationId($value)
 * @method static Builder|Invoice whereMonth($value)
 * @method static Builder|Invoice whereObservation($value)
 * @method static Builder|Invoice wherePaimentDate($value)
 * @method static Builder|Invoice whereReference($value)
 */
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
    ];

    public $module = [
        'name' => 'Facture',
        'description' => 'Voici la description de mon module facture'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function estimation(): BelongsTo
    {
        return $this->belongsTo(Estimation::class);
    }

    public function scopeIsAdvance(Builder $query): Builder
    {
        return $query->where('advance', '=',true);
    }

    public function scopeNotPaid(Builder $query): Builder
    {
        return $query->where('paid', '=', false);
    }
}
