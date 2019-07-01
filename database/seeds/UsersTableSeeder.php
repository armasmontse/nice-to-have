<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = App\Role::all();
        $roles_total = $roles->count();
        $address = App\Models\Address\Address::all();
        $address_total = $roles->count();
        factory(App\User::class, 100 )->create()->each(function($user) use ($roles,$roles_total, $address, $address_total){
            if ( mt_rand(1, 10000) <= 1000 ) {

                $filter_roles = $roles->random(mt_rand(1,$roles_total)) ;

                if (get_class($filter_roles) == "App\Role") {
                    $filter_roles = collect([ $filter_roles ]);
                }

                foreach ( $filter_roles  as $role) {
                    $user->assignRole($role);
                }
            }

            $address = $address->random(mt_rand(1,$address_total));

            $user->addresses()->attach($address, ['use' => 'main']);
        });
    }
}
