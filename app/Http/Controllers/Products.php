<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use DataTables;

class Products extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts(Request $request){
        $products = Product::query();

        return DataTables::of($products)
            ->editColumn('in_stock', function ($product) {
                if($product->in_stock == TRUE ){
                    return "<a href='".route('products.status',$product)."'><span class='badge badge-success'>Yes</span></a>";
                }else{
                    return "<a href='".route('products.status',$product)."'><span class='badge badge-danger'>No</span></a>";
                }
            })
            ->rawColumns(['in_stock'])
            ->make(true);
    }

    /**
     * Change status the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, Product $product){
        if (isset($product->in_stock) && $product->in_stock==FALSE) {
            $product->update(['in_stock'=>TRUE]);
        }else{
            $product->update(['in_stock'=>FALSE]);
        }
        $request->session()->flash('status', 'Record successfully updated.');
        return redirect()->route('products.index');
    }
}
