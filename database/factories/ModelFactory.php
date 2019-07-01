<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/**
 * factory de usuarios
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    return [
        'name'              => App\User::createUniqueUsername($firstName,$lastName),
        'first_name'        => $firstName,
        'last_name'         => $lastName,
        'email'             => $faker->unique()->email,
        'password'          => bcrypt(str_random(10)),
        'remember_token'    => str_random(10),
        'active'            => mt_rand(1, 10000) <= 1/10 * 10000 //rand(1,10) <= 1 ? 0 : 1
    ];
});

/**
 * factory photos
 */
$factory->define(App\Photo::class, function ($faker) use ($factory) {
    return [
            'filename' => $faker->unique()->slug
        ,   'type'      => ""
    ];
});

/**
 * factory de providers
 */
$factory->define(App\Models\Products\Provider::class, function ($faker) use ($factory) {
    $name = $faker->unique()->sentence(2);
    $slug = App\Models\Products\Provider::generateUniqueSlug($name);
    return [
        'sku_suffix' => App\Models\Products\Provider::generateUniqueSkuSuffixBySlug($slug),
        'slug'       => $slug,
        'label'      => $name
    ];
});

/**
 * factory de categories
 */
$factory->define( App\Models\Products\Category::class, function (Faker\Generator $faker) {
    return [
        "order" => $faker->unique()->randomNumber(2)
    ];
});

/**
 * factory de sub categories
 */
$factory->define( App\Models\Products\Subcategory::class, function (Faker\Generator $faker) {
    $category = App\Models\Products\Category::get()->random(1);
    return [
        'category_id'   => $category->id,
        "order"         => $faker->unique()->randomNumber(2)
    ];
});

/**
 * factory de typos de evento
 */
$factory->define( App\Models\Events\Type::class, function (Faker\Generator $faker) {
    return [
        "order" => $faker->unique()->randomNumber(2)
    ];
});

/**
 * factory de sub typos de evento
 */
$factory->define( App\Models\Events\Subtype::class, function (Faker\Generator $faker){
    $type = App\Models\Events\Type::get()->random(1);
    return [
        'type_id'   => $type->id,
        "order"     => $faker->unique()->randomNumber(2)
    ];
});

/**
 * factory de products
 */
$factory->define( App\Models\Products\Product::class, function (Faker\Generator $faker){
    $provider = App\Models\Products\Provider::get()->random(1);
	$publish = App\Publish::get()->random(1);
    return [
        'provider_id' => $provider->id,
        "code"        => str_random(6) . $provider->sku_suffix,
		'publish_id'  => $publish->id,
		'publish_at'  => $faker->dateTimeBetween("-1 month"),
    ];
});

/**
 * factory de products sectionss
 */
$factory->define( App\Models\Products\ProductSection::class, function (Faker\Generator $faker){
    $product = App\Models\Products\Product::get()->random(1);
    return [
        'product_id'   => $product->id,
        "order"        => $faker->unique()->randomNumber(3)
    ];
});

/**
 * factory de skus
 */
$factory->define( App\Models\Skus\Sku::class, function (Faker\Generator $faker){
    $product = App\Models\Products\Product::with("skus")->get()->random(1);
    return [
        'product_id'            => $product->id,
        'sku'                   => App\Models\Skus\Sku::generateUniqueSku($product->code, $faker->unique()->sentence()),
        'price'                 => rand(0,100000)/100,
        'local_shipping_rate'   => rand(0,100000)/100,
        'national_shipping_rate'=> rand(0,100000)/100,
        'discount'              => rand(0,100),
        'default'               => false ,
    ];
});

/**
 * factory de addresses
 */
$countries = App\Models\Address\Country::all();

$factory->define(App\Models\Address\Address::class, function (Faker\Generator $faker) use ($countries){

    $country = $countries->random(1);

    return [
        'country_id'    => $country->id,
        'contact_name'  => $faker->name,
        'phone'         => $faker->phoneNumber,
        'references'    => $faker->secondaryAddress,
        'street1'       => $faker->streetName ,
        'street2'       => $faker->buildingNumber ,
        'street3'       => mt_rand(1, 10000) <= 1/4 * 10000 ? $faker->streetAddress  : '',
        'city'          => $faker->city ,
        'state'         => $faker->state ,
        'zip'           => $faker->postcode,
		'email'         => $faker->email
    ];
});

/**
 * factory de cards
 */

$factory->define(App\Models\Users\Card::class, function (Faker\Generator $faker){

    $user = App\User::get()->random(1);

    return [
        'number'            => rand(1000,9999),
        'type'              => substr($faker->creditCardType, 0, 1),
        'conekta_token'     => 'tok_test_visa_4242',//str_random(15),
        'user_id'           => $user->id
    ];
});

/**
 * factory de bank accounts
 */

