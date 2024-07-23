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
            <br>

            <p style="text-align: center"><b>OFFICE OF THE MUNICIPAL MAYOR</b></p>

            <p style="text-align: center"><b>MCH FRANCHISE COMMITTEE</b></p>

            <p style="text-align: center"><b>CONFIRMATION/CERTIFICATION</b></p>
            
        </center>

            <p style="margin-bottom: 5px;"><b>TO WHOM IT MAY CONCERN :</b></p>
            <br>
            <p style="margin-left: 67px; margin-bottom: 5px;"><b>THIS IS TO CERTIFY/CONFIRM</b> that <b style="margin-left: 50px;">{{ $application->applicant }}</b> <span style="margin-left: 50px;">is</span></p>
            <div>authorized to operate a transport public utility Case No. <span style="margin-left: 40px;">{{ $application->caseNumber }} <span style="margin-left: 50px">which</span></span></div>
            <br>
            <p><span style="margin-left: 67px; width: 60px; text-align: center; padding-left: 30px; padding-right: 30px; font-weight: bold; font-size: 15px; border: 2px solid black; color: black; display: inline">X</span><span style="margin-left: 50px;">UTOP is valid upto</span><input style="margin-left: 50px; border: none; border-bottom: 1px solid black;" type="text" value="{{ strtoupper(date('F d Y', strtotime($application->expiresOn))) }}" readonly></p>
            <p><span style="margin-left: 67px; width: 60px; text-align: center; padding-left: 30px; padding-right: 30px; font-weight: bold; font-size: 15px; border: 2px solid black; color: white; display: inline">X</span><span style="margin-left: 50px;">PA is valid upto</span><input style="margin-left: 70px; border: none; border-bottom: 1px solid black; text-align: center" type="text" value="" readonly></p>
            <p><span style="margin-left: 67px; width: 60px; text-align: center; padding-left: 30px; padding-right: 30px; font-weight: bold; font-size: 15px; border: 2px solid black; color: white; display: inline">X</span><span style="margin-left: 50px;">Others (Specify)</span><input style="margin-left: 65px; border: none; border-bottom: 1px solid black; text-align: center" type="text" value="" readonly></p>

            <p style="margin-bottom: 5px; margin-left: 30px;">On the line within {{ $application->categories->description }} with the use of</p>
            <div>motorcab-{{ $application->categories->category }} unit more particularly described as follows :</div>
            <br>
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
            <p style="margin-left: 67px; margin-bottom: 5px;">Issued upon the request of the above-named operator for all legal intents and/or</p>
            <div>registration purposes.</div>

            <br>
            <p style="text-align: right; margin-right: 20px; margin-bottom: 10px">{{ strtoupper(date('M. d Y', strtotime($application->created_at))) }}</p>
            <div style="margin-left: 67px;">Sogod, Southern Leyte, Philippines</div>

            <br>

            <p style="margin-left: 300px; margin-bottom: 5px;"><input type="text" style="width:80%; border: none; border-bottom: 1px solid black; font-weight: bold; text-align: center;" value="{{ $application->mayor }}"></p>
            <div style="margin-left: 410px;">Municipal Mayor</div>
            <div style="margin-left: 350px;">Chairman, MCH Franchise Committee</div>

            <br>

            <div>Amount <span style="margin-left: 20px">:</span></div>
            <div>O.R. No. <span style="margin-left: 19px">:</span></div>
            <div>Date <span style="margin-left: 42px">:</span></div>

</body>

</html>
