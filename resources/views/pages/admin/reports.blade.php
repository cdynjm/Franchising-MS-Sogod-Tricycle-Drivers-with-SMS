<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FMS - Report</title>
    <style>
        @page {
            size: Legal;
            margin: 10mm;
        }

        #content {
            font-size: 12px;
            font-family: 'Calibri', 'Arial', sans-serif;
            width: 100%;
        }

        table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
            text-align: center;
            word-wrap: break-word;
        }

        table tr th, table tr td {
            border: 1px solid gray;
            padding: 5px;
            word-break: break-word;
        }
        
        table, tr, td, th {
            page-break-inside: avoid;
        }

        @media print {
            body {
                width: 210mm;
                height: 297mm;
                margin: 10mm;
            }
        }
        .page-break {
            page-break-after: always;
        }

    </style>
</head>
<body>
    <div id="content">
        <center>
            @if(!isset($printAll))
            <!-- Single category view -->
            <h4><strong>FRANCHISE RENEWAL & APPLICATIONS</strong></h4>
            <h4>Category: {{ $franchise->first()->categories->category }} - {{ $franchise->first()->categories->color }} | {{ $franchise->first()->categories->description }}</h4>
            <h4>Year {{ $year }} @if(!empty($month)) Month of {{ date('F', mktime(0, 0, 0, $month, 1)) }} @endif</h4>
            <div class="table">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Body Number</th>
                        <th>Applicant</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Case Number</th>
                        <th>Make</th>
                        <th>Motor Number</th>
                        <th>Chassis Number</th>
                        <th>Plate Number</th>
                        <th>Date Applied/Renewed</th>
                        <th>Expiration</th>
                    </tr>
                    @foreach ($franchise as $index => $fr)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $fr->code }}</td>
                        <td>{{ $fr->applicant }}</td>
                        <td>{{ $fr->address }}</td>
                        <td>{{ $fr->contactNumber }}</td>
                        <td>{{ $fr->caseNumber }}</td>
                        <td>{{ $fr->make }}</td>
                        <td>{{ $fr->motorNumber }}</td>
                        <td>{{ $fr->chassisNumber }}</td>
                        <td>{{ $fr->plateNumber }}</td>
                        <td>{{ date('M d, Y', strtotime($fr->created_at)) }}</td>
                        <td>{{ $fr->expiresOn ? date('M d, Y', strtotime($fr->expiresOn)) : '-' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @else
            <!-- Grouped view -->
            <!-- Grouped view -->
<h4><strong>ALL FRANCHISE RENEWAL & APPLICATIONS</strong></h4>
@foreach ($franchiseGroups as $category => $years)
    @php
        $firstFranchise = $years->first()->first(); // Access the first franchise for this category
    @endphp
    <div class="page-break">
        <h4>
            Category: {{ $category }} 
            - {{ $firstFranchise->categories->color }} 
            - {{ $firstFranchise->categories->description }}
        </h4>
        @foreach ($years as $year => $franchises)
            <h5>Year: {{ $year }}</h5>
            <div class="table">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Body Number</th>
                        <th>Applicant</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Case Number</th>
                        <th>Make</th>
                        <th>Motor Number</th>
                        <th>Chassis Number</th>
                        <th>Plate Number</th>
                        <th>Date Applied/Renewed</th>
                        <th>Expiration</th>
                    </tr>
                    @foreach ($franchises as $index => $fr)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fr->code }}</td>
                            <td>{{ $fr->applicant }}</td>
                            <td>{{ $fr->address }}</td>
                            <td>{{ $fr->contactNumber }}</td>
                            <td>{{ $fr->caseNumber }}</td>
                            <td>{{ $fr->make }}</td>
                            <td>{{ $fr->motorNumber }}</td>
                            <td>{{ $fr->chassisNumber }}</td>
                            <td>{{ $fr->plateNumber }}</td>
                            <td>{{ date('M d, Y', strtotime($fr->created_at)) }}</td>
                            <td>{{ $fr->expiresOn ? date('M d, Y', strtotime($fr->expiresOn)) : '-' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
@endforeach


            @endif
        </center>
    </div>
</body>
</html>
