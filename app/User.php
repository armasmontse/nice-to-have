<?php

namespace App;

use App\Models\Traits\User\PermissionRoleTrait;
use App\Models\Traits\AddressableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Notifications\Auth\ResetPasswordNotification;
use App\Models\Events\Event;
use App\Models\Products\Product;
use App\Models\Users\Card;
use App\Models\Users\BankAccount;

use App\Models\Shop\Bag;

class User extends Authenticatable
{
    use SoftDeletes;
    use PermissionRoleTrait;
    use Notifiable;
    use AddressableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'facebook_id',
        'password',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = [
    //     'wishlist_products_ids',
    // ];

    /**
     * creamos al usuario registrado desde el admin
     * @param array $input valores del request
     * @return User  usuario creado
     */
    public static function CltvoCreate(array $input)
    {
        // creamos el usuario
        return static::create([
            'name'          => trim($input['name']),
            'email'         => trim($input['email']),
            'first_name'    => trim($input['first_name']),
            'last_name'     => trim($input['last_name']),
            'password'      => bcrypt($input['password']),
            'active'        => $input['active'],
            "facebook_id"   => isset($input['facebook_id']) ? $input['facebook_id'] : null,
        ]);
    }

    public static function setRandomPassword()
    {
        return str_random(4).mt_rand(1, 10).str_random(4).mt_rand(10, 99).str_random(4);
    }

    /**
     * genera un nombre de usuario unico a partir del nombre y apellido
     * @param  string $firstName nombre
     * @param  string $lastName  apellido
     * @return string            nombre de usuario unico
     */
    public static function createUniqueUsername($firstName, $lastName)
    {
        $username = str_slug(trim($firstName)." ".trim($lastName)." ".rand(0, 99));

        $userNameNotUnique = true;

        while ($userNameNotUnique) {
            $users = static::withTrashed()->whereName($username)->get();
            if ($users->count() == 0) {
                $userNameNotUnique = false;
            } else {
                $username.= rand(0, 9);
            }
        }

        return $username;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function isActive()
    {
        return  $this->active;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function getHomeUrl()
    {
        return route("user::home", $this->name);
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function getActivationAcountUrl()
    {
        return route("client::pass_set:get", cltvoMailEncode($this->email));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function bags()
    {
        return $this->belongsToMany(Bag::class);
    }

    public function getInActiveBagsAttribute()
    {
        return $this->bags()->InActives()->get();
    }

    public function bank_accounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function isRelatedWith(Product $product)
    {
        return in_array($product->id, $this->wishlist_products_ids);
    }

    public function getWishlistProductsIdsAttribute()
    {
        return $this->products()->select(['id'])->get()->map(function ($product) {
            return $product->id;
        })->toArray();
    }

}
