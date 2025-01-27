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
            <br>

            <p style="text-align: center"><b>OFFICE OF THE MUNICIPAL MAYOR</b></p>

            <p style="text-align: center"><b>MCH FRANCHISE COMMITTEE</b></p>

            <p style="text-align: center"><b>CONFIRMATION/CERTIFICATION</b></p>
            
        </center>

            <p style="margin-bottom: 5px;"><b>TO WHOM IT MAY CONCERN :</b></p>
            <br>
            <p style="text-indent: 50px; text-align: justify; margin-bottom: 5px;"><b>THIS IS TO CERTIFY/CONFIRM</b> that <b style="text-decoration: underline">{{ $application->applicant }}</b> <span>is</span> authorized to operate a transport public utility Case No. <strong style="text-decoration: underline">{{ $application->caseNumber }} </strong>which </p>
            <br>
            <p><span style="margin-left: 67px; width: 60px; text-align: center; padding-left: 30px; padding-right: 30px; font-weight: bold; font-size: 15px; border: 2px solid black; color: black; display: inline">X</span><span style="margin-left: 50px;">UTOP is valid upto</span><input style="margin-left: 50px; border: none; border-bottom: 1px solid black; text-align: left" type="text" value="{{ strtoupper(date('M d Y', strtotime($application->expiresOn))) }}" readonly></p>
            <p><span style="margin-left: 67px; width: 60px; text-align: center; padding-left: 30px; padding-right: 30px; font-weight: bold; font-size: 15px; border: 2px solid black; color: white; display: inline">X</span><span style="margin-left: 50px;">PA is valid upto</span><input style="margin-left: 70px; border: none; border-bottom: 1px solid black; text-align: center" type="text" value="" readonly></p>
            <p><span style="margin-left: 67px; width: 60px; text-align: center; padding-left: 30px; padding-right: 30px; font-weight: bold; font-size: 15px; border: 2px solid black; color: white; display: inline">X</span><span style="margin-left: 50px;">Others (Specify)</span><input style="margin-left: 65px; border: none; border-bottom: 1px solid black; text-align: center" type="text" value="" readonly></p>

            <p style="margin-bottom: 5px; text-indent: 50px;">On the line within <strong style="text-decoration: underline">{{ $application->categories->description }}</strong> with the use of motorcab <strong style="text-decoration: underline;">{{ $application->categories->category }}-{{ $application->categories->color }}</strong> unit more particularly described as follows :</p>
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
            <p style="text-indent: 50px; margin-bottom: 5px; text-align: justify">Issued upon the request of the above-named operator for all legal intents and/or
            registration purposes.</p>

            <br>
            <p style="text-align: right; margin-right: 20px; margin-bottom: 10px; "><strong style="text-decoration: underline">{{ strtoupper(date('M. d Y', strtotime($application->created_at))) }}</strong></p>
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
