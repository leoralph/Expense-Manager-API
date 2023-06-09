<?php
use App\Models\User;

it('should create a user', function () {
    $response = $this->postJson('/api/user', [
        'name' => 'John Doe',
        'email' => fake()->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);
});

it('should not create a user with invalid name', function () {
    $response = $this->postJson('/api/user', [
        'name' => str_repeat('a', 256),
        'email' => 'invalid-email',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);

    $response = $this->postJson('/api/user', [
        'name' => '',
        'email' => 'invalid-email',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

it('should not create a user with invalid email', function () {
    $response = $this->postJson('/api/user', [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);

    $anotherUser = User::factory()->create();

    $response = $this->postJson('/api/user', [
        'name' => 'John Doe',
        'email' => $anotherUser->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});

it('should not create a user with invalid password', function () {
    $response = $this->postJson('/api/user', [
        'name' => 'John Doe',
        'email' => fake()->email,
        'password' => 'password',
        'password_confirmation' => 'invalid-password',
    ]);

    $response->assertStatus(422);

    $response = $this->postJson('/api/user', [
        'name' => 'John Doe',
        'email' => fake()->email,
        'password' => 'short',
        'password_confirmation' => 'short',
    ]);

    $response->assertStatus(422);
});

it('should update a user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
        'name' => 'John Doe',
        'email' => fake()->email,
    ]);

    $response->assertStatus(200);
});

it('should not update a user with invalid name', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
        'name' => str_repeat('a', 256),
        'email' => fake()->email,
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
        'name' => '',
        'email' => fake()->email,
    ]);

    $response->assertStatus(422);
});

it('should not update a user with invalid email', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
        'name' => 'John Doe',
        'email' => 'invalid-email',
    ]);

    $response->assertStatus(422);

    $anotherUser = User::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
        'name' => 'John Doe',
        'email' => $anotherUser->email,
    ]);

    $response->assertStatus(422);
});

it('should not update a user with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
        'name' => 'John Doe',
        'email' => fake()->email,
        'password' => 'password',
        'password_confirmation' => 'invalid-password',
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
        'name' => 'John Doe',
        'email' => fake()->email,
        'password' => 'short',
        'password_confirmation' => 'short',
    ]);

    $response->assertStatus(422);
});

it('should not update a user with invalid authentication', function () {
    $user = User::factory()->create();

    $response = $this->putJson("/api/user/{$user->id}", [
        'name' => 'John Doe',
        'email' => fake()->email,
    ]);

    $response->assertStatus(401);
});

it('should not update another user', function () {
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/user/{$anotherUser->id}", [
        'name' => 'John Doe',
        'email' => fake()->email,
    ]);

    $response->assertStatus(403);
});
