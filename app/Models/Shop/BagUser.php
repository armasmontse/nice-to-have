<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

use App\User;

class BagUser extends Model
{
    /**
     * [$primaryKey description]
     * @var string
     */
    protected $primaryKey = 'bag_id';

    /**
     * [$incrementing description]
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bag_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bag_id',
        'user_id',
        'accept_terms',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bag_id'        => 'integer',
        'user_id'       => 'integer',
        'accept_terms'  => 'boolean',
        'info'          => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'id',
    ];

    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getIdAttribute()
    {
        return $this->attributes['bag_id'];
    }

}
