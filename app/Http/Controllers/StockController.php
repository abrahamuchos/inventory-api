<?php

namespace App\Http\Controllers;

use App\Events\StockAdded;
use App\Events\StockReduce;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * @param Item    $item
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Item $item, Request $request): ItemResource|\Illuminate\Http\JsonResponse
    {
        $request->validate([
            'qty' => 'required|numeric',
            'action' => 'required|in:add,reduce'
        ]);

        if($request->input('action') === 'add'){
            $item->stock += $request->input('qty');
            $item->save();
            StockAdded::dispatch($item);

        }else if($request->input('action') === 'reduce' && ($request->input('qty') <= $item->stock)){
            $item->stock -= $request->input('qty');
            $item->save();
            StockReduce::dispatch($item);

        } else {

            return response()->json([
                'error' => true,
                'code' => 1001,
                'message' => 'Qty must be greater than stock',
                'details' => "Qty has {$request->input('qty')}  while stock has $item->stock"
            ], 500);
        }


        return new ItemResource($item);
    }

    public function show(Item $item): \Illuminate\Http\JsonResponse
    {
        $status = 'ok';

        if($item->stock <= $item->reorder_level){
            $status = 'low';
        }


        return response()->json([
           'data' => [
               'stock' => $item->stock,
               'reorderLevel' => $item->reorder_level,
               'level' => $status
           ]
        ]);
    }
}
