<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('confirm_password_screen_can_be_rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertStatus(200);
});

test('password_can_be_confirmed', function () {
    $user = User::factory()->create([
        'name' => 'Test Name',
        'email' => 'email@test.com',
        'password' => 'PasswordTest',
    ]);

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'PasswordTest',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password_is_not_confirmed_with_invalid_password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});

