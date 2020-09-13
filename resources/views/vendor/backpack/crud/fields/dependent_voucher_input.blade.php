<!-- field_type_name -->
<div class="form-group col-md-6">
    <label>Type <span class="text-danger">*</span></label>
    <select
        name="type"
        id="type_select"
        class="form-control"
    >
        <option value="money">Money Value Voucher</option>
        <option value="percentage">Percentage Value Voucher</option>
    </select>
    <p class="help-block">Select voucher type</p>
</div>

<div class="form-group col-md-6

    <label id="v_value_label">Discount in Money <span class="text-danger">*</span></label>
    <div class="input-group">
        <input
            type="number"
            name="value"
            value="{{ old('value') ? old('value') : $entry['value'] ?? '' }}"
            id="v_value"
            class="form-control"
        >
        <div class="input-group-append">
            <span class="input-group-text" id="v_value_append">MMK</span>
        </div>
    </div>
    <p class="help-block">Enter amount you want to discount</p>
</div>

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
        <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
        <script>
            $('#type_select').val("{{ old('type') ? old('type') : $entry['type'] ?? '' }}").select2({
                theme: "bootstrap",
                data: [
                    {
                        id: 'money',
                        text: 'Money Value Voucher'
                    },
                    {
                        id: 'percentage',
                        text: 'Percentage Value Voucher'
                    }
                ]
            }).on('select2:select', (e) => {
                if (e.target.value == "money") {
                    $('#v_value_label').html("Discount in Money")
                    $('#v_value_append').html("MMK")
                }
                else if (e.target.value == "percentage") {
                    $('#v_value_label').html("Discount in Percentage")
                    $('#v_value_append').html("%")
                }

            })
        </script>
    @endpush
@endif
