<?php

namespace App\Models\Pages\Sections;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sectiontypes';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'description',
        'admin_view_path',
        'protected',
        'unlimited',
        'sortable'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'protected'    => 'boolean',
        'unlimited'    => 'boolean',
    ];

    /**
     * Trae los paises  del grupo
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Get type label + descriotion.
     *
     * @return bool
     */
    public function getLabelDescriptionAttribute()
    {
        return $this->label.( " (".$this->description.")" );
    }

}
