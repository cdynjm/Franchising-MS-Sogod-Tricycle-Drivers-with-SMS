<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <style>
        #form-content {
            font-family: 'Calibri', 'Arial', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        table tr th {
            border: 1px solid black;
        }

        table tr td {
            text-align: center;
        }

        #unit tr td {
            border: 1px solid black
        }
    </style>

</head>

<body id="form-content">
    <div>
        <center>
            <div>Republic of the Philippines</div>
            <div>PROVINCE OF SOUTHERN LEYTE</div>
            <div>Municipality of Sogod</div>
            <div>-oOo-</div>
    
            <p style="text-align: center; margin-top: 5px; margin-bottom: 30px;"><b>OFFICE OF THE MUNICIPAL MAYOR</b></p>
            
            <p style="text-align: center; margin-bottom: 5px;"><b>MCH FRANCHISE COMMITTEE</b></p>

            <div style="text-align: center"><b>PROVSIONAL AUTHORITY FOR MCH SERVICE</b></div>
            <div style="text-align: center">(Legislation)</div>
            
        </center>

            <div>Name of Operator : <span style="margin-left: 40px;"><b>{{ $application->applicant }}</b></span><span style="float: right; margin-right: 30px;">Case No. : <span style="margin-left: 42px">{{ $application->caseNumber }}</span></span></div>
            <div>Address : <span style="margin-left: 80px; margin-right: 40px;">{{ $application->address }}</span><span style="float: right; margin-right: 30px;"><span style="margin-right: 70px;">No. of Unit: </span><span style="margin-right: 20px">One(1)</span></span></div>
            <div><span style="color: white">-</span><span style="float: right; margin-right: 30px;"><span style="margin-right: 85px;">Body No.</span><span style="margin-right: 40px">{{ $application->user->name }}</span></span></div>

            <div>Route of Operation : Within {{ $application->categories->description }}</div>
            <div style="margin-left: 20px;">Applicant/Operator is hereby authorized to operate one unit motorcab-{{ $application->categories->category }} more particularly</div>
            <div>described below as : </div>

            <table id="unit" >
                <tr>
                    <td>MAKE</td>
                    <td>MOTOR NO.</td>
                    <td>CHASSIS NO.</td>
                    <td>PLATE NO.</td>
                </tr>
                <tr>
                    <td style="padding: 10px;">{{ $application->make }}</td>
                    <td style="padding: 10px;">{{ $application->motorNumber }}</td>
                    <td style="padding: 10px;" width="30%">{{ $application->chassisNumber }}</td>
                    <td style="padding: 10px;">{{ $application->plateNumber }}</td>
                </tr>
            </table>
            <br>
            <br>
            <div style="margin-left: 40px;">1 <span style="margin-left: 20px">Applicant/Operator shall comply with the rules/regulations regarding the Municipal</span></div>
            <div style="margin-left: 72px;">Ordinance and the committee. Failure to comply thereof any of the regulations</div>
            <div style="margin-left: 72px;">herein setforth shall be sufficient cause for the authority herein granted invalid;</div>

            <div style="margin-left: 40px;">2 <span style="margin-left: 20px">The driver shall register as for hire with the Land Transportation Office Agency at</span></div>
            <div style="margin-left: 72px;">Maasin, Southern Leyte within THIRTY (30) days from the date hereof;</div>

            <div style="margin-left: 40px;">3 <span style="margin-left: 20px">This Special Authority shall be valid one (1) year from the date hereof and shall</span></div>
            <div style="margin-left: 72px;">constitute as Franchise Certificate giving the Operator the privilege to operate the</div>
            <div style="margin-left: 72px;">unit herein prescribed for hire and/or compensation;</div>
            
            <div style="margin-left: 40px;">4 <span style="margin-left: 20px">Without previous authority from the Committee, Operator shall not increase ,</span></div>
            <div style="margin-left: 72px;">decrease , transfer, drop and/or substitute unit, as well as, suspend or abandon the</div>
            <div style="margin-left: 72px;">service herein authorized; otherwise , the authority herein granted shall be</div>
            <div style="margin-left: 72px;">declared forfeited or cancelled;</div>

            <div style="margin-left: 40px;">5 <span style="margin-left: 20px">Applicant/Operator shall pay to the Committee on or before September 30 of every</span></div>
            <div style="margin-left: 72px;">year supervision or regulation fees computed at the rate of ₱50.00 per unit;</div>
           
            <div style="margin-left: 40px;">6 <span style="margin-left: 20px">Protect the Document, loss or destruct may effect your legality to operate the</span></div>
            <div style="margin-left: 72px;">service, any addition not otherwise authorized will invalidate the Document.</div>
            <div><b>SO ORDERED.</b></div>
            <div style="margin-left: 72px;">Sogod, Southern Leyte, Philippines <span style="margin-left: 100px;">{{ strtoupper(date('F d Y', strtotime($application->created_at))) }}</span></div>

            <br>
            
            <br>

            <p style="margin-left: 300px; margin-bottom: 5px;"><input type="text" style="width:80%; border: none; border-bottom: 1px solid black; font-weight: bold; text-align: center;" value="{{ $application->mayor }}"></p>
            <div style="margin-left: 410px;">Municipal Mayor</div>
            <div style="margin-left: 350px;">Chairman, MCH Franchise Committee</div>

            <br>

            <div>Copy furnished <span style="margin-left: 10px">:</span></div>
            <div style="margin-left: 80px;">Applicant</div>
            <div style="margin-left: 80px;">Thee Registrar, LTO, Maasin So. Leyte</div>

</body>

</html>
