<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $libelle
 * @property string $description
 * @property string $expertise
 * @property string $icon
 * @property string|null $color_icon
 * @property int $status
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimation[] $Estimations
 * @property-read int|null $estimations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimation[] $EstimationsServices
 * @property-read int|null $estimations_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereColorIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereExpertise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    protected $fillable = [
        'libelle',
        'description',
        'icon'
    ];

    public function Estimations(): HasMany
    {
        return $this->hasMany(Estimation::class, 'estimation_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'projects_services');
    }

    public function EstimationsServices(): BelongsToMany
    {
        return $this->belongsToMany(Estimation::class, 'estimations_services');
    }
}

