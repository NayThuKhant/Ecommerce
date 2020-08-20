<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Stock;
use App\Models\Variant;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Prologue\Alerts\Facades\Alert;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
        $this->crud->enableExportButtons();

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('highlight');
        CRUD::column('description');
        CRUD::column('included')->label('Included');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        CRUD::field('name');
        CRUD::field('highlight')->type('textarea');
        CRUD::field('description')->type('textarea');
        CRUD::field('included')->label('What\'s Included in the Box')->type('textarea');

        $this->crud->addField([
            'name' => 'variants',
            'label' => 'Variants',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'color_family',
                    'type' => 'text',
                    'label' => 'Color Family',
                    'wrapper' => ["class" => "form-group col-md-4"]
                ],
                [
                    'name' => 'SKU',
                    'type' => 'text',
                    'label' => 'SKU',
                    'wrapper' => ["class" => "form-group col-md-4"]
                ],

                [
                    'name' => 'photos',
                    'label' => 'Photos',
                    'type' => 'browse_multiple',
                    'mime_types' => 'image',
                    'sortable' => true,
                    'multiple' => true

                ]

            ]
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }



    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $strippedReq = $this->crud->getStrippedSaveRequest();
        $variants = json_decode($request->variants, true);
        $product = $this->crud->create($strippedReq);
        $this->data['entry'] = $this->crud->entry = $product;

        foreach ($variants as $variant)
        {
            $variant_model = $product->variants()->create($variant);
        }

        Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($product->getKey());
    }



}
