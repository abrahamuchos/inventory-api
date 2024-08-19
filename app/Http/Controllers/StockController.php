<?php

namespace App\Http\Controllers;

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

        if ($request->input('action') === 'add' || $request->input('action') === 'reduce' && ($request->input('qty') <= $item->stock)) {
            $item->stock = match ($request->input('action')) {
                'add' => $item->stock += $request->input('qty'),
                'reduce' => $item->stock -= $request->input('qty')
            };
            $item->save();

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

}
