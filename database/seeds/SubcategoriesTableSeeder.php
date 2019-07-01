<?php

use Illuminate\Database\Seeder;

use App\Models\Products\Subcategory;
use App\Language;

class SubcategoriesTableSeeder extends Seeder
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
        factory(Subcategory::class, 25  )->create()->each(function($subcategory) use ($languages,$faker){
            foreach ($languages as $id => $iso) {
                $name = $faker->unique()->word;
                $subcategory->updateTranslationByIso($iso,[
                    'label'          => $name,
                    'slug'           => Subcategory::generateUniqueSlug($name)
                ]);
            }
        });
    }
}
