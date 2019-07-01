<?php

use Illuminate\Database\Seeder;

use App\Models\Products\ProductSection;
use App\Language;

class ProductSectionsTableSeeder extends Seeder
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
        factory(ProductSection::class, 150  )->create()->each(function($product_section) use ($languages,$faker){
            foreach ($languages as $id => $iso) {
                $product_section->updateTranslationByIso($iso,[
                    'title'          => $faker->sentence(),
                    'content'           => $faker->text()
                ]);
            }
        });
    }
}
