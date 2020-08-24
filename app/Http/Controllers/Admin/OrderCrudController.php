<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\OrderStatusOperation;
use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use OrderStatusOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label("ID");
        CRUD::column('payment_method');
        CRUD::column('subtotal')->type('number')->suffix(' MMK')->decimals(2);
        CRUD::column('shipping_fee')->type('number')->suffix(' MMK')->decimals(2);;
        CRUD::column('discount');
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Ordered',
            'type' => 'closure',
            'function' => fn($entry) => $entry->created_at->diffForHumans()
        ]);

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrderRequest::class);

        CRUD::field('payment_method');
        CRUD::field('subtotal');
        CRUD::field('shipping_fee');
        CRUD::field('discount');
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
