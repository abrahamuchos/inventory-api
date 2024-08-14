<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $items = Item::with('user')->get();

        return ItemResource::collection($items);
    }

    /**
     * @param Item $item
     *
     * @return ItemResource
     */
    public function show(Item $item): ItemResource
    {
        return new ItemResource($item);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'userId' => 'required|numeric',
            'name' => 'required|max:60',
            'stock' => 'required|numeric',
            'sku' => 'unique:items,sku|string|max:45',
            'reorderLevel' => 'required|numeric',
        ]);

        $item = Item::create([
            'user_id' => $request->input('userId'),
            'name' => $request->input('name'),
            'stock' => $request->input('stock'),
            'sku' => $request->input('sku') ?? Item::generateSku(),
            'reorder_level' => $request->input('reorderLevel')
        ]);


        return response()->json($item, 201);
    }
}
