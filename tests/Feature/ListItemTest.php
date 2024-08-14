<?php

use App\Models\Item;
use App\Models\User;
use function Pest\Laravel\get;

/**
 * Test to return all items
 */
it('return list of items', function () {
    Item::factory(10)->create();

    $response = get('api/v1/item');


    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'stock', 'sku']],
            'meta' => ['total', 'current_page', 'last_page']
        ])
        ->assertJsonCount(10, 'data');
});

/**
 * Return all items by filter (with low stock)
 */
it('return items low in stock', function () {
    Item::factory(5)->create(['stock' => 15, 'reorder_level' => 5]);
    Item::factory(5)->create(['stock' => 2, 'reorder_level' => 5]);

    $response = get('/api/v1/item?lowStock');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'stock', 'sku']],
            'meta' => ['total', 'current_page', 'last_page']
        ])
        ->assertJsonCount(5, 'data');
});

/**
 * Return all items by filter (name)
 */
it('return items by name', function(){
   Item::factory()->create(['name' => 'Test By filter']);
   Item::factory(10)->create();

    $response = get('/api/v1/item?name[eq]=Test%20By%20filter');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'stock', 'sku']],
            'meta' => ['total', 'current_page', 'last_page']
        ])
        ->assertJsonCount(1, 'data');
});

/**
 * Return all items by filter (sku)
 */
it('return items by sku', function(){
    Item::factory()->create(['sku' => 'SKU123']);
    Item::factory(10)->create();

    $response = get('/api/v1/item?sku[eq]=SKU123');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'stock', 'sku']],
            'meta' => ['total', 'current_page', 'last_page']
        ])
        ->assertJsonCount(1, 'data');
});

/**
 * Return all items by filter (user)
 */
it('return items by user', function(){
    $user = User::factory()->create();
    Item::factory()->create(['user_id' => $user->id]);
    Item::factory(10)->create();

    $response = get("/api/v1/item?userId[eq]={$user->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'stock', 'sku']],
            'meta' => ['total', 'current_page', 'last_page']
        ])
        ->assertJsonCount(1, 'data');
});

/**
 * Return all items by multiple filters (name, sku,user_id, stock)
 */
it('return items by stock', function(){
    $user = User::factory()->create();
    Item::factory()->create([
        'name' => 'Test',
        'sku' => 'SKU123',
        'user_id' => $user->id,
        'stock' => 17
    ]);
    Item::factory(10)->create();

    $response = get("/api/v1/item?userId[eq]={$user->id}&name[eq]=Test&sku[eq]=SKU123&stock[gt]=10&includeUser=true");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'stock', 'sku', 'user']],
            'meta' => ['total', 'current_page', 'last_page']
        ])
        ->assertJsonCount(1, 'data');
});
