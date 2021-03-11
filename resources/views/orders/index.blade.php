@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Orders') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table" id="orders">
                        <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="{{ asset('js/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    getOrders();
});
 
function getOrders(){
    jQuery('#orders').dataTable().fnDestroy();
    jQuery('#orders tbody').empty();
    jQuery('#orders').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route("orders.getOrders") }}',
            method: 'POST'
        },
        columns: [
            {data: 'created_at', name: 'created_at'},
            {data: 'customer.name', name: 'customer.name'},
            {data: 'total_amount', name: 'total_amount', class: 'text-right'},
            {data: 'status', name: 'status', class: 'text-center'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ],
        order: [[0, 'desc']]
    });
}
</script>
@endsection
