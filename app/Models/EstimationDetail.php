<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EstimationDetail
 *
 * @property int $id
 * @property string $product
 * @property string $description
 * @property int $quantity
 * @property string $unit_price
 * @property string $total_row
 * @property int $display_order
 * @property int $estimation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $taxe_id
 * @property int|null $total_row_notax
 * @property int|null $total_row_tax
 * @property-read \App\Models\Estimation $estimation
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereEstimationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereTaxeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereTotalRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereTotalRowNotax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereTotalRowTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimationDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Taxe $taxe
 */
class EstimationDetail extends Model
{
    protected $fillable = [
      'product',
      'description',
      'quantity',
      'unit_price',
      'total_row',
      'display_order'
    ];

    protected $table = 'estimations_details';

    public function estimation(): BelongsTo
    {
        return $this->belongsTo(Estimation::class, 'estimation_id');
    }

    public function taxe(): BelongsTo
    {
        return $this->belongsTo(Taxe::class);
    }
}
