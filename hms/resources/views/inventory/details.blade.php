<x-layout title="Inventory Management">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Inventory Management</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_inventory_id" value="{{ $inventory->id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Medicine Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="medicine_id" name="medicine_id" autocomplete="off"></select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Expiry Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="expiry_date" name="expiry_date" autocomplete="off" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Batch Number</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="batch_no" name="batch_no" value="{{ $inventory->batch_no ?? '' }}" autocomplete="off" maxlength="20" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Quantity</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $inventory->quantity ?? '' }}" autocomplete="off" min="0" max="9999999" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Reorder Level</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="{{ $inventory->reorder_level ?? '' }}" autocomplete="off" min="1" max="9999999" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Reorder Quantity</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" id="reorder_quantity" name="reorder_quantity" value="{{ $inventory->reorder_quantity ?? '' }}" autocomplete="off" min="1" max="9999999" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Status</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="status" name="status">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2 mt-3">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ route("inventory") }}';
        });

        $('#medicine_id').select2({
            placeholder: "Select a medicine",
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("getMedicineNameList") }}',
                type: 'POST',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // Search term
                        _token: '{{ csrf_token() }}'
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.medicine_id,
                                text: item.medicine_name
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $('#expiry_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy',
            minDate: new Date(new Date().setHours(0, 0, 0, 0))
        });

        $('#quantity').on('keypress', function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            // Allow only numbers
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });

        $('#reorder_level').on('keypress', function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            // Allow only numbers
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });

        $('#reorder_quantity').on('keypress', function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            // Allow only numbers
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });

        var type = '{{ $type }}';

        if (type == 'edit') {
            setMedicineNameValue('{{ $inventory->medicine_id ?? "" }}', '{{ $medicineName ?? "" }}');

            var expiry_date = '{{ $inventory->expiry_date ?? "" }}';
            var formattedExpiryDate = expiry_date.split('-').reverse().join('-');
            $('#expiry_date').datepicker('value', formattedExpiryDate);

            $('#status').val('{{ $inventory->status ?? "" }}');
        }

        $('#createForm').validate({
            rules: {
                medicine_id: {
                    required: true,
                    maxlength: 10
                },
                expiry_date: {
                    required: true,
                },
                batch_no: {
                    required: true,
                    maxlength: 20
                },
                quantity: {
                    required: true,
                    min: 0,
                    max: 9999999
                },
                reorder_level: {
                    required: true,
                    min: 1,
                    max: 9999999
                },
                reorder_quantity: {
                    required: true,
                    min: 1,
                    max: 9999999
                },
                status: {
                    required: true,
                },
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.siblings('.invalid-feedback'));
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                var formData = {};

                $(form).find(':input').each(function() {
                    var field = $(this);
                    formData[field.attr('name')] = field.val();
                });

                var urls;

                if ($('#hidden_inventory_id').val() == '') {
                    urls = '{{ route("inventory.create") }}';
                }else{
                    urls = '{{ url("/inventory/edit") }}/' + $('#hidden_inventory_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success').then(() => {
                                window.location.href = '{{ route("inventory") }}';
                            });

                        }else if (response.state == 'error') {
                            Swal.fire('Error', message, 'error');
                        }
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON.message;
                        
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            }
        });

        // Function to set the initial value of the select2
        function setMedicineNameValue(id, text) {
            // Create a new option and add it to the select element
            var option = new Option(text, id, true, true);
            $('#medicine_id').append(option).trigger('change');

            // Manually trigger the select2:select event to update the display
            $('#medicine_id').trigger({
                type: 'select2:select',
                params: {
                    data: { id: id, text: text }
                }
            });
        }
    });
</script>
@endsection
</x-layout>