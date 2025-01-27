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
            <br>
            <h2 style="text-align: center">PERMIT</h2>
            <br>
        </center>

            <p><b>TO WHOM IT MAY CONCERN :</b></p>
            <p style="text-indent: 50px; text-align: justify"><b>PERMISSION IS HEREBY GRANDTED</b> to <b style="text-decoration: underline">{{ $application->applicant }}</b> Legal age, single/married/widow, Filipino and a resident of <b style="text-decoration:underline">{{ $application->address }}</b> to operate one (1) unit motorcab <strong style="text-decoration: underline">{{ $application->categories->category }}-{{ $application->categories->color }}</strong> under Case No. <strong style="text-decoration: underline">{{ $application->caseNumber }}</strong> on the line
            within <strong style="text-decoration: underline">{{ $application->categories->description }}</strong>.
            </p>

            <br>
            <p style="text-indent: 50px"><b>PROVIDED HOWEVER, </b> that the law of the land pertaining thereto should be duly observed and the corresponding fee should be duly paid.</p>
            
            <p style="text-indent: 50px"><b>DONE</b> this <strong style="text-decoration: underline">{{ strtoupper(date('F d Y', strtotime($application->created_at))) }}</strong><span> Sogod, Southern Leyte, Philippines</span></p>

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
