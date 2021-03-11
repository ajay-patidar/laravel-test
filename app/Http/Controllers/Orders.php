<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

use DataTables;

class Orders extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrders(Request $request){
        $orders = Order::query()->with(['customer']);

        return DataTables::of($orders)
            ->editColumn('created_at', function($order){
                return date('d/m/Y', strtotime($order->created_at));
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $keyword = strtolower($keyword);
                $query->whereRaw("LOWER(DATE_FORMAT(created_at,'%d/%m/%Y')) like ?", ["%$keyword%"]);
            })
            ->editColumn('status', function($order){
                return ucwords($order->status);
            })
            ->addColumn('actions', function ($user) {
                return
                        // View
                        '<a href="'.route('orders.show',[$user->id]).'" class="btn btn-primary">View</a> ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if($order->status=='new'){
            $order->update(['status'=>'processed']);
            activity()->log(auth()->user()->name.' processed the order: '.$order->id);
        }
        return view('orders.view', compact('order'));
    }
}
