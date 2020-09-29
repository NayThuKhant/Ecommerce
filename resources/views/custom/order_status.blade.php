@extends(backpack_view('layouts.top_left'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => backpack_url('dashboard'),
      $crud->entity_name_plural => url($crud->route),
      'Order Status' => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? $crud->entity_name." Status" !!}.</small>

            @if ($crud->hasAccess('list'))
                <small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i
                            class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">
                        Status of Order #{{$order->id}} by {{ $order->user->name }} <span
                            class="badge badge-primary badge-danger"> {{$order->final_status}} </span>
                    </div>
                </div>
                <div class="card-body container-fluid">
                    <div class="row pt-2">
                        <div class="col-md-6">
                            <p>Order Id : #{{ $order->id }}</p>
                            <p>Order On : {{ $order->created_at }}</p>
                            <p>Total : {{ $order->total }} <span class="text-muted">(subtotal: {{ $order->subtotal }} + shipping fee: {{$order->shipping_fee}})</span>
                            </p>
                            <p>Customer Name : {{ $order->user->name }}</p>
                            <p>Email : {{ $order->user->email }}</p>
                            <p>Phone : {{ $order->user->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>Payment Method : {{ $order->payment_method }}</p>
                            <p>Confirmed at : {{ $order->orderStatus->confirmed_at }}</p>
                            <p>Processed at : {{ $order->orderStatus->processed_at }}</p>
                            <p>Shipped at : {{ $order->orderStatus->shipped_at }}</p>
                            <p>Delivered at : {{ $order->orderStatus->delivered_at }}</p>
                            <p>Paid at : {{ $order->orderStatus->paid_at}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">
                        Manage Order <span
                            class="badge badge-primary badge-danger"> {{$order->final_status}} </span>
                    </div>
                </div>
                @if($order->final_status != 'cancelled')
                    <div class="card-body container-fluid">
                        <div class="row py-3">
                            <form action="{{route('confirm-order',['order'=>$order->id])}}" method="post" class="p-2">
                                @csrf
                                @if(!$order->orderStatus->confirmed_at)
                                    <button class="btn btn-success" type="submit">
                                        Confirm Order
                                    </button>
                                @else
                                    <span class="bg-secondary p-2 rounded">Confirmed</span>
                                @endif
                            </form>
                            <form action="{{route('proceed-order',['order'=>$order->id])}}" method="post" class="p-2">
                                @csrf
                                @if(!$order->orderStatus->processed_at)
                                    <button class="btn btn-success" type="submit"
                                            @if($order->orderStatus->confirmed_at === null) disabled @endif>
                                        Proceed Order
                                    </button>
                                @else
                                    <span class="bg-secondary p-2 rounded">Proceeded</span>
                                @endif
                            </form>
                            <form action="{{route('ship-order',['order'=>$order->id])}}" method="post" class="p-2">
                                @csrf
                                @if(!$order->orderStatus->shipped_at)
                                    <button class="btn btn-success" type="submit"
                                            @if($order->orderStatus->processed_at === null) disabled @endif>
                                        Ship Order
                                    </button>
                                @else
                                    <span class="bg-secondary p-2 rounded">Shipped</span>
                                @endif
                            </form>
                            <form action="{{route('deliver-order',['order'=>$order->id])}}" method="post" class="p-2">
                                @csrf
                                @if(!$order->orderStatus->delivered_at)
                                    <button class="btn btn-success" type="submit"
                                            @if($order->orderStatus->shipped_at === null) disabled @endif>
                                        Deliver Order
                                    </button>
                                @else
                                    <span class="bg-secondary p-2 rounded">Delivered</span>
                                @endif
                            </form>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('fail'))
                            <div class="alert alert-danger">
                                {{ session('fail') }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="card-body container-fluid">
                        <span class="text-danger p-2">
                            This order was cancelled and there's nothing to do.
                        </span>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">
                        Variants (products) in order #{{$order->id}}
                    </div>
                </div>
                <div class="card-body container-fluid">
                    <div class="row">
                        @foreach($order->items as $item)
                            <div class="col-md-6 d-flex justify-content-between p-2">
                                <div class="container-fluid p-0 p-2" style="background-color: whitesmoke">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-start">
                                                <img src="{{ asset(json_decode($item->variant->photos)[0]) }}" alt=""
                                                     style="height: 75px; width: 75px" class="img-thumbnail mr-4">
                                                <div class="d-flex flex-column">
                                                    <span>{{ $item->variant->product->name }}</span>
                                                    <span>{{ $item->variant->name }}</span>
                                                    <span>{{ $item->variant->special_price }} MMK</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex justify-content-between">
                                            <span>Quantity : 2</span>
                                            <span>{{ $item->price }} MMK</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="d-block">Address : {{ $order->address->full_address  }}</span>
                        <span class="d-block">Phone : {{ $order->address->phone  }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">
                        <span>Total : {{ $order->total }} <span class="text-muted">(subtotal: {{ $order->subtotal }} + shipping fee: {{$order->shipping_fee}})</span>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
