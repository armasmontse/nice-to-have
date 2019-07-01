<?php

namespace App\Models\Traits;

use App\Models\Address\Address;

use Response;

trait AddressableTrait {

    /**
     *
     */
    public function addresses()
    {
        return $this->belongsToMany(Address::class)->withPivot('use');
    }

    public function getMainAddress()
    {
        return $this->getAddressTo("main");
    }

    public function getAddressTo($use)
    {
        return $this->addresses()->wherePivot("use",$use)->get()->first();
    }


    public function updateAddressToUse(array $address_args, $use)
    {
        $use_address = $this->getAddressTo($use);

        $continue = !$use_address ? true : false ;

        while ($continue) {
            $use_address = Address::create($address_args) ;
            if ($use_address) {
                $continue = !$this->addresses()->save($use_address, ["use"=>$use ]);
            }
        }

        foreach ($address_args as $key => $value) {
            $use_address->$key = $value;
        }

        return $use_address->save();

    }

}
