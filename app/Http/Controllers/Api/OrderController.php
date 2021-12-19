<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'offer_id'      => 'required|exists:offers,id',
            'affiliate_id'  => 'required:exists:users,id',
            'order_id'      => 'required',
            'sales'         => 'required',
            'order_status'  => 'nullable|in:pending,canceled,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        Order::firstOrCreate([
            'order_id'      => $request->order_id,
            'sales'         => $request->sales,
            'order_status'  => $request->order_status ?? 'pending',
            'offer_id'      => $request->offer_id,
            'user_id'       => $request->affiliate_id,
        ]); 
        return response(true, 200)->header('Content-Type', 'application/json');
    }
}
