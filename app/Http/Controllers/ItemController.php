<?php

namespace App\Http\Controllers;

use App\Filters\ItemFilter;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemController extends Controller
{
    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filter = new ItemFilter();
        $queryItems = $filter->transform($request);
        $items = Item::where($queryItems);

        if($request->query('lowStock')){
            $items = Item::whereColumn('stock', '<', 'reorder_level');
        }

        if($request->query('includeUser')){
            $items = $items->with('user');
        }


        return ItemResource::collection($items->paginate()->appends($request->query()));
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

    /**
     * @param UpdateItemRequest $request
     * @param Item    $item
     *
     * @return JsonResponse
     */
    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $item->update($request->all());

        return response()->json([], 201);
    }

}
