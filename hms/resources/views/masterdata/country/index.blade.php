<x-layout title="Master Data">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title">Country</h5>
        <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
            <i class="bi bi-plus-lg h3"></i>
        </button>
    </div>
        <hr class="hr">
        
        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Country Code</th>
                    <th>Country Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="createForm">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="createModalLabel">Create</h1>
                <button type="button" class="btn-close close-button" data-bs-dismiss="modal" aria-label="Close"></button>
                <input type="hidden" id="hidden_country_id" />
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Country Code</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="country_code" name="country_code" autocomplete="off" maxlength="3" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Country Name</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="country_name" name="country_name" autocomplete="off" maxlength="100" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light close-button" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#admin-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('masterdata.country') }}",
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'country_code', name: 'country_code'},
                {data: 'country_name', name: 'country_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 }, // Set the width of the No column
                { width: '15%', targets: 1 }, 
                { width: '10%', targets: 3 }, 
            ]
        });

        $('.close-button').on('click', function() {
            $('#createForm')[0].reset();
            $('.is-invalid').removeClass('is-invalid');

            $('#country_code').prop('disabled', false);
            $('#country_code').prop('readonly', false);

            $('#hidden_country_id').val('');
        });

        $('#btn-create').click(function(e) {
            e.preventDefault();

            $('#createModal').modal('show');
        });

        $('#createForm').validate({
            rules: {
                country_code: {
                    required: true,
                    maxlength: 3
                },
                country_name: {
                    required: true,
                    maxlength: 100
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

                if ($('#hidden_country_id').val() == '') {
                    urls = '{{ route("country.create") }}';
                }else{
                    urls = '{{ url("/masterdata/country/edit") }}/' + $('#hidden_country_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success');

                            $(form)[0].reset();
                            $('.is-invalid').removeClass('is-invalid');

                            $('#hidden_country_id').val('');

                            $('#country_code').prop('disabled', false);
                            $('#country_code').prop('readonly', false);


                            $('#createModal').modal('hide');

                            table.ajax.reload();

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

        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');

            $.ajax({
                url: '{{ route("getCountry") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', id: dataId },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#hidden_country_id').val(dataId);
                        $('#country_code').val(response.country[0].country_code);
                        $('#country_name').val(response.country[0].country_name);

                        $('#country_code').prop('disabled', true);
                        $('#country_code').prop('readonly', true);

                        $('#createModal').modal('show');
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            var dataId = $(this).data('id');

            Swal.fire({
                title: "Are you sure to delete this?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ url("/masterdata/country/delete") }}/' + dataId,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}', id: dataId },
                        success: function(response) {
                            var message = response.message;

                            if (response.state == 'success') {
                                Swal.fire('Success', message, 'success');

                                table.ajax.reload();
                            }
                        },
                        error: function(response) {
                            var errorMessage = response.responseJSON.message;
                        
                            Swal.fire('Error', errorMessage, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
</x-layout>