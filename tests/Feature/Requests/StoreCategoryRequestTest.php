<?php

use App\Models\Category;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\seed;

uses(RefreshDatabase::class);

test('validation fail when missing name', function (){

    seed(PermissionSeeder::class);

    /** @var User $user */
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $response = $this->actingAs($user)-> json('POST', '/categories', [
        'name' => null,
        'description' => 'Test',
        'parent_id'=> null,
    ]);

    $response->assertStatus(422);
    expect($response->json())->toContain('The name field is required.');
});


