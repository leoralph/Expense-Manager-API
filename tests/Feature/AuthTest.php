<?php
use App\Models\User;

it('should authenticate a user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);

    $this->assertAuthenticated();
});

it('should not authenticate a user with invalid credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401);

    $this->assertGuest();
});

it('should logout a user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(200);

    // $this->assertGuest();
});
