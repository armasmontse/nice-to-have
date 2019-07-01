<?php

use Illuminate\Database\Seeder;

use App\Models\Products\Product;
use App\Models\Products\Subcategory;
use App\Models\Events\Subtype;
use App\Language;
use App\Publish;

use App\Photo;

class ProductsTableSeeder extends Seeder
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
        $photos = Photo::get();
        factory(Product::class, 50)->create()->each(function($product) use ($languages,$faker,$photos){

            // idiomas
            foreach ($languages as $id => $iso) {
                $title = $faker->sentence();
                $product->updateTranslationByIso($iso,[
                    'slug'           => Product::generateUniqueSlug($title),
                    'description'    => $faker->text(),
                    'title'          => $title,
                ]);
            }

            $product->code = Product::generateUniqueCode($title, $product->provider->sku_suffix);

            $product->save();

            // relacionados
            $products = getRandomElements(Product::get());

            foreach ($products as $related_product) {
                if ($product->id != $related_product->id) {
                    $product->productsRelated()->attach($related_product);
                }
            }

            // imagens
            if ($photos->count() >= 4) {

                $filter_photos = $photos->random(4);

                foreach ($filter_photos as $key => $photo) {
                    $use_order_and_class = [ 'use' => "details" , 'order' => $key, 'class' => ''];
                    $product->associateImage($photo, $use_order_and_class);
                }
            }

            // subcategorias
            $subcategories = getRandomElements(Subcategory::get());

            foreach ($subcategories as $key => $subcategory) {
                $product->subcategories()->save($subcategory);
            }

            // subtipos
            $subtypes = getRandomElements(Subtype::get());

            foreach ($subtypes as $key => $subtype) {
                $product->subtypes()->save($subtype);
            }
        });
    }
}
