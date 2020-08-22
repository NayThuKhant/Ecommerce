@if ($crud->hasAccess('orderstatus'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/order_status') }}" class="btn btn-sm btn-info"><i class="fa fa-list"></i> Order Status</a>
@endif
