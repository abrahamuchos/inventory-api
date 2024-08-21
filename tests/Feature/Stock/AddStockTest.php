<?php

use App\Events\StockAdded;
use App\Events\StockReduce;
use App\Models\Item;
use \Illuminate\Support\Facades\Event;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('block to anonymous users', function (){
    $item = Item::factory()->create();
    postJson("api/v1/stock/$item->sku", [])
        ->assertUnauthorized();
});

/**
 * Test validate required request field
 */
it('validate required request fields', function (){
    $item = Item::factory()->create();

    $response = actingAs($item->user)->postJson("api/v1/stock/$item->sku", [
        'action' => 'null',
        'sku' => $item->sku,
        'qty' => null
    ]);

    $response->assertStatus(422);
});

/**
 * Test if stock can add
 */
it('can add stock by sku', function () {
    Event::fake();
    $item = Item::factory()->create();

    $response = actingAs($item->user)->postJson("api/v1/stock/$item->sku", [
       'action' => 'add',
       'sku' => $item->sku,
       'qty' => 10
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
       'data' => ['id', 'sku', 'stock']
    ]);
    assertDatabaseHas('items', [
       'sku' => $item->sku,
       'stock' => $item->stock + 10
    ]);
    Event::assertDispatched(StockAdded::class);
});

it('can reduce fewer fields than there are', function () {
    $item = Item::factory()->create(['stock' => 10]);

    $response = actingAs($item->user)->postJson("api/v1/stock/$item->sku", [
        'action' => 'reduce',
        'sku' => $item->sku,
        'qty' => 100
    ]);

    $response->assertStatus(500)
        ->assertJsonStructure(['error','code']);
});

/**
 * Test reduce stock
 */
it('can reduce stock by sku', function () {
    Event::fake();
    $item = Item::factory()->create(['stock' => 100]);

    $response = actingAs($item->user)->postJson("api/v1/stock/$item->sku", [
        'action' => 'reduce',
        'sku' => $item->sku,
        'qty' => 5
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => ['id', 'sku', 'stock']
    ]);
    assertDatabaseHas('items', [
        'sku' => $item->sku,
        'stock' => $item->stock - 5
    ]);
    Event::assertDispatched(StockReduce::class);
});

