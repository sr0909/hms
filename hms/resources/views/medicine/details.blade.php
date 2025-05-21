<x-layout title="Medicine Management">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Medicine Management</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_medicine_id" value="{{ $medicine->medicine_id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="medicine_id" name="medicine_id" value="{{ $medicine->medicine_id ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Manufacturer</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="{{ $medicine->manufacturer ?? '' }}" autocomplete="off" maxlength="150" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="medicine_name" name="medicine_name" value="{{ $medicine->medicine_name ?? '' }}" autocomplete="off" maxlength="150" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Category</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="category_id" name="category_id" autocomplete="off"></select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Dosage Form</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="dosage_form" name="dosage_form" value="{{ $medicine->dosage_form ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Strength</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="strength" name="strength" value="{{ $medicine->strength ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Package Size</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="package_size" name="package_size" value="{{ $medicine->package_size ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Price (RM)</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" value="{{ $medicine->price ?? '' }}" autocomplete="off" maxlength="7" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Description</label>
                </div>
                <div class="col-sm-10">
                    <div class="input-group">
                        <textarea type="text" row="3" class="form-control" id="medicine_description" name="medicine_description" autocomplete="off" required>{{ $medicine->medicine_description ?? '' }}</textarea>
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
            window.location.href = '{{ route("medicine") }}';
        });

        $('#price').on('keypress', function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            // Allow only numbers and a single dot
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                e.preventDefault();
            }
            // Ensure only one dot is allowed
            if (charCode == 46 && $(this).val().indexOf('.') != -1) {
                e.preventDefault();
            }
        });

        $('#category_id').select2({
            placeholder: "Select a category",
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("getMedicineCategoryList") }}',
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
                                id: item.id,
                                text: item.category_name
                            };
                        })
                    };
                },
                cache: true
            }
        });

        var type = '{{ $type }}';

        if (type == 'create') {
             // Get Medicine ID
            $.ajax({
                url: '{{ route("getMedicineId") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#medicine_id').val(response.medicineId);
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });

        }else if (type == 'edit') {
            setCategoryValue('{{ $medicine->category_id ?? "" }}', '{{ $categoryName ?? "" }}');
        }

        $('#createForm').validate({
            rules: {
                medicine_id: {
                    required: true,
                    maxlength: 10
                },
                medicine_name: {
                    required: true,
                    maxlength: 150
                },
                manufacturer: {
                    required: true,
                    maxlength: 150
                },
                category_id: {
                    required: true,
                },
                dosage_form: {
                    required: true,
                    maxlength: 50
                },
                strength: {
                    required: true,
                    maxlength: 50
                },
                package_size: {
                    required: true,
                    maxlength: 50
                },
                price: {
                    required: true,
                    maxlength: 7
                },
                medicine_description: {
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

                if ($('#hidden_medicine_id').val() == '') {
                    urls = '{{ route("medicine.create") }}';
                }else{
                    urls = '{{ url("/medicine/edit") }}/' + $('#hidden_medicine_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success').then(() => {
                                window.location.href = '{{ route("medicine") }}';
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
        function setCategoryValue(id, text) {
            // Create a new option and add it to the select element
            var option = new Option(text, id, true, true);
            $('#category_id').append(option).trigger('change');

            // Manually trigger the select2:select event to update the display
            $('#category_id').trigger({
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