@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download QRCode</title>
    <style>
        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 20px;
        }
        .header-content {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .header-content img {
            width: 80px;
        }
        .qr-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3px;
            border: 6px solid black;
            border-radius: 8px;
            position: relative; /* Make the QR container position relative for overlay */
        }
        .qr-box {
            border: 5px double black;
            border-radius: 5px;
            padding: 2px;
            display: inline-block;
        }
        .qr-logo-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width:100px; /* Adjust the size of the logo */
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            background: white; /* Background for better contrast with QR code */
        }
        .qr-logo-overlay img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .description-text {
            margin-top: 15px;
            font-size: 1rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="header-content">
           
            <div>
                <div>Republic of the Philippines</div>
                <div>PROVINCE OF SOUTHERN LEYTE</div>
                <div>Municipality of Sogod</div>
            </div>
        </div>
        
        <div class="qr-container">
            <div class="qr-box">
                {!! QrCode::size(400)->generate(
                    'Driver Name: ' . $user->applicant . "\n" .
                    'Address: ' . $user->address . "\n" .
                    'Contact Number: ' . $user->contactNumber . "\n" .
                    'Vehicle: ' . $user->make . "\n" .
                    'Motor Number: ' . $user->motorNumber . "\n" .
                    'Chassis Number: ' . $user->chassisNumber . "\n" .
                    'Plate Number: ' . $user->plateNumber . "\n" .
                    'Route: ' . $user->categories->description . "\n" .
                    'Valid Until: ' . date('F d, Y', strtotime($user->expiresOn))
                ) !!}
            </div>

            <!-- Logo Overlay -->
            <div class="qr-logo-overlay">
                <img src="{{ asset('storage/logo/logo-sogod.png') }}" alt="QR Code Logo">
            </div>
        </div>

        <p class="description-text">This QR code contains the driver’s information.</p>
    </div>
</body>
</html>
