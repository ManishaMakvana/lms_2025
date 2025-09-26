<?php

use App\Models\ActivityChecklist;
use App\Models\KitActivationCode;
use App\Models\TinkeringModule;
use App\Models\TinkeringModuleSubActivity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can redeem valid kit code', function () {
    // Create test data
    $user = User::factory()->create(['role' => 'student']);
    $module = TinkeringModule::factory()->create();
    $kitCode = KitActivationCode::factory()->create([
        'code' => 'TE-000001',
        'status' => 'unused',
        'module_id' => $module->id,
    ]);

    // Act as the user
    $this->actingAs($user);

    // Attempt to redeem the code
    $response = $this->post("/modules/{$module->id}/redeem-code", [
        'code' => 'TE-000001'
    ]);

    // Assertions
    $response->assertRedirect();
    $response->assertSessionHas('success');
    
    // Check that the code is marked as used
    $this->assertDatabaseHas('kit_activation_codes', [
        'code' => 'TE-000001',
        'status' => 'used',
        'used_by' => $user->id,
    ]);

    // Check that user has access to the module
    $this->assertDatabaseHas('module_user', [
        'user_id' => $user->id,
        'module_id' => $module->id,
    ]);
});

test('user cannot redeem used kit code', function () {
    // Create test data
    $user = User::factory()->create(['role' => 'student']);
    $module = TinkeringModule::factory()->create();
    $kitCode = KitActivationCode::factory()->create([
        'code' => 'TE-000002',
        'status' => 'used',
        'module_id' => $module->id,
    ]);

    // Act as the user
    $this->actingAs($user);

    // Attempt to redeem the used code
    $response = $this->post("/modules/{$module->id}/redeem-code", [
        'code' => 'TE-000002'
    ]);

    // Assertions
    $response->assertSessionHasErrors(['code']);
    $this->assertDatabaseMissing('module_user', [
        'user_id' => $user->id,
        'module_id' => $module->id,
    ]);
});

test('user cannot redeem invalid kit code', function () {
    // Create test data
    $user = User::factory()->create(['role' => 'student']);
    $module = TinkeringModule::factory()->create();

    // Act as the user
    $this->actingAs($user);

    // Attempt to redeem invalid code
    $response = $this->post("/modules/{$module->id}/redeem-code", [
        'code' => 'INVALID-CODE'
    ]);

    // Assertions
    $response->assertSessionHasErrors(['code']);
    $this->assertDatabaseMissing('module_user', [
        'user_id' => $user->id,
        'module_id' => $module->id,
    ]);
});

test('admin can generate kit codes', function () {
    // Create admin user
    $admin = User::factory()->create(['role' => 'admin']);

    // Act as admin
    $this->actingAs($admin);

    // Generate codes via command
    $this->artisan('tinkering:generate-codes', [
        'prefix' => 'TE',
        'quantity' => 5
    ])->assertExitCode(0);

    // Check that codes were created
    $this->assertDatabaseCount('kit_activation_codes', 5);
    $this->assertDatabaseHas('kit_activation_codes', [
        'code' => 'TE-000001',
        'status' => 'unused'
    ]);
});
