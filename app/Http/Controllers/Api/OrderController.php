<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request){
        // Validation 
        $validator = Validator::make($request->all(), [
            'offer_id'      => 'required|exists:offers,id',
            'affiliate_id'  => 'required:exists:users,id',
            'order_id'      => 'required',
            'sales'         => 'required',
            'order_status'  => 'nullable|in:pending,canceled,completed',
        ]);

        // Check Validation Errors
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        // Store order details
        Order::firstOrCreate([
            'order_id'      => $request->order_id,
            'sales'         => $request->sales,
            'order_status'  => $request->order_status ?? 'pending',
            'offer_id'      => $request->offer_id,
            'user_id'       => $request->affiliate_id,

        ]);

        // Return success response
        return response(true, 200)->header('Content-Type', 'application/json');
    }
    
    public function updateStatus(Request $request){
        
        // Validation
        $validator = Validator::make($request->all(), [
            'offer_id'      => 'required|exists:offers,id',
            'order_id'      => 'required',
            'order_status'  => 'required|in:pending,canceled,completed',
        ]);

        // Check Validation
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        // Get Order
        $order = Order::where([
            ['order_id','=',$request->order_id],
            ['offer_id','=',$request->offer_id],
        ])->first();

        // Check if exists
        if(!$order){
            return response()->json(['error' => 'Not Found', 'code' => 404], 404);
        }
        // Update Order status 
        $order->order_status = $request->order_status;
        $order->save();
        // Return success 
        return response(true, 200)->header('Content-Type', 'application/json');
    }
}
