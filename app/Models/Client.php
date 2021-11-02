<?php


namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $zip
 * @property string|null $city
 * @property string|null $siren
 * @property string $slug
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimation[] $estimations
 * @property-read int|null $estimations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimation[] $estimationsByOrder
 * @property-read int|null $estimations_by_order_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimation[] $estimationsIsActive
 * @property-read int|null $estimations_is_active_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoicesNotPaid
 * @property-read int|null $invoices_not_paid_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereSiren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereZip($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
    ];

    public $module = [
        'name' => 'Client',
        'description' => 'activation du module client'
    ];

    public $permissions = [
        [
            'key' => 'show.one.client',
            'name' => 'Voir mon client',
            'role' => 'Client'
        ]
    ];


    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'client_id');
    }

    public function estimations(): HasMany
    {
        return $this->hasMany(Estimation::class, 'client_id');
    }

    public function estimationsIsActive(): HasMany
    {
        return $this->hasMany(Estimation::class, 'client_id')->isActive();
    }

    public function estimationsByOrder(): HasMany
    {
        return $this->hasMany(Estimation::class, 'client_id')->orderBy('created_at', 'asc');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }

    public function invoicesNotPaid(): HasMany
    {
        return $this->hasMany(Invoice::class, 'client_id')->notPaid();
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return mixed
     */
    public function scopeInitial(): mixed
    {
        $string = str_replace(['-', '_', '.'], ' ', $this->name);
        if(substr_count($string, ' ') > 0) {
            $letters = '';
            $words = explode(' ', $string);
            foreach ($words as $letter) {
                $letters .= $letter[0];
            }
            return $letters;
        }
        return $string[0];
    }
}
