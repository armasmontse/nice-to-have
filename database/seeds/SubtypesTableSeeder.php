<?php

use Illuminate\Database\Seeder;

use App\Models\Events\Subtype;
use App\Language;

class SubtypesTableSeeder extends Seeder
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
        factory(Subtype::class, 25  )->create()->each(function($subtypes) use ($languages,$faker){
            foreach ($languages as $id => $iso) {
                $name = $faker->unique()->word;
                $subtypes->updateTranslationByIso($iso,[
                    'label'          => $name,
                    'slug'           => Subtype::generateUniqueSlug($name)
                ]);
            }
        });
    }
}
