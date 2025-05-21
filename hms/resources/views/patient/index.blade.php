<x-layout title="Patient Management">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Patient Management</h5>
            <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
                <i class="bi bi-plus-lg h3"></i>
            </button>
        </div>
        
        <hr class="hr">
        
        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>IC</th>
                    <th>Phone Number</th>
                    <th>Emergency Contact</th>
                    <th>Relationship</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#admin-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('patient') }}",
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'patient_id', name: 'patient_id'},
                {data: 'patient_name', name: 'patient_name'},
                {data: 'ic', name: 'ic'},
                {data: 'phone', name: 'phone'},
                {data: 'emergency_contact', name: 'emergency_contact'},
                {data: 'emergency_contact_relationship', name: 'emergency_contact_relationship'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '10%', targets: 1 },
                { width: '15%', targets: 2 },
                { width: '10%', targets: 6 },
                { width: '10%', targets: 7 },
            ]
        });

        $('#btn-create').click(function(e) {
            window.location.href = '{{ route("patient.details") }}';
        });

        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');

            window.location.href = '{{ url("/patient/details") }}/' + dataId;
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
                        url: '{{ url("/patient/delete") }}/' + dataId,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}', id: dataId },
                        success: function(response) {
                            var message = response.message;

                            if (response.state == 'success') {
                                Swal.fire('Success', message, 'success');

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
        });
    });
</script>
@endsection
</x-layout>