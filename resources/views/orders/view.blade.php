@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('orders.index') }}" class="btn btn-danger float-right">Back</a>
                    {{ __('View Order') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Order Date</th>
                                <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Customer Name</th>
                                <td>{{ $order->customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>{{ $order->total_amount }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucwords($order->status) }}</td>
                            </tr>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table" id="orders">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($order->orderItems->count())
                            @foreach($order->orderItems as $orderItem)
                            <tr>
                                <td>{{ $orderItem->product->name }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')

@endsection

@section('scripts')

@endsection