$banks = [
    'BBVA Bancomer',
    'Santander Mexico',
    'Banamex',
    'Banorte',
    'HSBC Mexico',
    'Inbursa',
    'Scotiabank Mexico',
    'Bancomext',
    'Interacciones',
    'Banco del Bajio',
    'Afirme',
    'Banco Azteca',
    'Bank of America',
    'J.P. Morgan',
    'BanRegio',
    'Multiva',
    'Invex',
    'Monex',
    'Barclays Mexico',
    'Mifel',
    'Ve por Mas',
    'Bancoppel',
    'Deutsche Bank Mexico',
    'Credit Suisse Mexico',
    'CIBanco',
];

$factory->define(App\Models\Users\BankAccount::class, function (Faker\Generator $faker) use ($banks){

    $user = App\User::get()->random(1);

    return [
        'CLABE'        	=> rand( pow(10, 18) - 1, pow(10, 18 - 1)),
        'name'         	=> $faker->name,
        'bank'         	=> $banks[array_rand($banks)],
        'user_id'      	=> $user->id,
		'account_number'=> $faker->bankAccountNumber,
		'branch'		=> $faker->streetName
    ];
});

$factory->define(App\Models\Events\Event::class, function (Faker\Generator $faker){

    $user = App\User::get()->random(1);
    $pair_or_single = rand(0,1);

    if ($pair_or_single) {

        $first_name = $faker->firstName;
        $last_name = $faker->lastName;
        $full_name = $first_name . ' ' . $last_name;

        $feted_names = $full_name;
        $pre_key = substr($full_name, 0, 6);

    }else {

        $first_name_1 = $faker->firstNameMale;
        $last_name_1 = $faker->lastName;
        $full_name_1 = $first_name_1 . ' ' . $last_name_1;

        $first_name_2 = $faker->firstNameFemale;
        $last_name_2 = $faker->lastName;
        $full_name_2 = $first_name_2 . ' ' . $last_name_2;

        $feted_names = $full_name_1 . ' and ' . $full_name_2;
    }

    $description = $faker->paragraph;
    $date = $faker->dateTimeInInterval('-6 months', '+12 months');

    $timezone = $faker->timezone;
    $event_status = App\Models\Events\EventStatus::get()->random(1);
    $event_type= App\Models\Events\Type::get()->random(1);

    return [
        "user_id"           => $user->id,
        "key"               => App\Models\Events\Event::generateUniqueKey($event_type->translation()->label . ' ' . $feted_names, $date->format('d-m-y') ),
        "name"              => $event_type->translation()->label . ' ' . $feted_names,
        "slug"              => App\Models\Events\Event::generateUniqueSlug($feted_names),
        "feted_names"       => $feted_names,
        "description"       => $description,
        "date"              => $date,
        "timezone"          => $timezone,
        "accept"            => true,
        "exclusive"         => true,
        "event_status_id"   => $event_status->id,
        "typeable_id"       => $event_type->id,
        "typeable_type"     => get_class($event_type),
    ];
});

$factory->define(App\Models\Shop\Bag::class, function (Faker\Generator $faker) use ($banks){

    $type = App\Models\Shop\BagType::get()->where('special', false)->random(1);

    if ($type->event) {

        $event =  App\Models\Events\Event::whereDate('date', '<', date('Y-m-d'))->whereHas('eventStatus', function($query){
            return $query->where('publish', true);
        })->get()->random(1);

        $status = App\Models\Shop\BagStatus::where('slug', 'activo')
        ->orWhere('slug', 'pago-pendiente')
        ->orWhere('slug', 'pagado')
        ->orWhere('slug', 'cancelado')
        ->get()
        ->random(1);

    }else {
        $status = App\Models\Shop\BagStatus::where('slug', '<>', 'expirado')->get()->random(1);
    }

    return [
        'key'           => App\Models\Shop\Bag::generateUniqueKey(),
        'bag_status_id' => $status->id,
        'bag_type_id'   => $type->id,
        "event_id"      => ($type->event && $event) ? $event->id : null ,
    ];
});

$factory->define(App\Models\Shop\Discounts\DiscountCode::class, function (Faker\Generator $faker)
{
    $discount_codes_types = App\Models\Shop\Discounts\DiscountCodeType::get();
    $discount_code_type = $discount_codes_types->random(1);

    return [
        'code'                  => str_random(15),
        'description'           => $faker->paragraph,
        'initial_date'          => $faker->dateTimeInInterval('-2 months', '-1 month'),
        'end_date'              => $faker->dateTimeInInterval('+1 month', '+2 months'),
        'value'                 => $discount_code_type->percent ? rand(1, 100) : ($discount_code_type->value ? rand(1, 1000) : null),
        'unique'                => rand(0, 1),
        'discount_code_type_id' => $discount_code_type->id
    ];
});
