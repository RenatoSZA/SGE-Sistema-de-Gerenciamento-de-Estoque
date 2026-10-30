<?php

namespace Tests\Feature;

use App\Models\Alert;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

    public function test_employee_can_adjust_stock_and_triggers_low_stock_alert(): void
    {
        $employee = User::factory()->create(['nivel_acesso' => 'Funcionario']);
        $product = Product::create([
            'name' => 'Mouse Sem Fio',
            'brand' => 'Dell',
            'sector' => 'TI',
            'quantity' => 5,
            'min_quantity' => 3,
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

        // Saída válida que deixa o estoque igual ao mínimo (3) -> deve gerar alerta automático
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

        $this->assertTrue(Alert::where('message', 'like', '%Mouse Sem Fio%')->exists());
    }

    public function test_soft_deleting_product_preserves_stock_movement_history(): void
    {
        $admin = User::factory()->create(['nivel_acesso' => 'Admin']);
        $product = Product::create([
            'name' => 'Monitor UltraWide',
            'brand' => 'LG',
            'sector' => 'TI',
            'quantity' => 4,
            'min_quantity' => 2,
        ]);

        $movement = StockMovement::create([
            'product_id' => $product->id,
            'user_id' => $admin->id,
            'type' => 'in',
            'quantity_changed' => 4,
        ]);

        $this->actingAs($admin)->delete(route('products.destroy', $product));

        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $this->assertDatabaseHas('stock_movements', ['id' => $movement->id]);
        $this->assertEquals('Monitor UltraWide', $movement->fresh()->product->name);
    }

    public function test_manager_cannot_create_edit_or_delete_admin_employee(): void
    {
        $manager = User::factory()->create(['nivel_acesso' => 'Gerente']);
        $admin = User::factory()->create(['nivel_acesso' => 'Admin', 'matricula' => 'A20260001']);

        // Tentativa de criar Admin
        $createResponse = $this->actingAs($manager)->post(route('employees.store'), [
            'name' => 'Novo Admin',
            'email' => 'admin.tentativa@sge.com',
            'cpf' => '52998224725',
            'nivel_acesso' => 'Admin',
            'departamento' => 'Diretoria',
            'horario_entrada' => '08:00',
            'horario_saida' => '17:00',
        ]);
        $createResponse->assertSessionHasErrors('nivel_acesso');

        // Tentativa de editar Admin
        $editResponse = $this->actingAs($manager)->get(route('employees.edit', $admin));
        $editResponse->assertRedirect(route('employees.index'));

        // Tentativa de excluir Admin
        $deleteResponse = $this->actingAs($manager)->delete(route('employees.destroy', $admin));
        $deleteResponse->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_reset_employee_password_and_promote_updates_matricula_prefix(): void
    {
        $admin = User::factory()->create(['nivel_acesso' => 'Admin', 'matricula' => 'A20260001']);
        $employee = User::factory()->create([
            'nivel_acesso' => 'Funcionario',
            'matricula' => 'F20260010',
            'cpf' => '52998224725',
        ]);

        // Resetar senha para Mudar@123
        $this->actingAs($admin)->post(route('employees.resetPassword', $employee));
        $this->assertTrue(Hash::check('Mudar@123', $employee->fresh()->password));

        // Promover para Gerente deve atualizar prefixo para G
        $this->actingAs($admin)->put(route('employees.update', $employee), [
            'name' => $employee->name,
            'email' => $employee->email,
            'cpf' => $employee->cpf,
            'nivel_acesso' => 'Gerente',
            'departamento' => 'Gestao',
            'is_active' => true,
        ]);

        $this->assertStringStartsWith('G', $employee->fresh()->matricula);
    }

    public function test_deactivated_logged_in_user_is_immediately_logged_out(): void
    {
        $employee = User::factory()->create(['is_active' => true]);

        $this->actingAs($employee)->get(route('products.index'))->assertOk();

        $employee->update(['is_active' => false]);

        $response = $this->actingAs($employee->fresh())->get(route('products.index'));
        $response->assertRedirect('/');
        $this->assertGuest();
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

    public function test_employee_can_open_and_manager_can_resolve_support_ticket(): void
    {
        $employee = User::factory()->create(['nivel_acesso' => 'Funcionario']);
        $manager = User::factory()->create(['nivel_acesso' => 'Gerente']);

        $this->actingAs($employee)->post(route('support.store'), [
            'subject' => 'estoque',
            'description' => 'Dificuldade ao lancar nota fiscal de entrada.',
        ])->assertRedirect(route('support.index'));

        $ticket = SupportTicket::first();
        $this->assertNotNull($ticket);
        $this->assertEquals('aberto', $ticket->status);

        $this->actingAs($manager)
            ->patch(route('support.resolve', $ticket))
            ->assertRedirect(route('support.index'));

        $this->assertEquals('resolvido', $ticket->fresh()->status);
    }
}
