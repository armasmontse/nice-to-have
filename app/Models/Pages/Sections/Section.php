<?php

namespace App\Models\Pages\Sections;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pages\Sections\Components\Component;
use App\Models\Traits\UpdatedAtTrait;
use App\Models\Pages\Page;

class Section extends Model
{
    use UpdatedAtTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pages',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'index',
        'template_path',
        'components_max',
        'type_id',
        'editable_contents',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type_id'           => 'integer',
        'components_max'    => 'integer',
        'editable_contents' => 'array'
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'type_label',
        'implode_pages_index',
        'implode_editable_contents',
        'minified',
    ];

    /**
     * Get type label.
     *
     * @return bool
     */
    public function getTypeLabelAttribute()
    {
        return $this->type->label.( $this->components_max ? "<br/><small> Componentes:".$this->components_max."</small>" : "");
    }

    /**
     * Get type label.
     *
     * @return bool
     */
    public function getLabelAttribute()
    {
        return trans('sections.'.$this->index. '.title');
    }
    /**
     * Get type label.
     *
     * @return bool
     */
    public function getMinifiedAttribute()
    {
        return (object) [
            "id"    => $this->id,
            "index" => $this->index
        ];
    }

    /**
     * Get type label.
     *
     * @return bool
     */
    public function getMapedAttribute()
    {
        return (object) [
            'id'                    => $this->id,
            'index'                 => $this->index,
            'template_path'         => $this->template_path,
            'components_max'        => $this->components_max,
            'type_id'               => $this->type_id,
            'editable_contents'     => $this->all_editable_contents,
            'components'            => $this->all_components,
            'type'                  => $this->type,
            'description'           => $this->description,
            'label'                 => $this->label
        ];
    }

    /**
     * Get type label.
     *
     * @return bool
     */
    public function getAllComponentsAttribute()
    {
        $db_components = $this->components()->getWithTranslations()->get();

        if (!$this->type->protected && !$this->type->unlimited) {
            $components = [];
            for ($i=0; $i < $this->components_max ; $i++) {
                $component = $db_components->where("order",$i)->first();
                $components[] = $component ? $component : Component::Create(["section_id" => $this->id,"order"=>$i]);
            }
            return collect($components);
        }

        return $db_components;
    }

    /**
     * Get type label.
     *
     * @return bool
     */
    public function getAllEditableContentsAttribute()
    {
        $all_editable_contents = [];
        foreach (Component::EDITABLE_CONTENTS as $key => $label) {
            $all_editable_contents[$key] = (boolean)(isset($this->editable_contents[$key]) ? $this->editable_contents[$key] : false);
        }

        return (object) $all_editable_contents;
    }


    /**
     * Get type label.
     *
     * @return bool
     */
    public function getImplodePagesIndexAttribute()
    {
        if ($this->pages->isEmpty()) {
            return "Sin páginas";
        }
        return $this->pages->implode("index",",<br/>");
    }

    /**
     * Get type label.
     *
     * @return bool
     */
    public function getImplodeEditableContentsAttribute()
    {
        $editable_contents = collect($this->editable_contents ? $this->editable_contents : []);

        return $editable_contents->map(function($true,$key){
            return $true && isset(Component::EDITABLE_CONTENTS[$key]) ? Component::EDITABLE_CONTENTS[$key] : null;
        })->implode(",<br/>");
    }


    /**
     * Get the type that owns the section.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * The pages that belong to the section.
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class)
            ->withPivot(["order"])
            ->orderBy('pivot_order',"ASC")
            ->withTimestamps();
    }

    /**
     * Trae las sections del component
     */
    public function components()
    {
        return $this->hasMany(Component::class)
            ->orderBy('order',"ASC");
    }


    public function isDeletable()
    {
        $total = 0;
        $total += $this->pages->count();
        $total += $this->components->count();
        return $total == 0;
    }
}
