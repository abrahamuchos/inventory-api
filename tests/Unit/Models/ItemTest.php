<?php

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;

test('relationship items with user', function () {
    $item = Item::factory()->create();

    expect($item->user)->toBeInstanceOf(User::class);
});

it('sku is generated', function () {
    $sku = Item::generateSku();

    expect($sku)->toBeString();
});


it('sku database is unique', function (){
    Item::factory(2)->create(['sku' => '123']);

})->throws(UniqueConstraintViolationException::class);
