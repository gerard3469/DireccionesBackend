<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 5000; $i++) {
            $contact = Contact::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
            ]);

            // Crear teléfonos
            for ($j = 0; $j < 3; $j++) {
                Phone::create([
                    'contact_id' => $contact->id,
                    'phone' => $faker->phoneNumber,
                ]);
            }

            // Crear emails
            for ($j = 0; $j < 2; $j++) {
                Email::create([
                    'contact_id' => $contact->id,
                    'email' => $faker->email,
                ]);
            }

            // Crear direcciones
            for ($j = 0; $j < 2; $j++) {
                Address::create([
                    'contact_id' => $contact->id,
                    'address' => $faker->address,
                    'country' => $faker->country,
                    'zip_code' => $faker->randomNumber(8, true)
                ]);
            }
        }
    }
}
