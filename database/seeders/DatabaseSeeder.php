<?php

namespace Database\Seeders;

use App\Models\TipoContato;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $faker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        TipoContato::create(['nome' => 'Email']);
        TipoContato::create(['nome' => 'Whatsapp']);


        //$this->call([PessoaSeeder::class]);
    }
}
