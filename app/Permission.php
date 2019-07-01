<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug','label'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeCollectPermissionsBySlug($query,$role_slug)
    {
        return $query->where([
            'slug' => $role_slug
        ])->get();
    }
}
