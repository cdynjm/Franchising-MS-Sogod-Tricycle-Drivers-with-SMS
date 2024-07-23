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
            <br>
            <h2 style="text-align: center">PERMIT</h2>
            <br>
        </center>

            <p><b>TO WHOM IT MAY CONCERN :</b></p>
            <p style="margin-left: 67px; margin-bottom: 5px;"><b>PERMISSION IS HEREBY GRANDTED</b> to <b style="margin-left: 50px;">{{ $application->applicant }}</b></p>
            <div>Legal age,single/married/widow,Filipino and a resident of <span style="margin-left: 10px;">{{ $application->address }}</span></div>
            <div>to operate one (1) unit motorcab-{{ $application->categories->category }} under Case No. <span style="margin-left: 50px; margin-right: 45px;">{{ $application->caseNumber }}</span>on the line</div>
            <div>within {{ $application->categories->description }}.</div>
            <br>
            <p style="margin-left: 67px; margin-bottom: 5px;"><b>PROVIDED HOWEVER, </b> that the law of the land pertaining thereto should be duly</p>
            <div>observed and the corresponding fee should be duly paid.</div>
            
            <p style="margin-left: 67px; margin-bottom: 5px;"><b>DONE</b> this <span style="margin-left: 60px;">{{ strtoupper(date('F d Y', strtotime($application->created_at))) }}</span><span style="margin-left: 60px;">Sogod, Southern Leyte, Philippines</span></p>

            <br><br>

            <p style="margin-left: 300px; margin-bottom: 5px;"><input type="text" style="width:80%; border: none; border-bottom: 1px solid black; font-weight: bold; text-align: center;" value="{{ $application->mayor }}"></p>
            <div style="margin-left: 410px;">Municipal Mayor</div>

            <div>NOTED :</div>
            <br>
            <p style="margin-left: 67px; margin-bottom: 5px;"><input type="text" style="width:50%; border: none; border-bottom: 1px solid black; font-weight: bold; text-align: center;" value="{{ $application->police }}"></p>
            <div style="margin-left: 180px;">Chief of Police</div>

            <p style="margin-bottom: 5px">Copy furnished :</p>
            <div style="margin-left: 120px;">Police Station</div>
            <div style="margin-left: 120px;">Sogod, Southern Leyte</div>
            
            <p style="margin-bottom: 5px;">O.R. No. :</p>
            <div>Amount Paid<span style="margin-left: 30px;">: ₱616.00</span></div>
            <div>Date<span style="margin-left: 83px;">: {{ strtoupper(date('F d Y', strtotime($application->created_at))) }}</span></div>

            <p style="margin-bottom: 5px;"><b>NOTE: </b><i style="margin-left: 70px;">This Permit is valid until <input type="text" style="width:30%; border: none; border-bottom: 1px solid black; font-weight: bold; text-align: center;" value="{{ strtoupper(date('F d Y', strtotime($application->expiresOn))) }}"> unless sooner revoked</i></p>
            <div style="margin-left: 112px;"><i>and/or cancelled for violation of existing laws or ordinance relative thereto.</i></div>
</body>

</html>
