@extends(backpack_view('blank'))


@section('content')

    <nav aria-label="breadcrumb" class="d-none d-lg-block">
        <ol class="breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="http://ecommerce.demo/admin/dashboard">Admin</a>
            </li>
            <li class="breadcrumb-item text-capitalize"><a href="http://ecommerce.demo/admin/orders">orders</a>
            </li>
        </ol>
    </nav>


    <div class="p-0 container-fluid">
        <h2>
            <span class="text-capitalize">orders</span>
            <small id="datatable_info_stack" class="animated fadeIn" style="display: inline-flex;">
                <div class="dataTables_info" id="crudTable_info" role="status" aria-live="polite">Showing 1 to 1 of
                    1 entries.
                </div>
                <a href="http://ecommerce.demo/admin/orders" class="ml-1"
                   id="crudTable_reset_button">Reset</a></small>
        </h2>
    </div>

    <div class="container-fluid animated fadeIn p-0">


        <!-- Default box -->
        <div class="row">

            <!-- THE ACTUAL CONTENT -->
            <div class="col-md-12">


                <div class="card">
                    hello
                </div>


            </div>

        </div>


    </div>

@endsection
