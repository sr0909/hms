<x-layout title="Medical Record">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Prescription</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_prescription_id" value="{{ $prescription->id ?? '' }}"/>
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
                    <label class="fw-medium">Treatment ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="treatment_id" name="treatment_id" value="{{ $treatmentid ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Dosage</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="dosage" name="dosage" value="{{ $prescription->dosage ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Frequency</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="frequency" name="frequency" value="{{ $prescription->frequency ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Duration</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="duration" name="duration" value="{{ $prescription->duration ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Instructions</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <textarea type="text" row="3" class="form-control" id="instructions" name="instructions" autocomplete="off">{{ $prescription->instructions ?? '' }}</textarea>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
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
        var medicalRecordId = '{{ $medicalrecordid ?? "" }}';
        var diagnosisId = '{{ $diagnosisid ?? "" }}';
        var treatmentId = '{{ $treatmentid ?? "" }}';

        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/' + diagnosisId + '/treatment/details/' + treatmentId;
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
        }).on('select2:select', function (e) {
            var selectedMedicineId = e.params.data.id;

            // Fetch the dosage information based on the selected medicine ID
            $.ajax({
                url: '{{ route("getMedicineDosage") }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    medicine_id: selectedMedicineId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#dosage').val(response.dosage);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching dosage information:', error);
                }
            });
        });

        var type = '{{ $type }}';

        if (type == 'edit') {
            setMedicineNameValue('{{ $prescription->medicine_id ?? "" }}', '{{ $medicineName ?? "" }}');
        }

        $('#createForm').validate({
            rules: {
                medicine_id: {
                    required: true,
                    maxlength: 10
                },
                treatment_id: {
                    required: true,
                    maxlength: 10
                },
                dosage: {
                    required: true,
                    maxlength: 50
                },
                frequency: {
                    required: true,
                    maxlength: 50
                },
                duration: {
                    required: true,
                    maxlength: 50
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

                if ($('#hidden_prescription_id').val() == '') {
                    urls = '{{ route("prescription.create") }}';
                }else{
                    urls = '{{ url("/medicalrecord/prescription/edit") }}/' + $('#hidden_prescription_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success').then(() => {
                                window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/' + diagnosisId + '/treatment/details/' + treatmentId;
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