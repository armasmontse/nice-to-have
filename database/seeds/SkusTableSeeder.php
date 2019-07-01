<?php

use Illuminate\Database\Seeder;

use App\Models\Skus\Sku;
use App\Language;
use App\Photo;

class SkusTableSeeder extends Seeder
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

        factory(Sku::class, 150 )->create()->each(function($sku) use ($languages, $faker, $images){

            $description = $faker->sentence();

            $sku->default = $sku->product->skus()->where(['default' => true])->get()->count() == 0;
            $sku->sku = Sku::generateUniqueSku($sku->product->code, $description);

            $sku->save();

            foreach ($languages as $id => $iso) {
                $sku->updateTranslationByIso($iso,[
                    'description' => $description,
                ]);
            }

            // imagenes
            if ($images->count() > 0) {
                $photo = $images->random(1);
                $use_order_and_class = [ 'use' => "thumbnail" , 'order' => null, 'class' => ''];
                $sku->associateImage($photo, $use_order_and_class);
            }

        });
    }
}
