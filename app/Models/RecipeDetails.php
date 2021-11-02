<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RecipeDetails
 *
 * @property int $id
 * @property string $description
 * @property string|null $picture_path
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $recipe_id
 * @property-read \App\Models\Device $device
 * @property-read \App\Models\Recipe $recipe
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails wherePicturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeDetails whereUserId($value)
 * @mixin \Eloquent
 */
class RecipeDetails extends Model
{
    use HasFactory;

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
