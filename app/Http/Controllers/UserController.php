<?php

namespace App\Http\Controllers;

//this controller handles all the user request from the client side

use Hash;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AESCipher;

use App\Repositories\Interfaces\UserInterface;

use App\Models\User;
use App\Models\Categories;
use App\Models\Franchise;

use App\Models\Barangay;
use App\Models\Municipal;
use App\Models\Province;
use App\Models\Region;

use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    
    //creates a constructor to use the interface, cipher for security and sms controller
    public function __construct(
        protected AESCipher $aes, 
        protected UserInterface $UserInterface
    ) {}
   
    //aes cipher will be used to encrypt data like IDs to prevent data breach and enhance security

    //this is where the dashboard data will be requested.
    public function dashboard() {
        $user = $this->UserInterface->activeUser();
        return view('pages.user.dashboard', ['user' => $user]);
    }
    
    //this is where the use will renew their franchise once expired rather that walking in to process their request.
    public function renewFranchise(Request $request) {
        $unit = $this->aes->decrypt($request->unit);
        $previousFranchise = $this->UserInterface->previousFranchise();

        $region = Region::all();

        if($previousFranchise->isActive == 0) {
            if($previousFranchise->status == 2)
                return view('pages.user.renew-franchise', compact('unit', 'previousFranchise', 'region'));
            else
                return abort(404);
        }
        else
            return abort(404);
        
    }

    public function Province(Request $request) {
        $code = $this->aes->decrypt($request->code);
        $province = Province::where('regCode', $code)->get();
        $aes = $this->aes;
        return response()->json([
            'Province' => view('auth.address.province', compact('aes', 'province'))->render()
        ], Response::HTTP_OK);
    }
   
    public function Municipal(Request $request) {
        $code = $this->aes->decrypt($request->code);
        $municipal = Municipal::where('provCode', $code)->get();
        $aes = $this->aes;
        return response()->json([
            'Municipal' => view('auth.address.municipal', compact('aes', 'municipal'))->render()
        ], Response::HTTP_OK);
    }
   
    public function Barangay(Request $request) {
        $code = $this->aes->decrypt($request->code);
        $barangay = Barangay::where('citymunCode', $code)->get();
        $aes = $this->aes;
        return response()->json([
            'Barangay' => view('auth.address.barangay', compact('aes', 'barangay'))->render()
        ], Response::HTTP_OK);
    }
    
    //submit their renewal application 
    public function submitRenewal(Request $request) {

        if($request->unitStatus == 0) {
            // Check for duplicate chassis number or plate number
            $duplicateChassis = DB::table('franchise')->where('chassisNumber', strtoupper($request->chassisNumber))->exists();
            $duplicatePlate = DB::table('franchise')->where('plateNumber', strtoupper($request->plateNumber))->exists();

            if ($duplicateChassis) {
                return response()->json(['Message' => 'The chassis number is already registered. Duplication of data is not allowed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($duplicatePlate) {
                return response()->json(['Message' => 'The plate number is already registered. Duplication of data is not allowed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        Franchise::where('userID', Auth::user()->id)->update([
            'status' => 5,
            'isActive' => 5
        ]);
        
        $timestamp = Carbon::now();

        $validIDExtension = $request->file('validID')->getClientOriginalExtension();
        $validIDFileName = \Str::slug(Auth::user()->email.'-valid-id-'.$timestamp).'.'.$validIDExtension;
        $transferfile = $request->validID->storeAs('public/files/', $validIDFileName); 

        $clearanceFrontExtension = $request->file('clearanceFront')->getClientOriginalExtension();
        $clearanceFrontFileName = \Str::slug(Auth::user()->email.'-clearance-front-'.$timestamp).'.'.$clearanceFrontExtension;
        $transferfile = $request->clearanceFront->storeAs('public/files/', $clearanceFrontFileName); 

    /*    $clearanceBackExtension = $request->file('clearanceBack')->getClientOriginalExtension();
        $clearanceBackFileName = \Str::slug(Auth::user()->email.'-clearance-back-'.$timestamp).'.'.$clearanceBackExtension;
        $transferfile = $request->clearanceBack->storeAs('public/files/', $clearanceBackFileName); */

        $officialReceiptExtension = $request->file('officialReceipt')->getClientOriginalExtension();
        $officialReceiptFileName = \Str::slug(Auth::user()->email.'-official-receipt-'.$timestamp).'.'.$officialReceiptExtension;
        $transferfile = $request->officialReceipt->storeAs('public/files/', $officialReceiptFileName); 

        $certificateExtension = $request->file('certificate')->getClientOriginalExtension();
        $certificateFileName = \Str::slug(Auth::user()->email.'-certificate-'.$timestamp).'.'.$certificateExtension;
        $transferfile = $request->certificate->storeAs('public/files/', $certificateFileName); 

        $cardFrontExtension = $request->file('cardFront')->getClientOriginalExtension();
        $cardFrontFileName = \Str::slug(Auth::user()->email.'-card-front-'.$timestamp).'.'.$cardFrontExtension;
        $transferfile = $request->cardFront->storeAs('public/files/', $cardFrontFileName); 

        $cardBackExtension = $request->file('cardBack')->getClientOriginalExtension();
        $cardBackFileName = \Str::slug(Auth::user()->email.'-card-back-'.$timestamp).'.'.$cardBackExtension;
        $transferfile = $request->cardBack->storeAs('public/files/', $cardBackFileName); 

        $region = Region::where('regCode', $this->aes->decrypt($request->region))->first();
        $province = Province::where('provCode',$this->aes->decrypt($request->province))->first();
        $municipal = Municipal::where('citymunCode', $this->aes->decrypt($request->municipal))->first();
        $barangay = Barangay::where('brgyCode', $this->aes->decrypt($request->barangay))->first();

         Franchise::create([
            'userID' => Auth::user()->id,
          //  'password' => $this->UserInterface->previousFranchise()->password,
            'code' => Auth::user()->email,
            'category' => Auth::user()->category,
            
            'applicant' => strtoupper($request->firstname) 
             . ' ' 
             . (!empty($request->middleinitial) ? strtoupper($request->middleinitial) . ' ' : '') 
             . strtoupper($request->lastname),

            'address' => strtoupper($barangay->brgyDesc) . ', ' . strtoupper($municipal->citymunDesc) . ', ' . strtoupper($province->provDesc) . ', ' . strtoupper($region->regDesc),

            'contactNumber' => $request->contactNumber,
            'make' => strtoupper($request->make),
            'motorNumber' => strtoupper($request->motorNumber),
            'chassisNumber' => strtoupper($request->chassisNumber),
            'plateNumber' => strtoupper($request->plateNumber),
            'validID' => $validIDFileName,
            'clearanceFront' => $clearanceFrontFileName,
     //       'clearanceBack' => $clearanceBackFileName,
            'officialReceipt' => $officialReceiptFileName,
            'certificate' => $certificateFileName,
            'cardFront' => $cardFrontFileName,
            'cardBack' => $cardBackFileName,
            'mayor' => $this->UserInterface->signature()->mayor,
            'police' => $this->UserInterface->signature()->police,
            'status' => 3,
            'isActive' => 0,
            'dateSubmitted' => date('Y-m-d H:i:s'),
         ]);

         return response()->json(
            ['Message' => 'Your franchise renewal has been submitted successfully. Please wait for an SMS confirmation, which will be sent to you once the office processes your request'], 
            Response::HTTP_OK
        );
    }
     
    //this is where they can view the renewal history of their body number
    public function renewalHistory(Request $request) {
        $franchise = $this->UserInterface->franchiseHistory($request);
        return view('pages.user.view-franchise-history', compact('franchise'));
    }
    
    //view application and information of the franchise
    public function viewApplication(Request $request) {
        $application = $this->UserInterface->application($request);
        $categories = $this->UserInterface->categories();
        return view('pages.user.view-application', compact('application', 'categories'));
    }
   
    //update their password when needed.
    public function updateProfile(Request $request) {

        if(!empty($request->password)) {
            Auth::user()->update(['password' => Hash::make($request->password)]);
            Franchise::where('userID', Auth::user()->id)->update(['password' => $request->password]);
        }
        
        return response()->json(['Message' => 'Your password has been updated successfully!'], Response::HTTP_OK);
    }

    //edit application
    public function editApplication(Request $request) {
        $application = Franchise::where('id', $this->aes->decrypt($request->id))->first();
        $categories = $this->UserInterface->categories();
        return view('pages.user.edit-application', compact('application', 'categories'));
    }

    //resubmit application
    public function resubmitApplication(Request $request) {

        $exists = DB::table('users')
            ->where('name', $request->bodyNumber)
            ->where('category', $this->aes->decrypt($request->category))
            ->where(function ($query) {
                $query->where('name', '!=', Auth::user()->name)
                    ->orWhere('category', '!=', Auth::user()->category);
            })
            ->exists();

        if ($exists) {
            return response()->json(['Message' => 'The body number is already registered. Duplication of account is not allowed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        $timestamp = Carbon::now();

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'applicant' => strtoupper($request->applicant),
            'address' => strtoupper($request->address),
            'contactNumber' => $request->contactNumber,
            'make' => strtoupper($request->make),
            'motorNumber' => strtoupper($request->motorNumber),
            'chassisNumber' => strtoupper($request->chassisNumber),
            'plateNumber' => strtoupper($request->plateNumber),
            'comment' => null,
            'hasComment' => null,
            'validIDcheck' => null,
            'todaCheck' => null,
            'driverCheck' => null,
            'ORCheck' => null,
            'CRCheck' => null,
            'dateSubmitted' => date('Y-m-d H:i:s'),
         ]);

        if(!empty($request->file('validID'))) {
            $validIDExtension = $request->file('validID')->getClientOriginalExtension();
            $validIDFileName = \Str::slug(Auth::user()->email.'-valid-id-'.$timestamp).'.'.$validIDExtension;
            $transferfile = $request->validID->storeAs('public/files/', $validIDFileName);

            Franchise::where('id', $this->aes->decrypt($request->id))->update(['validID' => $validIDFileName]);
        }

        if(!empty($request->file('clearanceFront'))) {
            $clearanceFrontExtension = $request->file('clearanceFront')->getClientOriginalExtension();
            $clearanceFrontFileName = \Str::slug(Auth::user()->email.'-clearance-front-'.$timestamp).'.'.$clearanceFrontExtension;
            $transferfile = $request->clearanceFront->storeAs('public/files/', $clearanceFrontFileName); 

            Franchise::where('id', $this->aes->decrypt($request->id))->update(['clearanceFront' => $clearanceFrontFileName]);

        }

    /*    if(!empty($request->file('clearanceBack'))) {
            $clearanceBackExtension = $request->file('clearanceBack')->getClientOriginalExtension();
            $clearanceBackFileName = \Str::slug(Auth::user()->email.'-clearance-back-'.$timestamp).'.'.$clearanceBackExtension;
            $transferfile = $request->clearanceBack->storeAs('public/files/', $clearanceBackFileName); 

            Franchise::where('id', $this->aes->decrypt($request->id))->update(['clearanceBack' => $clearanceBackFileName]);

        } */

        if(!empty($request->file('officialReceipt'))) {
            $officialReceiptExtension = $request->file('officialReceipt')->getClientOriginalExtension();
            $officialReceiptFileName = \Str::slug(Auth::user()->email.'-official-receipt-'.$timestamp).'.'.$officialReceiptExtension;
            $transferfile = $request->officialReceipt->storeAs('public/files/', $officialReceiptFileName); 

            Franchise::where('id', $this->aes->decrypt($request->id))->update(['officialReceipt' => $officialReceiptFileName]);

        }

        if(!empty($request->file('certificate'))) {
            $certificateExtension = $request->file('certificate')->getClientOriginalExtension();
            $certificateFileName = \Str::slug(Auth::user()->email.'-certificate-'.$timestamp).'.'.$certificateExtension;
            $transferfile = $request->certificate->storeAs('public/files/', $certificateFileName); 

            Franchise::where('id', $this->aes->decrypt($request->id))->update(['certificate' => $certificateFileName]);
        }

        if(!empty($request->file('cardFront'))) {
            $cardFrontExtension = $request->file('cardFront')->getClientOriginalExtension();
            $cardFrontFileName = \Str::slug(Auth::user()->email.'-card-front-'.$timestamp).'.'.$cardFrontExtension;
            $transferfile = $request->cardFront->storeAs('public/files/', $cardFrontFileName); 

            Franchise::where('id', $this->aes->decrypt($request->id))->update(['cardFront' => $cardFrontFileName]);

        }

        if(!empty($request->file('cardBack'))) {
            $cardBackExtension = $request->file('cardBack')->getClientOriginalExtension();
            $cardBackFileName = \Str::slug(Auth::user()->email.'-card-back-'.$timestamp).'.'.$cardBackExtension;
            $transferfile = $request->cardBack->storeAs('public/files/', $cardBackFileName); 

            Franchise::where('id', $this->aes->decrypt($request->id))->update(['cardBack' => $cardBackFileName]);

        }

        return response()->json(
            ['Message' => 'Your application has been resubmitted successfully. Please wait for an SMS confirmation, which will be sent to you once the office processes your request'], 
            Response::HTTP_OK
        );
    }

    //generates form
    public function applicationForm(Request $request) {
        $application = $this->UserInterface->application($request);
        return view('pages.admin.form.application-form', ['application' => $application]);
    }
   
    //generates form
   public function permitForm(Request $request) {
       $application = $this->UserInterface->application($request);
       return view('pages.admin.form.permit-form', ['application' => $application]);
   }
  
   //generates form
    public function confirmationForm(Request $request) {
        $application = $this->UserInterface->application($request);
        return view('pages.admin.form.confirmation-form', ['application' => $application]);
    }
    
    //generates form
    public function provisionalForm(Request $request) {
        $application = $this->UserInterface->application($request);
        return view('pages.admin.form.provisional-form', ['application' => $application]);
    }

    //upload forms
    public function uploadForms(Request $request) {
        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();
        return view('pages.user.upload-forms', ['franchise' => $franchise]);
    }

    //upload forms to database
    public function uploadFormSignature(Request $request) {

        $timestamp = Carbon::now();

        $applicationFormExtension = $request->file('applicationForm')->getClientOriginalExtension();
        $applicationFormFileName = \Str::slug(Auth::user()->email.'-application-form-signature-'.$timestamp).'.'.$applicationFormExtension;
        $transferfile = $request->applicationForm->storeAs('public/files/', $applicationFormFileName);

        $permitFormExtension = $request->file('permitForm')->getClientOriginalExtension();
        $permitFormFileName = \Str::slug(Auth::user()->email.'-permit-form-signature-'.$timestamp).'.'.$permitFormExtension;
        $transferfile = $request->permitForm->storeAs('public/files/', $permitFormFileName);

        $confirmationFormExtension = $request->file('confirmationForm')->getClientOriginalExtension();
        $confirmationFormFileName = \Str::slug(Auth::user()->email.'-confirmation-form-signature-'.$timestamp).'.'.$confirmationFormExtension;
        $transferfile = $request->confirmationForm->storeAs('public/files/', $confirmationFormFileName);

        $provisionalFormExtension = $request->file('provisionalForm')->getClientOriginalExtension();
        $provisionalFormFileName = \Str::slug(Auth::user()->email.'-provisional-form-signature-'.$timestamp).'.'.$provisionalFormExtension;
        $transferfile = $request->provisionalForm->storeAs('public/files/', $provisionalFormFileName);

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'applciationForm' => $applicationFormFileName,
            'permitForm' => $permitFormFileName,
            'confirmationForm' => $confirmationFormFileName,
            'provisionalForm' => $provisionalFormFileName,
        ]);

        return response()->json(
            ['Message' => 'Forms has been uploaded successfully'], 
            Response::HTTP_OK
        );

    }

    public function downloadQRCode() {
        $user = $this->UserInterface->activeUser();
        return view('pages.user.download-QRCode', ['user' => $user]);
    }
}
