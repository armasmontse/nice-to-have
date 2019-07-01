<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\TranslationTrait;
use App\Models\Traits\AssociableTrait;

use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

use Image;
use File;
use Storage;

class Photo extends Model
{
    use TranslationTrait;
    use AssociableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photos';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_photo';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename',
        'type'
    ];

    protected  $translatable = [
        'title',
        'alt',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
         "deleted_at",
         "languages",
     ];

    const STORAGE_PATH = "public/images";
    const THUMBNAILS_STORAGE_PATH = "public/images/thumbnails";
    const THUMBNAILS_SIZE   = 120;


    public static $associable_models = [
        // code  => class name
        "sku"               => "App\Models\Skus\Sku",
        "product"           => "App\Models\Products\Product",
        "template"          => "App\Models\Events\EventTemplate",
        "section"           => "App\Models\Events\EventTemplateSection",
        "type"              => "App\Models\Events\Type",
        "setting"           => "App\Setting",
        'page_component'    => "App\Models\Pages\Sections\Components\Component"
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'thumbnail_url',
        'url',
        "title",
        'alt',
        'description',

        "pivot_use"  ,
        "pivot_class",
        "pivot_order",
        // 'es',
    ];


    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->getImageThumbnailUrl();
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getUrlAttribute()
    {
        return $this->getImageUrl();
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getTitleAttribute()
    {
        return $this->translation()->title;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getAltAttribute()
    {
        return $this->translation()->alt;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getDescriptionAttribute()
    {
        return $this->translation()->description;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getPivotUseAttribute()
    {
        return $this->pivot ? $this->pivot->use : null ;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getPivotClassAttribute()
    {
        return $this->pivot ? $this->pivot->class : null ;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getPivotOrderAttribute()
    {
        return $this->pivot ? $this->pivot->order : null ;
    }


// carpetas
    /**
     * Crea si no existe una carpeta
     * @param  string $path carpeta a verificar
     * @return string       carpeta a verificar
     */
    public static function existsOrCreatePath($path)
    {
        File::exists($path) or File::makeDirectory($path);
        return $path;
    }

    /**
    * Crea si no existe la carpeta donde se guardara la Thumbnail la imagen
    * @return string   directorio de la Thumbnail la imagen
    */
    public static function getImagesThumbnailsPath()
    {
        $thumbnails_path = storage_path("app/". static::THUMBNAILS_STORAGE_PATH );
        return  static::existsOrCreatePath($thumbnails_path);
    }

    /**
     * Crea si no existe de las imagenes
     * @return string           ruta
     */
    public static function getImagesPath()
    {
        return static::existsOrCreatePath( storage_path("app/".static::STORAGE_PATH) ) ;
    }


//
//
//
//
//
//     /**
//      * Crea si no existe de las imagenes
//      * @return string           ruta
//      */
//     public static function imagesPath()
//     {
//         return self::existsOrCreatePath( public_path().self::STORAGE_PATH ) ;
//     }
//
//     /**
//      * Crea si no existen de las de mes y año
//      * @param  string $year     nombre de la carpeta
//      * @param  string $month    nombre de la subcapeta
//      * @return string           ruta
//      */
//     public static function imagesYearMountPath($year, $month)
//     {
//         $mediaManagerPath = self::imagesPath();
//         $yearPath = self::existsOrCreatePath( $mediaManagerPath.$year.'/' ) ;
//         return self::existsOrCreatePath($yearPath.$month.'/' ) ;
//
//     }
//
//     /**
//      * Crea si no existe de las de mes y año y thumbnails
//      * @param  string $year     nombre de la carpeta
//      * @param  string $month    nombre de la subcapeta
//      * @return string           ruta
//      */
//     public static function imagesThumbnailsPath($year, $month)
//     {
//         $yearMonthPath = self::imagesYearMountPath($year, $month);
//         return self::existsOrCreatePath( $yearMonthPath.self::THUMBNAILS_STORAGE_PATH) ;
//     }
//

// // carpeta publica
//
//     /**
//      * Regresa la carpeta publica del mes y año
//      * @param  string $year  nombre de la carpeta
//      * @param  string $month nombre de la subcarpeta
//      * @return string        publica del mes y año
//      */
//     public static function imagesPublicFolder($year, $month)
//     {
//         return self::STORAGE_PATH.$year."/".$month."/";
//     }

// // borrar archivos
//
//     /**
//      * Borra un archivo o directorio
//      * @param  string $filename  ruta del archivo
//      * @return boolean           si se borro el archivo o no
//      */
//     public static function eraseImageFile($filename)
//     {
//         if ( File::exists($filename) ) {
//              return File::delete($filename);
//         }
//         return true;
//     }

// crea una nueva

    /**
     * crea una nueva imagen a partir de un archivo
     * @param  UploadedFile $image archivo de imagen
     * @return Photo|null              regresa el objeto de photo en caso de craese correctamente
     */
    public static function createImageFile(UploadedFile $img_file)
    {
        $file_path = $img_file->store(static::STORAGE_PATH);

        if (!$file_path) {
            return ;
        }

        try {
        // creamos el objeto de imagen
            $imageFile = Image::make( storage_path("app/".$file_path)  );

        // thunmbail
            $imageFile->resize(static::THUMBNAILS_SIZE, null, function ($constraint) {
                $constraint->aspectRatio();
            });

        } catch (Exception $e) {
            Storage::delete($file_path);
            return ;
        }

        try {
             $imageFile->save( static::getImagesThumbnailsPath()."/".$imageFile->basename );
        } catch (Exception $e) {
            Storage::delete($file_path);
            return ;
        }

        return $file_path;
    }


    public static function existsPhoto($file_name)
    {
        $photos = static::GetPhotoCollectionByFileName($file_name);
        return $photos->count() > 0;
    }

    public function scopeGetPhotoCollectionByFileName($query, $file_name)
    {
        return $query->where(['filename'=> $file_name])->get();
    }


// de cada imagen
    // /**
    //  * Crea si no existe la carpeta donde se guardara la imagen
    //  * @return string   directorio de la imagen
    //  */
    // public function getImagePath()
    // {
    //     return self::imagesYearMountPath( $this->created_at->format("Y"), $this->created_at->format("m")  ) ;
    // }


    // /**
    //  * obtiene el direcotrio publico de una imagen
    //  * @return string directorio publico de una imagen
    //  */
    // public function getPublicFolder()
    // {
    //     return self::imagesPublicFolder($this->created_at->format("Y"),$this->created_at->format("m"));
    // }


// public access
    /**
     * url de la imagen
     * @return string url de la imagen
     */
    public function getImagePublicPath()
    {
        $public_path = str_replace("public", "storage", static::STORAGE_PATH);
        return str_replace(static::STORAGE_PATH,$public_path,  $this->filename);
    }

    /**
     * url de la imagen
     * @return string url de la imagen
     */
    public function getImageUrl()
    {
        return url($this->getImagePublicPath());
    }


    /**
     * url de la imagen
     * @return string url de la imagen
     */
    public function getImageThumbnailPublicPath()
    {
        $public_path = str_replace("public", "storage", static::THUMBNAILS_STORAGE_PATH);
        return str_replace(static::STORAGE_PATH,$public_path,  $this->filename);
    }

    /**
     * url de la imagen
     * @return string url de la imagen
     */
    public function getImageThumbnailUrl()
    {
        return url($this->getImageThumbnailPublicPath());
    }


    /**
     * borra losarchivos de una imagen
     * @return boolean true en caso de borrar ambos archivos
     */
    public function deleteImageFiles()
    {
        return Storage::delete($this->filename) && Storage::delete(str_replace(static::STORAGE_PATH, static::THUMBNAILS_STORAGE_PATH, $this->filename))  ;
    }


    // /**
    //  * Get all of the posts that are assigned this tag.
    //  */
    // public function garments()
    // {
    //     return $this->morphedByMany('App\Models\Garments\Garment', 'photoable');
    // }

    /**
     * si una imagen puede ser borrada
     * @return boolean si una imagen tienen objetos asociados regresa false
     */
    public function isDeletable()
    {
        $total = 0;

        // $total += $this->garments->count();
        /// pendiente
        return $total == 0;
    }

}
