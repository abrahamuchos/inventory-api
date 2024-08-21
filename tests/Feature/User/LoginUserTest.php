<?php

use App\Models\User;
use function Pest\Laravel\postJson;

it('validate required request fields', function () {
    postJson('/api/v1/login', [
        'email' => null,
        'password' => null
    ])->assertStatus(422);
});

it('can existing user login', function () {
    $user = User::factory()->create();

    $response = postJson('api/v1/login', [
        'email' => $user->email,
        'password' => 'password'
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['token', 'expiredAt']
        ]);
});

it('can not existing user login', function () {
    postJson('api/v1/login', [
        'email' => 'not.exists.user@mail.com',
        'password' => 'password'
    ])
        ->assertStatus(401)
        ->assertJson([
            'error' => true,
            'message' => 'Email or password are invalid. Try Again.',
            'code' => 10000,
            'details' => 'Email or password are invalid. Try Again'
        ]);
});
