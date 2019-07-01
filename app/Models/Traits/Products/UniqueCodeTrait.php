<?php namespace App\Models\Traits\Products;

trait UniqueCodeTrait {



    public static function getLettersForNamesSlug($name_slug, $numberOfLettersOfName, $generate_code_length ) {

        $trozos = explode('-', $name_slug);

        $letters = '';

        foreach ($trozos as $key => $trozo) {
            $letters .= substr($trozo, 0, 1);
        }

        $keys = range('a', 'z');

        for ($i = 0; $i < $numberOfLettersOfName; $i++) {
            $letters .= $keys[array_rand($keys)];
        }

        $letters = substr($letters, 0, $numberOfLettersOfName);

        $total_rand_character = $generate_code_length - $numberOfLettersOfName;

        for ($i = 0; $i < $total_rand_character; $i++) {
            $letters .= $keys[array_rand($keys)];
        }

    	return strtolower($letters);
    }


    public static function getBycode($code)
    {
        return static::withTrashed()->where(["code" => $code])->get();
    }

    public static function generateUniqueCode($name, $suffix = "")
    {
        $name = str_slug(trim($name));
        $suffix = str_slug(trim($suffix));

        $not_unique = true;

        $generate_code_length = 10 - strlen($suffix);

        $numberOfLettersOfName = $generate_code_length;

        $iteration_counter = 0;

        while ($not_unique) {

            $code = static::getLettersForNamesSlug($name, $numberOfLettersOfName, $generate_code_length) . $suffix;

            if ( static::getBycode($code)->count() == 0 ) {
                $not_unique = false;
            }

            $iteration_counter++;

            if ($iteration_counter > 1 ) {
                $numberOfLettersOfName = $generate_code_length - 1;
            }

            if ($iteration_counter > 20 ) {
                $numberOfLettersOfName = $generate_code_length - 3;
            }

            if ($iteration_counter > 500 ) {
                $numberOfLettersOfName = $generate_code_length - 4;
            }
        }

        return $code;
    }

}
