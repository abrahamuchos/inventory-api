<?php

use App\Models\Item;
use function Pest\Laravel\get;

it('return list of items', function(){
    $items = Item::factory(10)->create();

   $response = get('api/v1/item');


   $response->assertStatus(200)
       ->assertJsonStructure([
           'data' => [
               '*' => ['id', 'name', 'stock', 'sku']
           ]
       ]);
});
