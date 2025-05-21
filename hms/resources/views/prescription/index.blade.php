<x-layout title="Prescription">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Prescription</h5>
        </div>

        <hr class="hr">

        <div class="row mb-4">
            <div class="col-sm-2 mt-2">
                <label class="fw-medium">Filter By Status</label>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <select class="form-select" id="filter_status" name="filter_status">
                        <option value="ALL">ALL</option>
                        <option value="Pending" selected>Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>
        
        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Diagnosis Result</th>
                    <th>Treatment</th>
                    <th>Status</th>
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
            ajax: {
                url: '{{ route("prescriptionapproval") }}',
                data: function (d) {
                    d.filter_status = $('#filter_status').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'patient_name', name: 'patient_name'},
                {data: 'doctor_name', name: 'doctor_name'},
                {data: 'diagnosis_name', name: 'diagnosis_name'},
                {data: 'treatment_name', name: 'treatment_name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '10%', targets: 6 },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('td:eq(6)').addClass('text-center');
            }
        });

        $('#filter_status').change(function() {
            table.ajax.reload();
        });

        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');

            window.location.href = '{{ url("prescriptionapproval/approval") }}/' + dataId;
        });
    });
</script>
@endsection
</x-layout>