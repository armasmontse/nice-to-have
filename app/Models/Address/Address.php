<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Interfaces\AddressableInterface;

class Address extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
		'street1',
		'street2',
		'street3',
		'city',
		'state',
		'zip',
		'contact_name',
		'phone',
		'references',
		'email'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // public function modeloQueSea's'()
    // {
    //     return $this->morphedByMany(modeloQueSea::class, 'adressable')->withPivot("use");
    // }
    //*--- En modeloQueSea.php agregar método --*
    // use App\Models\Traits\AddressableTrait;
    // use AddressableTrait;

    public function getInZmvmAttribute()
    {
        return Country::inZMVM($this->state,$this->street2);
    }


    public static function getMainAddressTo(AddressableInterface $addresable = null)
    {
        if ($addresable) {
            $address = $addresable->getMainAddress();

            if ($address) {
                return $address;
            }
        }
        return new static;
    }

}
