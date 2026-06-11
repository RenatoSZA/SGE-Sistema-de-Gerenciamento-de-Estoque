<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a few fake products
        $product1 = Product::create(['name' => 'Cadeira Ergonomica', 'brand' => 'MaxOffice', 'sector' => 'Mobiliario', 'quantity' => 15]);
        $product2 = Product::create(['name' => 'Notebook Dell', 'brand' => 'Dell', 'sector' => 'TI', 'quantity' => 8]);
        $product3 = Product::create(['name' => 'Monitor 24', 'brand' => 'Samsung', 'sector' => 'TI', 'quantity' => 12]);
        $product4 = Product::create(['name' => 'Mesa de Reuniao', 'brand' => 'WoodTech', 'sector' => 'Mobiliario', 'quantity' => 2]);

        // 2. Create some stock movements (both in and out)
        StockMovement::create(['product_id' => $product1->id, 'type' => 'in', 'quantity_changed' => 10, 'created_at' => Carbon::now()->subMinutes(10)]);
        StockMovement::create(['product_id' => $product2->id, 'type' => 'out', 'quantity_changed' => 2, 'created_at' => Carbon::now()->subMinutes(25)]);
        StockMovement::create(['product_id' => $product3->id, 'type' => 'in', 'quantity_changed' => 5, 'created_at' => Carbon::now()->subHours(1)]);
        StockMovement::create(['product_id' => $product4->id, 'type' => 'out', 'quantity_changed' => 1, 'created_at' => Carbon::now()->subHours(2)]);
        StockMovement::create(['product_id' => $product1->id, 'type' => 'out', 'quantity_changed' => 3, 'created_at' => Carbon::now()->subHours(3)]);
        StockMovement::create(['product_id' => $product2->id, 'type' => 'in', 'quantity_changed' => 8, 'created_at' => Carbon::now()->subHours(4)]);

        // 3. Create a few users with schedules if they don't exist
        $usersToCreate = [
            ['name' => 'João Silva', 'matricula' => 'F20260002', 'horario_entrada' => '08:00', 'horario_saida' => '18:00', 'is_active' => true],
            ['name' => 'Maria Souza', 'matricula' => 'F20260003', 'horario_entrada' => '09:00', 'horario_saida' => '18:00', 'is_active' => false],
            ['name' => 'Carlos Gomes', 'matricula' => 'G20260001', 'horario_entrada' => '07:30', 'horario_saida' => '17:30', 'is_active' => true],
            ['name' => 'Ana Dias', 'matricula' => 'F20260004', 'horario_entrada' => '10:00', 'horario_saida' => '19:00', 'is_active' => true],
            ['name' => 'Lucas Paz', 'matricula' => 'F20260005', 'horario_entrada' => '06:00', 'horario_saida' => '15:00', 'is_active' => false],
        ];

        foreach ($usersToCreate as $u) {
            User::firstOrCreate(
                ['matricula' => $u['matricula']],
                [
                    'name' => $u['name'],
                    'email' => strtolower(explode(' ', $u['name'])[0]) . '@sge.com',
                    'cpf' => mt_rand(10000000000, 99999999999),
                    'departamento' => 'Operacoes',
                    'nivel_acesso' => str_starts_with($u['matricula'], 'G') ? 'Gerente' : 'Funcionario',
                    'password' => Hash::make('password'),
                    'horario_entrada' => $u['horario_entrada'],
                    'horario_saida' => $u['horario_saida'],
                    'is_active' => $u['is_active'],
                    'data_admissao' => Carbon::now()->toDateString()
                ]
            );
        }

        // 4. Create Alerts
        Alert::create(['message' => 'Produto Cadeira Ergonomica está com estoque baixo.', 'type' => 'warning']);
        Alert::create(['message' => 'Funcionário Lucas Paz está atrasado.', 'type' => 'danger']);
        Alert::create(['message' => 'Encomenda Samsung do setor TI chegou. Dirijam-se a area de descarregamento.', 'type' => 'info']);
    }
}
