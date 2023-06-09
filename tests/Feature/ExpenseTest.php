<?php
use App\Models\User;

it('should list paginated expenses', function () {
    $user = User::factory()->create();

    $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->getJson('/api/expense?page=1&per_page=10');

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'value',
                'description',
                'date',
                'created_at',
            ]
        ],
        'links' => [
            'first',
            'last',
            'prev',
            'next'
        ],
        'meta' => [
            'current_page',
            'from',
            'last_page',
            'path',
            'per_page',
            'to',
            'total'
        ]
    ]);
});

it('should create an expense', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(201);
});

it('should not create an expense with invalid value', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => 'invalid-value',
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => -1,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => 2000000001,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);
});

it('should not create an expense with invalid date', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => 100,
        'description' => 'Test expense',
        'date' => 'invalid-date'
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->addDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);
});

it('should not create an expense with invalid description', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => 100,
        'description' => '',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('/api/expense', [
        'value' => 100,
        'description' => str_repeat('a', 192),
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);
});

it('should not create an expense with invalid authentication', function () {
    $response = $this->postJson('/api/expense', [
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(401);
});

it('should update an expense', function () {
    $user = User::factory()->create();

    $expense = $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 200,
        'description' => 'Test expense updated',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(200);
});

it('should not update an expense with invalid value', function () {
    $user = User::factory()->create();

    $expense = $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 'invalid-value',
        'description' => 'Test expense updated',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => -1,
        'description' => 'Test expense updated',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 2000000001,
        'description' => 'Test expense updated',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);
});

it('should not update an expense with invalid date', function () {
    $user = User::factory()->create();

    $expense = $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 200,
        'description' => 'Test expense updated',
        'date' => 'invalid-date'
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 200,
        'description' => 'Test expense updated',
        'date' => now()->addDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);
});

it('should not update an expense with invalid description', function () {
    $user = User::factory()->create();

    $expense = $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 200,
        'description' => '',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 200,
        'description' => str_repeat('a', 192),
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(422);
});

it('should not update an expense with invalid authentication', function () {
    $user = User::factory()->create();

    $expense = $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->putJson("/api/expense/{$expense->id}", [
        'value' => 200,
        'description' => 'Test expense updated',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(401);
});

it('should not update an expense from another user', function () {
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();

    $expense = $anotherUser->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->putJson("/api/expense/{$expense->id}", [
        'value' => 200,
        'description' => 'Test expense updated',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response->assertStatus(403);
});

it('should delete an expense', function () {
    $user = User::factory()->create();

    $expense = $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->deleteJson("/api/expense/{$expense->id}");

    $response->assertStatus(200);
});

it('should not delete an expense with invalid authentication', function () {
    $user = User::factory()->create();

    $expense = $user->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->deleteJson("/api/expense/{$expense->id}");

    $response->assertStatus(401);
});

it('should not delete an expense from another user', function () {
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();

    $expense = $anotherUser->expenses()->create([
        'value' => 100,
        'description' => 'Test expense',
        'date' => now()->subDay()->format('Y-m-d')
    ]);

    $response = $this->actingAs($user)->deleteJson("/api/expense/{$expense->id}");

    $response->assertStatus(403);
});

it('should not delete an expense with invalid id', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->deleteJson("/api/expense/invalid-id");

    $response->assertStatus(404);
});
