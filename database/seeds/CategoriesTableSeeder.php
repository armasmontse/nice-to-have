<?php

use Illuminate\Database\Seeder;

use App\Models\Products\Category;
use App\Language;

class CategoriesTableSeeder extends Seeder
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
        factory(Category::class, 5 )->create()->each(function($category) use ($languages,$faker){
            foreach ($languages as $id => $iso) {
                $name = $faker->unique()->word;
                $category->updateTranslationByIso($iso,[
                    'label'          => $name,
                    'slug'          => Category::generateUniqueSlug($name)
                ]);
            }
        });
    }
}
