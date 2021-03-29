<?php

namespace Database\Factories;

use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PessoaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pessoa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'data_nasc' => $this->faker->date(),
            'endereco' => $this->faker->address,
            'user_id' => 1,
        ];

    }
}
