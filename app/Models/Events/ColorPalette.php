<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

use stdClass;

class ColorPalette extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'color_palettes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'color_1',
        'color_2',
        'color_3',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'color_1'  => 'string',
        'color_2'  => 'string',
        'color_3'  => 'string',
    ];

    protected $appends = [
        'colors',
    ];

    public function getColorsAttribute()
    {
        return collect([ $this->color_1, $this->color_2, $this->color_3]);
    }

}
