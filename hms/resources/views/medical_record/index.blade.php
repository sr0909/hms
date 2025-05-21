<x-layout title="Medical Record">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Medical Record</h5>
            @if (Auth::user()->hasRole('doctor'))
            <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
                <i class="bi bi-plus-lg h3"></i>
            </button>
            @endif
        </div>
        
        <hr class="hr">

        @if (Auth::user()->hasRole('doctor'))
        <div class="row mb-4">
            <div class="col-sm-2 mt-2">
                <label class="fw-medium">Filter By Doctor</label>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <select class="form-select" id="filter_doctor" name="filter_doctor">
                        <option value="ALL">ALL</option>
                        <option value="{{ $doctorId ?? '' }}" selected>{{ $doctorName ?? '' }}</option>
                    </select>
                </div>
            </div>
        </div>
        @endif

        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    @if (Auth::user()->hasRole('doctor'))
                        <th>Patient Name</th>
                    @elseif (Auth::user()->hasRole('normal user'))
                        <th>Department</th>
                    @endif
                    <th>Doctor Name</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Hidden iframe element used for printing content -->
<iframe id="print-frame" style="display:none;"></iframe>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#admin-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("medicalrecord") }}',
                data: function (d) {
                    d.filter_doctor = $('#filter_doctor').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'medical_record_date', name: 'medical_record_date'},
                @if (Auth::user()->hasRole('doctor'))
                    {data: 'patient_name', name: 'patient_name'},
                @elseif (Auth::user()->hasRole('normal user'))
                    {data: 'dept_name', name: 'dept_name'},
                @endif
                {data: 'doctor_name', name: 'doctor_name'},
                {data: 'notes', name: 'notes'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '10%', targets: 5 },
                { width: '10%', targets: 6 },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('td:eq(6)').addClass('text-center');
            }
        });

        $('#filter_doctor').change(function() {
            table.ajax.reload();
        });

        $('#btn-create').click(function(e) {
            window.location.href = '{{ route("medicalrecord.details") }}';
        });

        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');

            window.location.href = '{{ url("/medicalrecord/details") }}/' + dataId;
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
                        url: '{{ url("/medicalrecord/delete") }}/' + dataId,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}', id: dataId },
                        success: function(response) {
                            var message = response.message;

                            if (response.state == 'success') {
                                Swal.fire('Success', message, 'success');

                                table.ajax.reload();
                            } else if (response.state == 'error') {
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

        $(document).on('click', '.view-btn', function() {
            var dataId = $(this).data('id');

            $.ajax({
                url: '{{ url("/medicalrecord/print") }}/' + dataId,
                type: 'GET',
                success: function(response) {
                    var printFrame = $('#print-frame');

                    // Get the document object of the iframe
                    var doc = printFrame[0].contentDocument || printFrame[0].contentWindow.document;
                    doc.open(); // Open the document for writing
                    doc.write(response); // Write the response content into the iframe document
                    doc.close(); // Close the document

                    // Focus on the iframe's window and trigger the print dialog
                    printFrame[0].contentWindow.focus();
                    printFrame[0].contentWindow.print();
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });
    });
</script>
@endsection
</x-layout>