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
    /* Watermark styling */
    #watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: 0;
            width: 80%;
            height: auto;
        }
    </style>

</head>

<body id="form-content">

    <img id="watermark" src="{{ asset('storage/logo/logo-sogod.png') }}" alt="Watermark Logo">
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


        <table style="width: 100%; text-align: left;">
            <tr>
                <td style="text-align: left;">
                    Name of Operator: <strong style="text-decoration: underline;">{{ $application->applicant }}</strong>
                </td>
                <td style="text-align: left;">
                    Case No.: <strong style="text-decoration: underline;">{{ $application->caseNumber }}</strong>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    Address: <strong style="text-decoration: underline;">{{ $application->address }}</strong>
                </td>
                <td style="text-align: left;">
                    No. of Unit: <strong style="text-decoration: underline;">One(1)</strong>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;"></td>
                <td style="text-align: left;">
                    Body No.: <strong style="text-decoration: underline;">{{ $application->user->name }}</strong>
                </td>
            </tr>
        </table>

       

            <p style="text-align: justify">Route of Operation : Within <strong style="text-decoration: underline">{{ $application->categories->description }}</strong>
            Applicant/Operator is hereby authorized to operate one unit motorcab <strong style="text-decoration: underline">{{ $application->categories->category }}-{{ $application->categories->color }}</strong> more particularly
           described below as : </p>

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
            <p style="text-align: justify;">
                1. <span style="">Applicant/Operator shall comply with the rules/regulations regarding the Municipal Ordinance and the committee. Failure to comply thereof any of the regulations herein setforth shall be sufficient cause for the authority herein granted invalid;</span>
            </p>
            
            <p style="text-align: justify;">
                2. <span style="">The driver shall register as for hire with the Land Transportation Office Agency at Maasin, Southern Leyte within THIRTY (30) days from the date hereof;</span>
            </p>
            
            <p style="text-align: justify;">
                3. <span style="">This Special Authority shall be valid one (1) year from the date hereof and shall constitute as Franchise Certificate giving the Operator the privilege to operate the unit herein prescribed for hire and/or compensation;</span>
            </p>
            
            <p style="text-align: justify;">
                4. <span style="">Without previous authority from the Committee, Operator shall not increase, decrease, transfer, drop and/or substitute unit, as well as, suspend or abandon the service herein authorized; otherwise, the authority herein granted shall be declared forfeited or cancelled;</span>
            </p>
            
            <p style="text-align: justify;">
                5. <span style="">Applicant/Operator shall pay to the Committee on or before September 30 of every year supervision or regulation fees computed at the rate of ₱50.00 per unit;</span>
            </p>
            
            <p style="text-align: justify;">
                6. <span style="">Protect the Document, loss or destruct may effect your legality to operate the service, any addition not otherwise authorized will invalidate the Document.</span>
            </p>
            
            
            <div><b>SO ORDERED.</b></div>
            <div>Sogod, Southern Leyte, Philippines <strong style="text-decoration: underline" >{{ strtoupper(date('F d Y', strtotime($application->created_at))) }}</strong></div>

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
