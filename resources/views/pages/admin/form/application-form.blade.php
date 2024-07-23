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
            <table>
                <tr>
                    <th>
                        <center>{{ $application->applicant }}</center>
                    </th>
                    <th style="border-top: 0; border-bottom: 0; color: white">-----</th>
                    <th style="font-weight: normal">
                        <center>{{ $application->caseNumber }}</center>
                    </th>
                    <th style="font-weight: normal" width="14%">
                        <center>{{ $application->user->categories->category }}</center>
                    </th>
                </tr>
                <tr>
                    <td>Applicant</td>
                    <td></td>
                    <td>Case No.</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="border-bottom: 1px solid black">
                        {{ $application->user->name }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left"><i>Application for a Special</i></td>
                    <td></td>
                    <td>Body No.</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left"><i>Authority to operate a</i></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left"><i>Motorized Tricycle Service</i></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                <tr>
                    <td style="text-align: left"><i>x----------------------------x</i></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tr>
            </table>

            <p style="margin-top: 5px"><b>APPLICATION</b></p>

            <div style="text-align: left">
                <b>COMES NOW, </b>
                the Applicant and unto this Honorable Board, most respectfully averst:

                <br>
                <br>

                <div style="margin-left: 27px">1 <span style="margin-left: 27px;">That He/She is legal age, Filipino,
                        married/single and with residence at</span></div>
                <div style="margin-left: 190px;">{{ $application->address }}</div>
                <div style="margin-left: 27px">2 <span style="margin-left: 27px;">That He/She is request authority to
                        operate a motorized tricycle service within the</span></div>
                <div style="margin-left: 66px">Municipality of Sogod, So, Leyte except on the National Highway with the
                    use of</div>
                <div style="margin-left: 66px">one (1) unit specially describes as follows : </div>
                <br>
                <table id="unit">
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
                <div style="margin-left: 27px">3 <span style="margin-left: 27px;">That He/She is legally qualified and
                        financially capable to operate and maintain the</span></div>
                <div style="margin-left: 66px">proposed service;</div>
                <div style="margin-left: 27px">4 <span style="margin-left: 27px;">That public necessity and convenience
                        will be served in a proper and suitable</span></div>
                <div style="margin-left: 66px">manner with the approval of this application;</div>
                <div style="margin-left: 27px">5 <span style="margin-left: 27px;">That He/She will abide and comply with
                        the provision of the Public Service Act as</span></div>
                <div style="margin-left: 66px">ammended and the rules and regulations of the Board governing the said
                    services;</div>
                <div style="margin-left: 27px">6 <span style="margin-left: 27px;">That annexed to this application are
                        the documents required by the Board for the</span></div>
                <div style="margin-left: 66px">legalization of motorized tricycle services;</div>
                <br>
                <div style="margin-left: 66px"><b>WHEREOF, </b> premises considered, it is most respectfully prayed that
                    after due</div>
                <div>consideration of the application , a Special Authority be issued by the Board thereof.</div>
                <br>
                <div style="margin-left: 66px">Sogod, Southern Leyte, Philippines, <span
                        style="margin-left: 80px">{{ strtoupper(date('F d Y', strtotime($application->created_at))) }}</span></div>
                <br><br>
                <div style="margin-left: 383px"><input type="text" style="width:80%; border: none; border-bottom: 1px solid black; font-weight: bold; text-align: center;" value="{{ $application->applicant }}"></div>
                <div style="margin-left: 450px">Signature of Applicant</div>
                <div>Annexes :</div>
                <div style="margin-left: 27px">A <span style="margin-left: 27px;"><i>Proof of Citizenship - Voter's
                            ID/Voter's Affidavit/Birth Certificate</i></span></div>
                <div style="margin-left: 27px">B <span style="margin-left: 27px;"><i>Proof of Ownership - Certificate of
                            Registration/Invoice Receipt</i></span></div>
                <div style="margin-left: 27px">C <span style="margin-left: 27px;"><i>Mayor's Permit</i></span></div>
                <div style="margin-left: 27px">D <span style="margin-left: 27px;"><i>Deed of Sale</i></span></div>
            </div>
        </center>
    </div>
</body>

</html>
