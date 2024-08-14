<?php

use App\Models\Item;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

/**
 * Test anonymous users with protect routes
 */
it('block anonymous users', function () {
    postJson('/api/v1/item', [
        'name' => 'Test Item',
        'stock' => 10,
        'sku' => 'SKU123',
        'reorderLevel' => 5,
    ])->assertUnauthorized();
});


/**
 * Test create inventory item with custom sku
 */
test('can create an inventory item with custom sku', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson('/api/v1/item', [
        'name' => 'Test Item',
        'stock' => 10,
        'sku' => 'SKU123',
        'reorderLevel' => 5,
        'userId' => $user->id
    ]);

    $response->assertStatus(201);
    assertDatabaseHas('items', [
        'name' => 'Test Item',
        'stock' => 10,
        'sku' => 'SKU123',
        'reorder_level' => 5,
        'user_id' => $user->id
    ]);
});

/**
 * Test create inventory item with sku auto generate
 */
test('can create an inventory item with sku auto generate', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson('/api/v1/item', [
        'name' => 'Test Item',
        'stock' => 10,
        'reorderLevel' => 5,
        'userId' => $user->id
    ]);

    $response->assertStatus(201);
    assertDatabaseHas('items', [
        'name' => 'Test Item',
        'stock' => 10,
        'reorder_level' => 5,
        'user_id' => $user->id
    ]);
});





