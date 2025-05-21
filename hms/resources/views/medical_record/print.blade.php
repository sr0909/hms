<!DOCTYPE html>
<html>
<head>
    <title>Medical Report</title>

    <style>
        body {
            font-size: 16px;
        }

        td {
            vertical-align: top;
        }

        .text-start {
            text-align: left;
        }

        .hr {
            margin: 0;
            margin-top: 15px;
            margin-bottom: 15px;
            border-width: 2px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
        </thead>
        <tbody>
            <tr>
                <td><img src="{{ asset('images/icon.png') }}" alt="HMS Logo"></td>
                <td style="width: 10px;"></td>
                <td style="vertical-align: middle;">
                    Kuala Lumpur General Hospital<br>
                    202, Jalan Pahang,<br>
                    50586 Kuala Lumpur, Malaysia<br>
                    info@klgh.gov.my<br>
                    +60 3-2615 5555<br>
                </td>
            </tr>
        </tbody>
    </table>

    <hr class="hr">

    <table>
        <thead>
            <tr>
                <th colspan="3" class="text-start">Patient Information</th>
                <th style="width: 130px;"></th>
                <th colspan="3" class="text-start">Doctor Information</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Name</td>
                <td>: </td>
                <td>{{ $patient->patient_name }}</td>
                <td></td>
                <td>Name</td>
                <td>: </td>
                <td>{{ $staff->name }}</td>
            </tr>
            <tr>
                <td>IC</td>
                <td>: </td>
                <td>{{ $patient->ic }}</td>
                <td></td>
                <td>Department</td>
                <td>: </td>
                <td>{{ $department->dept_name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: </td>
                <td>{{ $patient->email }}</td>
                <td></td>
                <td>Email</td>
                <td>: </td>
                <td>{{ $staff->email }}</td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td>: </td>
                <td>{{ $patient->phone }}</td>
                <td></td>
                <td>Contact Number</td>
                <td>: </td>
                <td>{{ $staff->phone }}</td>
            </tr>
        </tbody>
    </table>

    <hr class="hr">

    <table style="margin-bottom: 15px;">
        <thead>
            <tr>
                <th colspan="3" class="text-start">Medical Record</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 105px;">Created Date</td>
                <td>: </td>
                <td>{{ $medicalrecord->medical_record_date }}</td>
            </tr>
            <tr>
                <td>ID</td>
                <td>: </td>
                <td>{{ $medicalrecord->medical_record_id }}</td>
            </tr>
            <tr>
                <td>Notes</td>
                <td>: </td>
                <td>{{ $medicalrecord->notes }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="4" class="text-start">Diagnosis Result</th>
                <th style="width: 20px;"></th>
                <th colspan="4" class="text-start">Treatment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diagnosislist as $diagnosis)
                <tr>
                    <td>{{ $loop->iteration }}. </td>
                    <td style="width: 90px;">Name</td>
                    <td>: </td>
                    <td style="width: 240px;">{{ $diagnosis->diagnosis_name }}</td>
                    <td></td>
                    @php
                        $treatments = \App\Models\Treatment::where('diagnosis_id', $diagnosis->diagnosis_id)->get();
                    @endphp

                    @if($treatments->isNotEmpty())
                        @foreach ($treatments as $treatment)
                            @php
                                $treatmentType = \App\Models\TreatmentType::where('id', $treatment->type_id)->first();
                            @endphp

                            @if(!$loop->first)
                                <td colspan="5"></td>
                            @endif
                                <td>&#9755; </td>
                                <td style="width: 90px;">Type</td>
                                <td>: </td>
                                <td style="width: 220px;">{{ $treatmentType->type }}</td>
                            </tr>
                            <tr>
                                @if(!$loop->first)
                                    <td colspan="4"></td>
                                @else
                                    <td></td>
                                    <td>Description</td>
                                    <td>: </td>
                                    <td>{{ $diagnosis->diagnosis_description }}</td> 
                                @endif
                                <td></td>
                                <td></td>
                                <td>Name</td>
                                <td>: </td>
                                <td>{{ $treatment->treatment_name }}</td>
                            </tr>
                            <tr>
                                <td colspan = "5"></td>
                                <td></td>
                                <td>Description</td>
                                <td>: </td>
                                <td>{{ $treatment->treatment_description }}</td>
                            </tr>
                            <tr>
                                <td colspan = "5"></td>
                                <td></td>
                                <td>Date</td>
                                <td>: </td>
                                @if ($treatment->end_date == '') 
                                    <td>{{ $treatment->start_date }}</td>
                                @else
                                    <td>{{ $treatment->start_date }} - {{ $treatment->end_date }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan = "5"></td>
                                <td></td>
                                <td style="height: 30px;">Status</td>
                                <td>: </td>
                                <td>{{ $treatment->status }}</td>
                            </tr>
                        @endforeach
                    @else
                            <td colspan="4">No treatment available.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Description</td>
                            <td>: </td>
                            <td>{{ $diagnosis->diagnosis_description }}</td>    
                            <td></td>
                            <td colspan="4"></td>
                        </tr>
                    @endif
                <tr>
                    <td><br></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
