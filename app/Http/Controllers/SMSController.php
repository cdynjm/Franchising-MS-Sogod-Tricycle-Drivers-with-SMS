<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SMSToken;

class SMSController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function sms() { return SMSToken::first(); }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function SMSConfirmApplication($franchise) {

        $mobile_iden = $this->sms()->mobile_identity;
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
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function SMSApproveApplication($franchise) {
        
        $mobile_iden = $this->sms()->mobile_identity;
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
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function SMSRejectApplication($franchise) {
        
        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe regret to inform you that your application for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been rejected.\n\nAfter careful review, we have determined that your application does not meet the necessary requirements at this time due to the following reasons:\n\n- The images of the documents you uploaded were unclear and could not be properly verified.\n- There were some typographical errors in your application form, which affected the accuracy and validity of the information provided.\n\nWe understand that this may be disappointing news, and we encourage you to address the mentioned issues and resubmit your application. If you need assistance, please do not hesitate to visit our office\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\n\nThank you for your cooperation.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
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
        }
    }




     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function SMSConfirmRenewal($franchise) {

        $mobile_iden = $this->sms()->mobile_identity;
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
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function SMSApproveRenewal($franchise) {

        $mobile_iden = $this->sms()->mobile_identity;
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
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function SMSRejectRenewal($franchise) {

        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $franchise->contactNumber;
        $sms = 'Greetings '.$franchise->applicant.',\n\nWe regret to inform you that your renewal for a tricycle unit franchise with the Franchising Office of Sogod, Southern Leyte, has been rejected.\n\nAfter careful review, we have determined that your renewal does not meet the necessary requirements at this time due to the following reasons:\n\n- The images of the documents you uploaded were unclear and could not be properly verified.\n- There were some typographical errors in your application form, which affected the accuracy and validity of the information provided.\n\nWe understand that this may be disappointing news, and we encourage you to address the mentioned issues and resubmit your renewal. If you need assistance, please do not hesitate to visit our office\n\nBody Number: '.$franchise->categories->category.'-'.sprintf('%03d', $franchise->user->name).'\n\nThank you for your cooperation.\n\nSincerely,\nFranchising Office of Sogod, Southern Leyte';
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
        }
    }
}
