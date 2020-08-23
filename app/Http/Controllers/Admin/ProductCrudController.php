<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;


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
    public function fetchCategories()
    {
        return $this->fetch(Category::class);
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
        CRUD::column('variants')->type('relationship_count');
        CRUD::column('featured_photo')->label('Photo')->type('image');
        CRUD::column('total_stocks');
        CRUD::column('is_active')->label('Active')->type('check');
        CRUD::column('is_visible')->type('check')->label('Visible');
        CRUD::column('updated_at')->label("Last Updated")->type('datetime');

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
        CRUD::field('highlight')->type('ckeditor');
        CRUD::field('description')->type('ckeditor');
        CRUD::field('included')->label('What\'s Included in the Box')->type('textarea');
        CRUD::field('featured_photo')->type('browse');
        $this->crud->addField([
            'name' => 'categories',
            'type' => 'relationship',
            'label' => 'Categories',
            'entity' => 'categories',
            'attribute' => 'name',
            'pivot' => true,
//            'ajax' => true,
            'inline_create' => [ 'entity' => 'category'],
        ]);
        CRUD::field('is_active')->type('checkbox')->label('Active');
        $this->crud->addField([
            'name' => 'variants',
            'label' => 'Variants',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'name',
                    'type' => 'text',
                    'label' => 'Name',
                    'wrapper' => ["class" => "form-group col-md-6"]
                ],
                [
                    'name' => 'color_family',
                    'type' => 'text',
                    'label' => 'Color Family',
                    'wrapper' => ["class" => "form-group col-md-6"]
                ],
                [
                    'name' => 'SKU',
                    'type' => 'text',
                    'label' => 'SKU',
                    'wrapper' => ["class" => "form-group col-md-6"]
                ],
                [
                    'name' => 'stocks',
                    'type' => 'number',
                    'label' => 'Stocks Available',
                    'wrapper' => ["class" => "form-group col-md-6"]
                ],
                [
                    'name' => 'is_available',
                    'label' => 'Available',
                    'default' => 1,
                    'type' => 'checkbox',

                ],
                [
                    'name' => 'sale_price',
                    'label' => "Sale Price",
                    'type' => 'number',
                    'attributes' => ["step" => "any"], // allow decimals
                    'suffix'     => "MMK",
                    'wrapper' => ['class' => 'form-group col-md-4']
                ],
                [
                    'name' => 'special_price',
                    'label' => "Special Price",
                    'type' => 'number',
                    "default" => 0,
                    'attributes' => [
                        "step" => "any",
                    ], // allow decimals
                    'suffix'     => "MMK",
                    'wrapper' => ['class' => 'form-group col-md-4']
                ],
                [
                    'name' => 'shipping_fee_multiplier',
                    'label' => "Shipping Fee Multiplier",
                    'default' => 1,
                    'type' => 'number',
                    'attributes' => ["step" => "any"], // allow decimals
                    'prefix'     => "x",
                    'wrapper' => ['class' => 'form-group col-md-4']
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

        //Create Product
        $product = $this->crud->create($strippedReq);
        $this->data['entry'] = $this->crud->entry = $product;

        //Add Categories to it.
        if (!array_key_exists('categories', $strippedReq))
        {
            $product->categories()->sync([]);
        }
        else {
            $product->categories()->sync([$strippedReq['categories']]);
        }

        //Add Variants to it.
        $variant_groups = json_decode($request->variants, true);
        foreach ($variant_groups as $variant_group)
        {
            $product->variants()->create($variant_group);
        }

        //Done
        Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($product->getKey());
    }


    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $strippedReq = $this->crud->getStrippedSaveRequest();

        //Update Product
        $product = $this->crud->update($request->id, $strippedReq);

        //Add Categories to it.
        if (!array_key_exists('categories', $strippedReq))
        {
            $product->categories()->sync([]);
        }
        else {
            $product->categories()->sync([$strippedReq['categories']]);
        }
        //Add Variants to it.
        $variant_groups = collect(json_decode($request->variants, true));
        $this->data['entry'] = $this->crud->entry = $product;
        $variants = $product->variants();

        /*
         * Search for variants that is not included in Request Variant, and delete them.
         */
        $variants->whereNotIn('SKU', $variant_groups->pluck('SKU'))->get()->map->delete();

        foreach ($variant_groups as $variant_group)
        {
            $vari_db = $product->variants()->updateOrCreate(['SKU' => $variant_group['SKU']], $variant_group);
        }

        //Done
        \Alert::success(trans('backpack::crud.update_success'))->flash();
        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($product->getKey());
    }


}
