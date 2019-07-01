<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Models\Events\CashOut;

class BankAccount extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bank_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'CLABE','name','bank','user_id','account_number','branch'
    ];


    protected $casts = [
        'id'        => 'integer',
        'user_id'   => 'integer',
        'CLABE'     => 'string',
        'name'      => 'string',
        'bank'      => 'string',

    ];

    /**
     * Trae los permisos del role
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashOuts()
    {
        return $this->hasMany(CashOut::class);
    }

    public function displayCLABE()
    {
        return substr($this->CLABE, 0, 3).' '.substr($this->CLABE, 3, 3).' '.substr($this->CLABE, 6, 11).' '.substr($this->CLABE, 17, 1);
    }

    public function secretCLABE()
    {
        return 'XXX XXX XXXX XXXX '.substr($this->CLABE, 14, 4);
    }
}
