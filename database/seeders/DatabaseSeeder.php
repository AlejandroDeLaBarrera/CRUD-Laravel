<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Customer;
use App\Models\Hobbie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //creación administrador
        $admin = User::create([
            'email' => 'admin@example.com',
            'status_id' => 1,
            'profile_id' => 1,
            'password' => Hash::make('password'),
        ]);

        //creación hobbies
        $hobbie1 = Hobbie::create(['name' => 'Pintar']);
        $hobbie2 = Hobbie::create(['name' => 'Leer']);
        $hobbie3 = Hobbie::create(['name' => 'Beber']);

        //creación customer -> ascociar hobbies
        $customer = Customer::create([
            'name' => 'Manuel',
            'surname' => 'Sánchez',
            'user_id' => $admin->id,
        ]);

        $customer->hobbies()->attach([$hobbie1->id, $hobbie2->id]);
    }
}
