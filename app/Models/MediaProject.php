<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MediaProject
 *
 * @property int $id
 * @property string $mediaProjectPath
 * @property int $displayOrder
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject whereMediaProjectPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaProject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MediaProject extends Model
{
    protected $fillable = [
        'mediaProjectPath'
    ];

    protected $table = 'media_projects';

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
