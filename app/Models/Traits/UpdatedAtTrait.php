<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait UpdatedAtTrait {

    public function getEditDateForHumansAttribute($full = false)
    {
        return $this->dateForHumans( $this->updated_at);
    }

    public function getCreateDateForHumansAttribute($full = false)
    {
        return $this->dateForHumans( $this->created_at);
    }


    public function dateForHumans(Carbon $date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
}
