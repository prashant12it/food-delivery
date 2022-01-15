<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class OrdersController extends Controller
{
    public function index(){
        View::share('title', 'Orders List');
        $data = Order::join('users as usr','orders.user_id','usr.id')->select('orders.*','usr.email')
            ->orderBy('orders.id','Desc')->paginate(5);
        return view('admin.orders',compact('data'));
    }

    public function changeStatus(Request $request){
            $validator = Validator::make($request->all(),[
                'order_id' => 'required|numeric|min:1',
                'status' => 'numeric|in:0,1,2,3,4',
            ],[
               'order_id.required'=> 'Invalid request',
               'order_id.numeric'=> 'Invalid request',
               'order_id.min'=> 'Invalid request',
               'status.numeric'=> 'Valid status required',
               'status.in'=> 'Valid status required',
            ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $orderDet = Order::find($request->order_id);
        $orderDet->status = $request->status;
        $orderDet->save();
        return response()->json(['message'=>'Order status changed successfully','code'=>200]);
    }

    public function order_details($id){
        View::share('title', 'Orders Details');
        $data = array();
        $orderDet = Order::join('users as usr','orders.user_id','usr.id')
            ->where('orders.id',$id)
            ->select('orders.*','usr.email')->get();
        if(!empty($orderDet) && isset($orderDet[0]->id) && $orderDet[0]->id>0){
            $data = $orderDet[0];
        }
        $orderProducts = OrderProducts::join('orders as ord','order_products.order_id','ord.id')
            ->join('products as prd','order_products.product_id','prd.id')
            ->where('ord.id',$id)
            ->get(['order_products.quantity','order_products.price','prd.product_name','prd.id']);
        return view('admin.order-details',compact('data','orderProducts','id'));
    }
}
