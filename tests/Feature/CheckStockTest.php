<?php

use App\Models\Item;
use function Pest\Laravel\actingAs;

it('can check stock status with good level', function () {
    $item = Item::factory()->create(['stock' => 100]);

    $response = actingAs($item->user)->get("/api/v1/stock/$item->sku");

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'stock' => $item->stock,
                'reorderLevel' => $item->reorder_level,
                'level' => 'ok'
            ]
        ]);
});

it('can check stock status with low level', function(){
    $item = Item::factory()->create(['stock' => 5]);

    $response = actingAs($item->user)->get("/api/v1/stock/$item->sku");

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'stock' => $item->stock,
                'reorderLevel' => $item->reorder_level,
                'level' => 'low'
            ]
        ]);
});
