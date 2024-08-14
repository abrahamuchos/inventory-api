<?php

use App\Models\Item;
use function Pest\Laravel\get;

/**
 * Test anonymous user can be access
 */
it('guest user can access', function(){
    $item = Item::factory()->create();

    $response = get("api/v1/item/$item->sku");

    $response->assertStatus(200);
});

/**
 * Test to show an item by sku
 */
it('can retrieve an item by sku', function () {
    $item = Item::factory()->create();

    $response = get("api/v1/item/$item->sku");

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $item->id,
                'userId' => $item->user_id,
                'name' => $item->name,
                'stock' => $item->stock,
                'sku' => $item->sku,
                'reorderLevel' => $item->reorder_level,
            ]
        ]);
});

/**
 * Test when item doesn't exist
 */
it('item when not exists', function(){
    $response = get("api/v1/item/000000");

    $response->assertStatus(404);
});
