<?php

use App\Models\User;
use function Pest\Laravel\getJson;

test('block anonymous user', function () {
    getJson('/api/v1/logout')
        ->assertUnauthorized();
});


it('can logout user', function () {
    $user = User::factory()->create();

    $token = $user->createToken('basic-token');

    $response = getJson('/api/v1/logout', headers: [
        'Authorization' => 'Bearer ' . $token->plainTextToken
    ]);

    $response->assertStatus(200);
});
