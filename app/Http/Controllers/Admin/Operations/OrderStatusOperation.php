<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Order;
use Illuminate\Support\Facades\Route;

trait OrderStatusOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
     */
    protected function setupOrderStatusRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{order}/order_status', [
            'as'        => $routeName.'.order_status',
            'uses'      => $controller.'@show_order_status',
            'operation' => 'order_status',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupOrderStatusDefaults()
    {
        $this->crud->allowAccess('orderstatus');
        $this->crud->setSubheading("Order Status");
        $this->crud->operation('orderstatus', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
             $this->crud->addButtonFromView('line', 'orderstatus', 'order_status_button', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function show_order_status(Order $order)
    {
        $this->crud->hasAccessOrFail('orderstatus');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'orderstatus '.$this->crud->entity_name;
        $this->data['order'] = $order;



        // load the view
        return view("custom.order_status", $this->data);
    }
}
