<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SMSToken;

//this sms controller will serve as gateways of all sms to be sent to the applicant

class SMSController extends Controller
{
    //sms returns the token from the model
    public function sms() { return SMSToken::first(); }
    
    //confirm application sms
    public function SMSConfirmApplication($franchise) {

        $send_data = [];

        //START - Parameters to Change
        //Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        //Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        //Put message content here
        $send_data['message'] = "Hello, ".$franchise->applicant.". Your tricycle franchise with Sogod Franchising Office is confirmed. Please visit our office for signatures and payment.\n\nBody No.: ".$franchise->categories->category."-".sprintf('%03d', $franchise->user->name)."\n\nBring all required documents. Thank you!";
        //Put your API TOKEN here
        $token = $this->sms()->access_token;
        //END - Parameters to Change

        //No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

     /*   $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe are pleased to inform you that your application for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been confirmed. To complete the process, you are required to visit our office for signatures and payment.\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\n\nPlease ensure you bring the necessary documents and identification to facilitate a smooth process\nThank you for your cooperation.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } */
    }
    
    //approve application sms
    public function SMSApproveApplication($franchise) {
        
        $send_data = [];

        //START - Parameters to Change
        //Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        //Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        //Put message content here
        $send_data["message"] = "Hello, {$franchise->applicant}. Your tricycle franchise with Sogod has been approved. Please visit our office to claim it.\n\nBody No.: {$franchise->categories->category}-".sprintf('%03d', $franchise->user->name)."\nCase No.: {$franchise->caseNumber}\n\nBring a valid ID for verification. Congratulations, and drive safe!";
        //Put your API TOKEN here
        $token = $this->sms()->access_token;
        //END - Parameters to Change

        //No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

      /*  $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe are pleased to inform you that your application for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been approved.\n\nYour franchise is now ready for release. You are now required to visit our office to claim it.\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\nCase No.: '.$franchise->caseNumber.'\n\nPlease ensure you bring a valid ID for verification purposes.\n\nThank you for your cooperation and congratulations on your new franchise! Have a safe drive.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = [];
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } */
    }
    
    //reject application sms
    public function SMSRejectApplication($franchise, $comment) {
        
        $send_data = [];

        //START - Parameters to Change
        //Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        //Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        //Put message content here
        $send_data["message"] = "Hello, {$franchise->applicant}. Your tricycle franchise application was rejected due to: {$comment}. Please address the issues and resubmit. Visit our office for help.\n\nBody No.: {$franchise->categories->category}-".sprintf('%03d', $franchise->user->name)."\n\nThank you.";
        //Put your API TOKEN here
        $token = $this->sms()->access_token;
        //END - Parameters to Change

        //No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

       /* $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe regret to inform you that your application for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been rejected.\n\nAfter careful review, we have determined that your application does not meet the necessary requirements at this time due to the following reasons:\n\n'.$comment.'\n\nWe understand that this may be disappointing news, and we encourage you to address the mentioned issues and resubmit your application. If you need assistance, please do not hesitate to visit our office\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\n\nThank you for your cooperation.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = [];
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } */
    }




    //confirm renewal of application sms
    public function SMSConfirmRenewal($franchise) {
     
        $send_data = [];

        //START - Parameters to Change
        //Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        //Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        //Put message content here
        $send_data['message'] = "Hello, ".$franchise->applicant.". Your tricycle franchise renewal with Sogod Franchising Office is confirmed. Please visit our office for signatures and payment.\n\nBody No.: ".$franchise->categories->category."-".sprintf('%03d', $franchise->user->name)."\n\nBring all required documents. Thank you!";
        //Put your API TOKEN here
        $token = $this->sms()->access_token;
        //END - Parameters to Change

        //No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

    /*   $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe are pleased to inform you that your renewal for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been confirmed. To complete the process, you are required to visit our office for signatures and payment.\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\n\nPlease ensure you bring the necessary documents and identification to facilitate a smooth process\nThank you for your cooperation.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = [];
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } */
    }
    
    //approve renewal of application sms
    public function SMSApproveRenewal($franchise) {

        $send_data = [];

        //START - Parameters to Change
        //Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        //Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        //Put message content here
        $send_data["message"] = "Hello, {$franchise->applicant}. Your tricycle franchise renewal with Sogod has been approved. Please visit our office to claim it.\n\nBody No.: {$franchise->categories->category}-".sprintf('%03d', $franchise->user->name)."\nCase No.: {$franchise->caseNumber}\n\nBring a valid ID for verification. Congratulations, and drive safe!";
        //Put your API TOKEN here
        $token = $this->sms()->access_token;
        //END - Parameters to Change

        //No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

    /*  $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe are pleased to inform you that your renewal for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been approved.\n\nYour franchise is now ready for release. You are now required to visit our office to claim it.\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\nCase No.: '.$franchise->caseNumber.'\n\nPlease ensure you bring a valid ID for verification purposes.\n\nThank you for your cooperation and congratulations on your new franchise! Have a safe drive.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = [];
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } */
    }
    
    //reject renewal of application sms
    public function SMSRejectRenewal($franchise, $comment) {

        $send_data = [];

        //START - Parameters to Change
        //Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        //Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        //Put message content here
        $send_data["message"] = "Hello, {$franchise->applicant}. Your tricycle franchise renewal was rejected due to: {$comment}. Please address the issues and resubmit. Visit our office for help.\n\nBody No.: {$franchise->categories->category}-".sprintf('%03d', $franchise->user->name)."\n\nThank you.";
        //Put your API TOKEN here
        $token = $this->sms()->access_token;
        //END - Parameters to Change

        //No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

    /*    $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe regret to inform you that your renewal for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been rejected.\n\nAfter careful review, we have determined that your renewal does not meet the necessary requirements at this time due to the following reasons:\n\n- The images of the documents you uploaded were unclear and could not be properly verified.\n\n'.$comment.'\n\nWe understand that this may be disappointing news, and we encourage you to address the mentioned issues and resubmit your renewal. If you need assistance, please do not hesitate to visit our office\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\n\nThank you for your cooperation.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = [];
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } */
    }

    public function sendOTP($franchise, $passwordReset) {

        $send_data = [];

        //START - Parameters to Change
        //Put the SID here
        $send_data['sender_id'] = "PhilSMS";
        //Put the number or numbers here separated by comma w/ the country code +63
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        //Put message content here
        $send_data['message'] = "Hello, ".$franchise->applicant."\n\nYour OTP to reset your password is: ". $passwordReset->token;
        //Put your API TOKEN here
        $token = $this->sms()->access_token;
        //END - Parameters to Change

        //No more parameters to change below.
        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

     /*   $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe are pleased to inform you that your application for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been confirmed. To complete the process, you are required to visit our office for signatures and payment.\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\n\nPlease ensure you bring the necessary documents and identification to facilitate a smooth process\nThank you for your cooperation.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } */
    }
}
