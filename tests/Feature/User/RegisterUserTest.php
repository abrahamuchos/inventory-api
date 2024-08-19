<?php

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

it('validate required request fields', function(){
   $response = postJson('api/v1/register', [
       'name' => null,
       'email' => null,
       'password' => null,
       'password_confirmation' => null,
   ]);

   $response->assertStatus(422);
});

it('can create a new user', function(){
    $response = postJson('/api/v1/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);
});
