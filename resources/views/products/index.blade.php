@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table" id="products">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>In Stock</th>
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
    getProducts();
});
 
function getProducts(){
    jQuery('#products').dataTable().fnDestroy();
    jQuery('#products tbody').empty();
    jQuery('#products').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route("products.getProducts") }}',
            method: 'POST'
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price', class: 'text-right'},
            {data: 'in_stock', name: 'in_stock', class: 'text-center'},
        ],
        order: [[0, 'asc']]
    });
}
</script>
@endsection
