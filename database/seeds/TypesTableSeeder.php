<?php

use Illuminate\Database\Seeder;

use App\Models\Events\Type;
use App\Language;

use App\Photo;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $languages = Language::GetLanguagesIso()->toArray();
        $images = Photo::get();
        factory(Type::class, 5 )->create()->each(function($type) use ($languages,$faker, $images){
            foreach ($languages as $id => $iso) {
                $name = $faker->unique()->word;
                $type->updateTranslationByIso($iso,[
                    'label'          => $name,
                    'slug'           => Type::generateUniqueSlug($name),
                    'description'    => $faker->text(),
                    'title'          => $faker->sentence(),
                ]);
            }

            // imagens
                if ($images->count() > 0) {
                    $photo = $images->random(1);
                    $use_order_and_class = [ 'use' => "thumbnail" , 'order' => null, 'class' => ''];
                    $type->associateImage($photo, $use_order_and_class);
                }
        });
    }
}
