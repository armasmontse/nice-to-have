<?php

use Illuminate\Database\Seeder;

class DiscountCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Shop\Discounts\DiscountCode::class, 10)->create();
    }
}