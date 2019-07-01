<?php
namespace App\Models\Traits\Skus;

trait UniqueSkuTrait {



    public static function generateLettersForDescription($description, $numberOfLettersOfName, $generate_code_length) {

        $trozos = explode('-', $description);

        $letters = '';

        foreach ($trozos as $key => $trozo) {
            $letters .= substr($trozo, 0, 1);
        }

        $keys = range('a', 'z');

        for ($i = 0; $i < $numberOfLettersOfName; $i++) {
            $letters .= $keys[array_rand($keys)];
        }

        $letters =  substr($letters, 0, $numberOfLettersOfName);

        $total_rand_character = $generate_code_length - $numberOfLettersOfName;

        for ($i = 0; $i < $total_rand_character ; $i++) {
            $letters .= $keys[array_rand($keys)];
        }

    	return strtolower($letters);
    }



    public static function getBySku($sku)
    {
        return static::where(["sku" => $sku])->get();
    }

    public static function generateUniqueSku($product_code, $description)
    {
        $product_code = str_slug(trim($product_code));
        $description = str_slug(trim($description));

        $not_unique = true;

        $generate_sku_length = 18 - strlen($product_code);

        $number_of_the_letters_for_generate = $generate_sku_length;

        $iteration_counter = 0;

        while ($not_unique) {

            $sku = static::generateLettersForDescription($description, $number_of_the_letters_for_generate, $generate_sku_length) . $product_code;

            if ( static::getBySku($sku)->count() == 0 ) {
                $not_unique = false;
            }

            $iteration_counter++;

            if ($iteration_counter > 1 ) {
                $number_of_the_letters_for_generate = $generate_sku_length - 1;
            }

            if ($iteration_counter > 20 ) {
                $number_of_the_letters_for_generate = $generate_sku_length - 3;
            }

            if ($iteration_counter > 500 ) {
                $number_of_the_letters_for_generate = $generate_sku_length - 4;
            }
        }

        return $sku;
    }

}
