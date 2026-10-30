<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'matricula' => 'F' . date('Y') . fake()->unique()->numerify('####'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'cpf' => self::generateValidCpf(),
            'departamento' => 'Operacoes',
            'nivel_acesso' => 'Funcionario',
            'data_admissao' => now()->toDateString(),
            'horario_entrada' => '08:00',
            'horario_saida' => '18:00',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    private static function generateValidCpf(): string
    {
        $n = [];
        for ($i = 0; $i < 9; $i++) {
            $n[$i] = random_int(0, 9);
        }
        if ( count(array_unique($n)) === 1 ) {
            $n[0] = ($n[0] + 1) % 10;
        }
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $n[$c] * (($t + 1) - $c);
            }
            $n[$t] = ((10 * $d) % 11) % 10;
        }
        return implode('', $n);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
