<?php 

namespace App\Models\Traits;

use App\Photo;

use Image;
use Response;
use stdClass;

trait PhotoableTrait {

    protected $defaultUseOrderAndClass = [
        "use"       => "thumbail",
        "order"     => null,
        "class"     => ""
    ];

    protected $photoable = [
        "use"   ,
        "order" ,
        "class" ,
    ];

    /**
     * trae los paises del usuario
     */
    public function photos()
    {
        return $this->belongsToMany(Photo::class)
            ->with("languages")
            ->withPivot($this->photoable)
            ->orderBy('pivot_use',"ASC")
            ->orderBy('pivot_order',"ASC")
            ->withTimestamps();
    }

    /**
     * Asigna una imagen
     * @param  Image  $image imagen a ser agregada
     * @param  array $UseOrderAndClass   uso, orden y clase que se le va dar a esta imagen
     */
    public function associateImage(Photo $image,array $UseOrderAndClass )
    {
        return $this->photos()->save($image,$this->setFiller($UseOrderAndClass) );
    }

    /**
     * Asigna una imagen
     * @param  Image  $image imagen a ser agregada
     * @param  array $UseOrderAndClass   uso, orden y clase que se le va dar a esta imagen
     */
    public function disassociateImage(Photo $image,array $UseOrderAndClass )
    {
        $photos = $this->photos();
        foreach ($UseOrderAndClass as $key => $value) {
            $photos->wherePivot($key,$value);
        }
        return $photos->detach($image);
    }

    /**
     *  si el usuario tiene la imagen de algun tipo
     * @param  array $UseOrderAndClass   uso, orden y clase que se le va dar a esta imagen
     */
    public function setFiller(array $UseOrderAndClass)
    {
        $UseOrderAndClassArray= [];

        foreach ($this->defaultUseOrderAndClass as $key => $value) {
            $UseOrderAndClassArray[$key]  = isset($UseOrderAndClass[$key]) ? $UseOrderAndClass[$key] : $value;
        }

        return $UseOrderAndClassArray ;
    }

    /**
     *  si el usuario tiene la imagen de algun tipo
     * @param  array $UseOrderAndClass   uso, orden y clase que se le va dar a esta imagen
     */
    public function hasPhotoTo($UseOrderAndClass)
    {
        $photos = $this->getPhotosTo($UseOrderAndClass);
        return $photos->count() > 0;
    }

    public function cantUsePhotoFor(Photo $photo, $use)
    {
        return $this->photos()->where(["id" => $photo->id ])->wherePivot("use",$use)->get()->count() > 0;
    }

    public function getPhotosTo($UseOrderAndClass)
    {
        $photos =  $this->photos();

        foreach ($UseOrderAndClass as $key => $value) {
            $photos->wherePivot($key,$value);
        }

        return $photos->get();
    }

    public function getFirstPhotoTo($UseOrderAndClass)
    {
        return $this->getPhotosTo($UseOrderAndClass)->first();
    }

    public function getPhotoableCode()
    {
        return array_search( get_class($this) , Photo::$associable_models )  ;
    }

    /**
    * Get the administrator flag for the user.
    *
    * @return bool
    */
    public function getThumbnailImageAttribute()
    {
        $photo = $this->getFirstPhotoTo(['use' => 'thumbnail']);
        return $photo ? $photo : (object) [
            'url' => '', 
            'alt' => '',
            'title' => ''
        ];
    }
}