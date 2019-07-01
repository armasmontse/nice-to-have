<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AddressTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PhotosTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SubcategoriesTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(SubtypesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductSectionsTableSeeder::class);
        $this->call(SkusTableSeeder::class);
        $this->call(CardsTableSeeder::class);
        $this->call(BankAccountsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(DiscountCodesTableSeeder::class);
        $this->call(BagsTableSeeder::class);
    }
}
