<?php

use App\Models\Item;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patchJson;

/**
 * Test anonymous users with protect routes
 */
it('block anonymous user', function () {
    patchJson('/api/v1/item/1', [
        'name' => 'Test Item',
        'stock' => 10,
        'sku' => 'SKU123',
        'reorderLevel' => 5,
    ])->assertUnauthorized();
});

/**
 * Test update item by method patch
 */
it('can update (patch) item', function (){
    $item = Item::factory()->create(['stock' => 10]);

    $response = actingAs($item->user)
        ->patchJson("/api/v1/item/{$item->id}", [
            'stock' => 11,
        ]);

    $response->assertStatus(201);
    assertDatabaseHas('items', ['id' => $item->id, 'stock' => 11 ]);

});

/**
 * Test update item by method put
 */
it('can update (put) items', function (){
    $item = Item::factory()->create();

    $response = actingAs($item->user)
        ->putJson("/api/v1/item/{$item->id}", [
            'userId' => $item->user->id,
            'name' => 'Test Item',
            'stock' => 11,
            'sku' => 'SKU1234',
            'reorderLevel' => 6,
        ]);

    $response->assertStatus(201);
    assertDatabaseHas('items', [
        'id' => $item->id,
        'user_id' => $item->user->id,
        'name' => 'Test Item',
        'stock' => 11,
        'sku' => 'SKU1234',
        'reorder_level' => 6,
    ]);

});
