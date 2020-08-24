<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VoucherRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VoucherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VoucherCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Voucher::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/voucher');
        CRUD::setEntityNameStrings('voucher', 'vouchers');
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
        CRUD::column('code');
        CRUD::column('end_at')->type('datetime');
        CRUD::column('type');
        CRUD::column('value')->label('Discount');
        CRUD::column('is_working')->label('Working')->type('check');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VoucherRequest::class);
        CRUD::field('name')->wrapper(['class' => 'form-group col-md-6'])->hint('The name of campaign');
        CRUD::field('code')->wrapper(['class' => 'form-group col-md-6'])->hint('Enter voucher code, eg. ABCD120, min 6 characters')->attributes([
            'minlength' => 6,
        ]);;
        CRUD::field('start_from')->type('datetime')->wrapper(['class' => 'form-group col-md-6']);
        CRUD::field('end_at')->label('End Time')->type('datetime')->wrapper(['class' => 'form-group col-md-6']);
        CRUD::field('dependent_voucher_input')->type('dependent_voucher_input');
        CRUD::field('min_order_val')->label('Min. Order Value')->type('number')->suffix('MMK')->wrapper(['class' => 'form-group col-md-6'])->hint('Min. order amount needed to redeem the voucher');
        CRUD::field('initial_voucher_count')->label('Initial Voucher Count')->type('number')->wrapper(['class' => 'form-group col-md-6'])->hint('Enter voucher count to be used');
        CRUD::field('is_active')->label('Active')->type('checkbox');
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
        $this->crud->modifyField('initial_voucher_count', ['attributes' => [
            'disabled' => true
        ]]);
        CRUD::field('voucher_count')->label('Voucher Left');
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $req_arr = request()->all();
        $req_arr['voucher_count'] = $req_arr['initial_voucher_count'];
        $item = $this->crud->create($req_arr);

        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $req_arr = request()->all();

        //Ignore Initial Voucher Count
        unset($req_arr['initial_voucher_count']);
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
                            $req_arr);
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
