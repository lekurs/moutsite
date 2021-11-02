<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $title
 * @property string $mission
 * @property string $result
 * @property string $mediaPortfolioProjectPath
 * @property string $background_img_path
 * @property string $colorProject
 * @property string $slug
 * @property string $endProject
 * @property int $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MediaProject[] $mediaProjects
 * @property-read int|null $media_projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $skills
 * @property-read int|null $skills_count
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereBackgroundImgPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereColorProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereEndProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereMediaPortfolioProjectPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereMission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $in_progress
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereInProgress($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Recipe[] $recipes
 * @property-read int|null $recipes_count
 */
class Project extends Model
{
    use HasFactory;

    protected $fillables = [

    ];

    public function mediaProjects(): HasMany
    {
        return $this->hasMany(MediaProject::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'projects_services');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'projects_skills');
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_users');
    }

//    public function pages(): HasMany
//    {
//        return $this->hasMany(Page::class);
//    }
}
