<?php

use Illuminate\Database\Seeder;
use App\Language;

use Illuminate\Http\File;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thunmbail_width = App\Photo::THUMBNAILS_SIZE;

        $faker = Faker\Factory::create();

        $languages = Language::GetLanguagesIso()->toArray();
        $images = collect( Storage::allFiles("cltvo/image_seeder") )->map(function($file_path){
            return new File( storage_path("app/".$file_path) );
        });

        $total_images = $images->count();
        factory( App\Photo::class,$total_images )->create()->each(function($photo,$key) use ($languages,$faker,$thunmbail_width,$images){

            if (!array_has($images,$key)) { // si la foto no existe borramos el modelo
                dump("no source found");
                $photo->delete();
                return ;
            }

            $file_path = Storage::putFile( App\Photo::STORAGE_PATH , $images[$key]);

            if (!$file_path) {
                dump("no save file");
                $photo->delete();
                return ;
            }

            try {
            // creamos el objeto de imagen
                $imageFile = Image::make( storage_path("app/".$file_path)  );

            // thunmbail
                $imageFile->resize($thunmbail_width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

            } catch (Exception $e) {
                dump("El archivo ".$file_path." no es una imagen valida");
                Storage::delete($file_path);
                $photo->delete();
                return ;
            }

            try {
                 $imageFile->save( App\Photo::getImagesThumbnailsPath()."/".$imageFile->basename );
            } catch (Exception $e) {
                dump("No se pudo crear el thumbnail");
                Storage::delete($file_path);
                $photo->delete();
                return ;
            }

            $photo->filename = $file_path;
            $photo->type = $images[$key]->getMimeType();

            try {
                $photo->save();
            } catch (Exception $e) {
                dump("Imagen cargada previamente");
                $photo->delete();
                return ;
            }

            foreach ($languages as $id => $iso) {
                $photo->updateTranslationByIso($iso,[
                    'title'          => $faker->sentence(3),
                    'alt'            => $faker->sentence(3),
                    'description'    => $faker->sentence(12)
                ]);
            }

        });
    }
}
