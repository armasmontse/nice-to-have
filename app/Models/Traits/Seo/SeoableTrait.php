<?php

namespace App\Models\Traits\Seo;

use App\Models\Seo\Seo;

trait SeoableTrait
{
    public function seo()
    {
        return $this->morphMany(Seo::class, 'seoable');
    }
}
