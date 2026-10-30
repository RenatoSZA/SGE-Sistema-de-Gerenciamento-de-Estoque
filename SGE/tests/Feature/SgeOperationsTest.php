<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SgeOperationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_product_with_initial_stock_and_movement(): void
    {
        $manager = User::factory()->create(['nivel_acesso' => 'Gerente']);

        $response = $this->actingAs($manager)->post(route('products.store'), [
            'name' => 'Teclado Mecanico',
            'brand' => 'Logitech',
            'sector' => 'TI',
            'quantity' => 10,
            'min_quantity' => 3,
        ]);

        $response->assertRedirect(route('products.index'));

        $product = Product::first();
        $this->assertNotNull($product);
        $this->assertEquals(10, $product->quantity);
        $this->assertEquals(3, $product->min_quantity);

        $movement = StockMovement::first();
        $this->assertNotNull($movement);
        $this->assertEquals($manager->id, $movement->user_id);
        $this->assertEquals(10, $movement->quantity_changed);
        $this->assertEquals('in', $movement->type);
    }

    public function test_employee_can_adjust_stock_and_prevents_negative_balance(): void
    {
        $employee = User::factory()->create(['nivel_acesso' => 'Funcionario']);
        $product = Product::create([
            'name' => 'Mouse Sem Fio',
            'brand' => 'Dell',
            'sector' => 'TI',
            'quantity' => 5,
            'min_quantity' => 2,
        ]);

        // Tentativa de saída maior que o saldo
        $failResponse = $this->actingAs($employee)
            ->from(route('products.index'))
            ->post(route('products.adjustStock', $product), [
                'type' => 'out',
                'quantity' => 10,
            ]);

        $failResponse->assertRedirect(route('products.index'));
        $failResponse->assertSessionHasErrors('quantity');
        $this->assertEquals(5, $product->fresh()->quantity);

        // Saída válida com observação
        $successResponse = $this->actingAs($employee)
            ->from(route('products.index'))
            ->post(route('products.adjustStock', $product), [
                'type' => 'out',
                'quantity' => 2,
                'notes' => 'Retirada para setor financeiro',
            ]);

        $successResponse->assertRedirect(route('products.index'));
        $this->assertEquals(3, $product->fresh()->quantity);
        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $product->id,
            'user_id' => $employee->id,
            'type' => 'out',
            'quantity_changed' => 2,
            'notes' => 'Retirada para setor financeiro',
        ]);
    }

    public function test_manager_cannot_create_admin_employee(): void
    {
        $manager = User::factory()->create(['nivel_acesso' => 'Gerente']);

        $response = $this->actingAs($manager)->post(route('employees.store'), [
            'name' => 'Novo Admin',
            'email' => 'admin.tentativa@sge.com',
            'cpf' => '52998224725',
            'nivel_acesso' => 'Admin',
            'departamento' => 'Diretoria',
            'horario_entrada' => '08:00',
            'horario_saida' => '17:00',
        ]);

        $response->assertSessionHasErrors('nivel_acesso');
        $this->assertDatabaseMissing('users', ['email' => 'admin.tentativa@sge.com']);
    }

    public function test_regular_employee_cannot_create_alerts(): void
    {
        $employee = User::factory()->create(['nivel_acesso' => 'Funcionario']);

        $response = $this->actingAs($employee)->post(route('alerts.store'), [
            'message' => 'Aviso nao autorizado',
            'type' => 'danger',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseMissing('alerts', ['message' => 'Aviso nao autorizado']);
    }

    public function test_employee_can_open_support_ticket(): void
    {
        $employee = User::factory()->create(['nivel_acesso' => 'Funcionario']);

        $response = $this->actingAs($employee)->post(route('support.store'), [
            'subject' => 'estoque',
            'description' => 'Dificuldade ao lancar nota fiscal de entrada.',
        ]);

        $response->assertRedirect(route('support.index'));
        $this->assertDatabaseHas('support_tickets', [
            'user_id' => $employee->id,
            'subject' => 'estoque',
            'status' => 'aberto',
        ]);
    }
}
