<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

use DataTables;

class Customers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customers.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomers(Request $request){
        $customers = Customer::query();

        return DataTables::of($customers)
            ->editColumn('created_at', function($customer){
                return date('d/m/Y', strtotime($customer->created_at));
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $keyword = strtolower($keyword);
                $query->whereRaw("LOWER(DATE_FORMAT(created_at,'%d/%m/%Y')) like ?", ["%$keyword%"]);
            })
            ->make(true);
    }
}
