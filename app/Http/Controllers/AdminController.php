<?php

//this controller handles all the admin request from the client side

namespace App\Http\Controllers;

use Hash;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Http\Controllers\AESCipher;
use App\Http\Controllers\SMSController;

use App\Repositories\Interfaces\AdminInterface;

use App\Models\User;
use App\Models\Categories;
use App\Models\Franchise;
use App\Models\SMSToken;
use App\Models\Signature;
use App\Models\Barangay;
use App\Models\Municipal;
use App\Models\Province;
use App\Models\Region;

use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    //creates a constructor to use the interface, cipher for security and sms controller
    public function __construct(
        protected AESCipher $aes, 
        protected AdminInterface $AdminInterface,
        protected SMSController $sms
    ) {}

    //aes cipher will be used to encrypt data like IDs to prevent data breach and enhance security

    //this is where the dashboard data will be requested. it will return categories count from the repositories.
    public function dashboard() {
        $categories = $this->AdminInterface->categoriesCount();
        return view('pages.admin.dashboard', compact('categories'));
    }

    //list of all categories will go here. 
    public function categories() {
        $categories = $this->AdminInterface->categories();
        return view('pages.admin.categories', ['categories' => $categories]);
    }

    //renewal of franchise will be requested here.
    public function renewal() {
        $renewal = $this->AdminInterface->renewal();
        return view('pages.admin.renewal', compact('renewal'));
    }
    
    //list of all new applications
    public function newApplication() {
        $newApplication = $this->AdminInterface->newApplication();
        return view('pages.admin.new-application', compact('newApplication'));
    }
    
    //it will view the application for franchise
    public function viewApplication(Request $request) {
        $application = $this->AdminInterface->application($request);
        $categories = $this->AdminInterface->categories();
        return view('pages.admin.view-application', compact('application', 'categories'));
    }
    
    //generates form
    public function applicationForm(Request $request) {
        $application = $this->AdminInterface->application($request);
        return view('pages.admin.form.application-form', ['application' => $application]);
    }
   
    //generates form
   public function permitForm(Request $request) {
       $application = $this->AdminInterface->application($request);
       return view('pages.admin.form.permit-form', ['application' => $application]);
   }
  
   //generates form
    public function confirmationForm(Request $request) {
        $application = $this->AdminInterface->application($request);
        return view('pages.admin.form.confirmation-form', ['application' => $application]);
    }
    
    //generates form
    public function provisionalForm(Request $request) {
        $application = $this->AdminInterface->application($request);
        return view('pages.admin.form.provisional-form', ['application' => $application]);
    }
    
    //creates category
    public function createCategory(Request $request) {

        $timestamp = Carbon::now();

        $extension = $request->file('picture')->getClientOriginalExtension();
        $filename = \Str::slug($request->category.'-sample-'.$timestamp).'.'.$extension;
        $transferfile = $request->picture->storeAs('public/files/', $filename); 

        Categories::create([
            'category' => strtoupper($request->category),
            'color' => ucwords($request->color),
            'description' => $request->description,
            'picture' => $filename
        ]);

        $aes = $this->aes;
        $categories = $this->AdminInterface->categories();
        return response()->json([
            'Message' => 'Category added successfully',
            'Category' => view('data.admin.category-data', compact('aes', 'categories'))->render()
        ]);   
    }
    
    //update the category information
    public function updateCategory(Request $request) {

        $timestamp = Carbon::now();

        if(!empty($request->picture)) {
            $extension = $request->file('picture')->getClientOriginalExtension();
            $filename = \Str::slug($request->category.'-sample-'.$timestamp).'.'.$extension;
            $transferfile = $request->picture->storeAs('public/files/', $filename);

            Categories::where('id', $this->aes->decrypt($request->id))->update([
                'picture' => $filename
            ]);
        }

        Categories::where('id', $this->aes->decrypt($request->id))->update([
            'category' => strtoupper($request->category),
            'color' => ucwords($request->color),
            'description' => $request->description
        ]);

        $aes = $this->aes;
        $categories = $this->AdminInterface->categories();
        return response()->json([
            'Message' => 'Category updated successfully',
            'Category' => view('data.admin.category-data', compact('aes', 'categories'))->render()
        ]);   
    }
    
    //delete the category
    public function deleteCategory(Request $request) {

        Categories::where('id', $this->aes->decrypt($request->id))->delete();
        $aes = $this->aes;
        $categories = $this->AdminInterface->categories();
        return response()->json([
            'Message' => 'Category deleted successfully',
            'Category' => view('data.admin.category-data', compact('aes', 'categories'))->render()
        ]);   
    }
    
    //after registration of franchise application by the driver, the admin can confirm
    //the franchise applciation here for signatures.
    public function confirmFranchiseApplication(Request $request) {

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        $year = date('Y') + 1;

         User::where('id', $franchise->userID)->update(['status' => 1]);
        $unit = User::where('id', $franchise->userID)->first();

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 1,
            'caseNumber' => 'SO-'.date('Y').'-'.sprintf('%04d', $unit->name),
            'expiresOn' => $year.'-'.date('m-d H:i:s'),
            'signatureDate' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //it will sends an SMS to the applicant
        $this->sms->SMSConfirmApplication($franchise);

        return response()->json([
            'Message' => 'Franchise Application confirmed successfully for payment & signature. You can download and print the forms as follows:'
        ], Response::HTTP_OK);
    }
    
    //after confirmation. when all the signatures are completed, the admin can now approve the franchise application.
    public function approveFranchiseApplication(Request $request) {

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 2,
            'isActive' => 1,
            'releaseDate' => date('Y-m-d H:i:s'),
        ]);

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        //it will sends an SMS to the applicant
        $this->sms->SMSApproveApplication($franchise);

     /*   $files = [
            $franchise->validID,
            $franchise->clearanceFront,
            $franchise->clearanceBack,
            $franchise->officialReceipt,
            $franchise->certificate,
            $franchise->cardFront,
            $franchise->cardBack,
        ]; */
        
        /* foreach ($files as $file) {
            File::delete(public_path("storage/files/{$file}"));
        } */

        return response()->json([
            'Message' => 'Franchise Application has been approved successfully!'
        ], Response::HTTP_OK);
    }
    
    //the admin can also reject the franchise application when necessary
    public function rejectFranchiseApplication(Request $request) {

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        //it will sends an SMS to the applicant
        $this->sms->SMSRejectApplication($franchise, $request->comment);

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'comment' => $request->comment,
            'hasComment' => 1,
            'validIDcheck' => $request->proofOfCitizenship ?? null,
            'todaCheck' => $request->todaClearance ?? null,
            'driverCheck' => $request->driversID ?? null,
            'ORCheck' => $request->officialReceipt ?? null,
            'CRCheck' => $request->certificateOfRegistration ?? null,
        ]);

        return response()->json([
            'Message' => 'Franchise Application has been rejected successfully!'
        ], Response::HTTP_OK);
    }

    //confirmation of renewal. it will be done when the applicant will renew its franchise once expired
    public function confirmFranchiseRenewal(Request $request) {

        $year = date('Y') + 1;

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();
        $unit = User::where('id', $franchise->userID)->first();

        //it will sends an SMS to the applicant
        $this->sms->SMSConfirmRenewal($franchise);

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 4,
            'caseNumber' => 'SO-'.date('Y').'-'.sprintf('%04d', $unit->name),
            'expiresOn' => $year.'-'.date('m-d H:i:s'),
            'signatureDate' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
            'Message' => 'Franchise Renewal confirmed successfully for payment & signature. You can download and print the forms as follows:'
        ], Response::HTTP_OK);
    }
    
    //approve the franchise renewal after all the signatures is completed.
    public function approveFranchiseRenewal(Request $request) {

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 2,
            'isActive' => 1,
            'releaseDate' => date('Y-m-d H:i:s'),
        ]);

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        //it will sends an SMS to the applicant
        $this->sms->SMSApproveRenewal($franchise);

     /*   $files = [
            $franchise->validID,
            $franchise->clearanceFront,
            $franchise->clearanceBack,
            $franchise->officialReceipt,
            $franchise->certificate,
            $franchise->cardFront,
            $franchise->cardBack,
        ]; */
        
        /* foreach ($files as $file) {
            File::delete(public_path("storage/files/{$file}"));
        } */

        return response()->json([
            'Message' => 'Franchise Renewal has been approved successfully!'
        ], Response::HTTP_OK);
    }
    
    //reject the renewal if necessary
    public function rejectFranchiseRenewal(Request $request) {

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        //it will sends an SMS to the applicant
        $this->sms->SMSRejectRenewal($franchise, $request->comment);

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'comment' => $request->comment,
            'hasComment' => 1,
            'validIDcheck' => $request->proofOfCitizenship ?? null,
            'todaCheck' => $request->todaClearance ?? null,
            'driverCheck' => $request->driversID ?? null,
            'ORCheck' => $request->officialReceipt ?? null,
            'CRCheck' => $request->certificateOfRegistration ?? null,
        ]);

        return response()->json([
            'Message' => 'Franchise Renewal has been rejected successfully!'
        ], Response::HTTP_OK);
    }
    
    //in this section. it will view all the numbers/franchise under that specific category, like A,B,C etc.
    public function viewCategory(Request $request) {
        $category = $this->AdminInterface->getCategory($request);
        return view('pages.admin.view-category', ['category' => $category]);
    }
    
    //this area will view the franchise history of that specific body number/applicant
    public function viewFranchiseHistory(Request $request) {
        $account = $this->AdminInterface->getAccount($request);
        return view('pages.admin.view-franchise-history', ['account' => $account]);
    }
   
    //this will update the profile for the admin
    public function updateProfile(Request $request) {
       
        if(Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore(Auth::user()->id)
            ]
        ])->fails()) { 
            return response()->json(['Message' => 'Email is already taken'], Response::HTTP_INTERNAL_SERVER_ERROR);
         }

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if(!empty($request->password)) {
            Auth::user()->update(['password' => Hash::make($request->password)]);
        }
        
        return response()->json(['Message' => 'Your profile has been updated successfully!'], Response::HTTP_OK);
    }
    
    //updated the sms token if necessary
    public function smsToken(Request $request) {
       
        SMSToken::where('id', 1)->update([
            'access_token' => $request->token,
            'mobile_identity' => $request->mobile
        ]);
        
        return response()->json(['Message' => 'Your SMS token has been updated successfully!'], Response::HTTP_OK);
    }
    
    //updates the signatures if necessary
    public function updateSignature(Request $request) {
       
        Signature::where('id', 1)->update([
            'mayor' => strtoupper($request->mayor),
            'police' => strtoupper($request->police)
        ]);
        
        return response()->json(['Message' => 'Persons has been updated successfully!'], Response::HTTP_OK);
    }
    
    //renew franchise for walk-in process
    public function renewFranchise(Request $request) {
        $id = $request->id;
        $unit = $this->aes->decrypt($request->unit);
        $previousFranchise = $this->AdminInterface->previousFranchise($request);
        $region = Region::all();

      /*  if($previousFranchise->isActive == 0) {
            if($previousFranchise->status == 2)
                return view('pages.admin.renew-franchise', compact('unit', 'previousFranchise', 'id', 'region'));
            else
                return abort(404);
        }
        else
            return abort(404); */

        return view('pages.admin.renew-franchise', compact('unit', 'previousFranchise', 'id', 'region'));
    }

    //renew franchise for walk-in process
    public function changeOwnerMotor(Request $request) {
        $id = $request->id;
        $unit = $this->aes->decrypt($request->unit);
        $previousFranchise = $this->AdminInterface->previousFranchise($request);
        $region = Region::all();

      /*  if($previousFranchise->isActive == 0) {
            if($previousFranchise->status == 2)
                return view('pages.admin.renew-franchise', compact('unit', 'previousFranchise', 'id', 'region'));
            else
                return abort(404);
        }
        else
            return abort(404); */

        return view('pages.admin.renew-franchise', compact('unit', 'previousFranchise', 'id', 'region'));
    }
   
    //submit the renewal of franchise for walk-ins
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

        $user = User::where('id', $this->aes->decrypt($request->id))->first();

        Franchise::where('userID', $user->id)->update([
            'status' => 5,
            'isActive' => 5
        ]);
        
        $timestamp = Carbon::now();

        $validIDExtension = $request->file('validID')->getClientOriginalExtension();
        $validIDFileName = \Str::slug($user->email.'-valid-id-'.$timestamp).'.'.$validIDExtension;
        $transferfile = $request->validID->storeAs('public/files/', $validIDFileName); 

        $clearanceFrontExtension = $request->file('clearanceFront')->getClientOriginalExtension();
        $clearanceFrontFileName = \Str::slug($user->email.'-clearance-front-'.$timestamp).'.'.$clearanceFrontExtension;
        $transferfile = $request->clearanceFront->storeAs('public/files/', $clearanceFrontFileName); 

    /*  $clearanceBackExtension = $request->file('clearanceBack')->getClientOriginalExtension();
        $clearanceBackFileName = \Str::slug($user->email.'-clearance-back-'.$timestamp).'.'.$clearanceBackExtension;
        $transferfile = $request->clearanceBack->storeAs('public/files/', $clearanceBackFileName);  */

        $officialReceiptExtension = $request->file('officialReceipt')->getClientOriginalExtension();
        $officialReceiptFileName = \Str::slug($user->email.'-official-receipt-'.$timestamp).'.'.$officialReceiptExtension;
        $transferfile = $request->officialReceipt->storeAs('public/files/', $officialReceiptFileName); 

        $certificateExtension = $request->file('certificate')->getClientOriginalExtension();
        $certificateFileName = \Str::slug($user->email.'-certificate-'.$timestamp).'.'.$certificateExtension;
        $transferfile = $request->certificate->storeAs('public/files/', $certificateFileName); 

        $cardFrontExtension = $request->file('cardFront')->getClientOriginalExtension();
        $cardFrontFileName = \Str::slug($user->email.'-card-front-'.$timestamp).'.'.$cardFrontExtension;
        $transferfile = $request->cardFront->storeAs('public/files/', $cardFrontFileName); 

        $cardBackExtension = $request->file('cardBack')->getClientOriginalExtension();
        $cardBackFileName = \Str::slug($user->email.'-card-back-'.$timestamp).'.'.$cardBackExtension;
        $transferfile = $request->cardBack->storeAs('public/files/', $cardBackFileName); 

        $region = Region::where('regCode', $this->aes->decrypt($request->region))->first();
        $province = Province::where('provCode',$this->aes->decrypt($request->province))->first();
        $municipal = Municipal::where('citymunCode', $this->aes->decrypt($request->municipal))->first();
        $barangay = Barangay::where('brgyCode', $this->aes->decrypt($request->barangay))->first();

         Franchise::create([
            'userID' => $user->id,
          //  'password' => $this->AdminInterface->previousFranchise($request)->password,
            'code' => $user->email,
            'category' => $user->category,

            'applicant' => strtoupper($request->firstname) 
             . ' ' 
             . (!empty($request->middleinitial) ? strtoupper($request->middleinitial) . ' ' : '') 
             . strtoupper($request->lastname),

            'address' => strtoupper($barangay->brgyDesc) . ', ' . strtoupper($municipal->citymunDesc) . ', ' . strtoupper($province->provDesc) . ', ' . strtoupper($region->regDesc),             'contactNumber' => $request->contactNumber,
            'contactNumber' => $request->contactNumber,
            'make' => strtoupper($request->make),
            'motorNumber' => strtoupper($request->motorNumber),
            'chassisNumber' => strtoupper($request->chassisNumber),
            'plateNumber' => strtoupper($request->plateNumber),
            'validID' => $validIDFileName,
            'clearanceFront' => $clearanceFrontFileName,
          //  'clearanceBack' => $clearanceBackFileName,
            'officialReceipt' => $officialReceiptFileName,
            'certificate' => $certificateFileName,
            'cardFront' => $cardFrontFileName,
            'cardBack' => $cardBackFileName,
            'mayor' => $this->AdminInterface->signature()->mayor,
            'police' => $this->AdminInterface->signature()->police,
            'status' => 3,
            'isActive' => 0,
            'dateSubmitted' => date('Y-m-d H:i:s'),
         ]);

         return response()->json(
            ['Message' => 'Franchise renewal has been submitted successfully. Please wait for an SMS confirmation, which will be sent to the applicant once the office processes their request'], 
            Response::HTTP_OK
        );
    }

    //it will add the previous data/records
    public function addPreviousData() {
        $category = $this->AdminInterface->categories();
        $region = Region::all();
        return view('pages.admin.previous-data', ['category' => $category, 'region' => $region]);
    }


    //it will get the users based on the selected category
    public function getUsersByCategory(Request $request) {
        $user = $this->AdminInterface->getUsersByCategory($request);
        $aes = $this->aes;
        return response()->json([
            'Users' => view('pages.admin.user-accounts', compact('user', 'aes'))->render()
        ], Response::HTTP_OK);
    }

    //insert previous records to database
    public function createPreviousRecords(Request $request) {

        if($request->id == 1) {
            $exists = DB::table('users')
            ->where('name', $request->bodyNumber)
            ->where('category', $this->aes->decrypt($request->category))
            ->exists();
        
            if ($exists) {
                return response()->json(['Message' => 'The body number is already registered. Duplication of account is not allowed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Check for duplicate chassis number or plate number
            $duplicateChassis = DB::table('franchise')->where('chassisNumber', strtoupper($request->chassisNumber))->exists();
            $duplicatePlate = DB::table('franchise')->where('plateNumber', strtoupper($request->plateNumber))->exists();

            if ($duplicateChassis) {
                return response()->json(['Message' => 'The chassis number is already registered. Duplication of data is not allowed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($duplicatePlate) {
                return response()->json(['Message' => 'The plate number is already registered. Duplication of data is not allowed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $user = User::create([
                'name' => $request->bodyNumber,
                'category' => $this->aes->decrypt($request->category),
                'email' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 2,
                'status' => 1
            ]);

            $region = Region::where('regCode', $this->aes->decrypt($request->region))->first();
            $province = Province::where('provCode',$this->aes->decrypt($request->province))->first();
            $municipal = Municipal::where('citymunCode', $this->aes->decrypt($request->municipal))->first();
            $barangay = Barangay::where('brgyCode', $this->aes->decrypt($request->barangay))->first();

            Franchise::create([
                'userID' => $user->id,
               // 'password' => $request->password,
                'code' => $request->username,
                'category' => $this->aes->decrypt($request->category),
                'applicant' => strtoupper($request->firstname) 
                . ' ' 
                . (!empty($request->middleinitial) ? strtoupper($request->middleinitial) . ' ' : '') 
                . strtoupper($request->lastname),

                'address' => strtoupper($barangay->brgyDesc) . ', ' . strtoupper($municipal->citymunDesc) . ', ' . strtoupper($province->provDesc) . ', ' . strtoupper($region->regDesc),
                'contactNumber' => $request->contactNumber,
                'caseNumber' => 'SO-'.date('Y', strtotime($request->renew)).'-'.sprintf('%04d', $request->bodyNumber),
                'make' => strtoupper($request->make),
                'motorNumber' => strtoupper($request->motorNumber),
                'chassisNumber' => strtoupper($request->chassisNumber),
                'plateNumber' => strtoupper($request->plateNumber),
                'mayor' => strtoupper($request->mayor),
                'police' => strtoupper($request->police),
                'status' => 2,
                'isActive' => 1,
                'signatureDate' => $request->renew,
                'dateSubmitted' => $request->renew,
                'releaseDate' => $request->renew,
                'expiresOn' => $request->expire,
                'created_at' => $request->renew
             ]);
    
             return response()->json(
                ['Message' => 'Records Inserted Successfully'], 
                Response::HTTP_OK
            );
            
        }
        else {
            $status = 0;
            $isActive = 0;

            if($request->expire < date('Y-m-d')) {
                $franchise = Franchise::where('userID', $this->aes->decrypt($request->id))
                    ->orderBy('expiresOn', 'DESC')
                    ->first();

                if($franchise->expiresOn != null) {  
                    if($request->expire < date('Y-m-d', strtotime($franchise->expiresOn))) {
                        $status = 5;
                        $isActive = 5;
                    }


                    if($request->expire > date('Y-m-d', strtotime($franchise->expiresOn))) {
                        $status = 2;
                        $isActive = 0;

                        Franchise::where('userID', $this->aes->decrypt($request->id))
                        ->update([
                            'status' => 5,
                            'isActive' => 5,
                        ]);
                    }
                }
                else {
                    $status = 5;
                    $isActive = 5;
                }

            }
            else {
                $status = 2;
                $isActive = 1;

                Franchise::where('userID', $this->aes->decrypt($request->id))
                    ->update([
                        'status' => 5,
                        'isActive' => 5,
                    ]);
            }

            $region = Region::where('regCode', $this->aes->decrypt($request->region))->first();
            $province = Province::where('provCode',$this->aes->decrypt($request->province))->first();
            $municipal = Municipal::where('citymunCode', $this->aes->decrypt($request->municipal))->first();
            $barangay = Barangay::where('brgyCode', $this->aes->decrypt($request->barangay))->first();

            $unit = User::where('id', $this->aes->decrypt($request->id))->first();

            Franchise::create([
                'userID' => $this->aes->decrypt($request->id),
              //  'password' => $this->AdminInterface->previousFranchise($request)->password,
                'code' => $this->AdminInterface->previousFranchise($request)->code,
                'category' => $this->aes->decrypt($request->category),

                'applicant' => strtoupper($request->firstname) 
                . ' ' 
                . (!empty($request->middleinitial) ? strtoupper($request->middleinitial) . ' ' : '') 
                . strtoupper($request->lastname),

                'address' => strtoupper($barangay->brgyDesc) . ', ' . strtoupper($municipal->citymunDesc) . ', ' . strtoupper($province->provDesc) . ', ' . strtoupper($region->regDesc),
                'contactNumber' => $request->contactNumber,
                'caseNumber' => 'SO-'.date('Y', strtotime($request->renew)).'-'.sprintf('%04d', $unit->name),
                'make' => strtoupper($request->make),
                'motorNumber' => strtoupper($request->motorNumber),
                'chassisNumber' => strtoupper($request->chassisNumber),
                'plateNumber' => strtoupper($request->plateNumber),
                'mayor' => strtoupper($request->mayor),
                'police' => strtoupper($request->police),
                'status' => $status,
                'isActive' => $isActive,
                'expiresOn' => $request->expire,
                'signatureDate' => $request->renew,
                'dateSubmitted' => $request->renew,
                'releaseDate' => $request->renew,
                'created_at' => $request->renew
             ]);
    
             return response()->json(
                ['Message' => 'Records Inserted Successfully'], 
                Response::HTTP_OK
            );
        }
    }

    //generates reports
    public function reports(Request $request) {

        if (!isset($request->printAll)) {
            // Fetch data based on year and optional month
            $query = Franchise::where('category', $this->aes->decrypt($request->category))
                ->whereYear('created_at', $request->year);

            if (!empty($request->month)) {
                $query->whereMonth('created_at', $request->month);
            }

            $franchise = $query->orderBy('created_at', 'DESC')->get();

            if ($franchise->isEmpty()) {
                return response()->json(['message' => 'No data available to download.'], 204);
            }

            return view('pages.admin.reports', [
                'franchise' => $franchise,
                'month' => $request->month,
                'year' => $request->year
            ]);
        } else {
            $franchise = Franchise::with('categories') // Eager load categories
                ->orderBy('category') // Order by category
                ->orderBy('created_at', 'DESC') // Order by year (descending)
                ->get()
                ->groupBy([
                    function ($item) {
                        return $item->categories->category; // Group by category
                    },
                    function ($item) {
                        return date('Y', strtotime($item->created_at)); // Group by year
                    }
                ]);

            return view('pages.admin.reports', [
                'franchiseGroups' => $franchise,
                'printAll' => true
            ]);

        }
    }


    public function getDataAnalyticsUsers(Request $request) {
        
        if($request->statusID == 0) {
            $users = Franchise::where('category', $request->categoryID)
            ->where('status', 2)
            ->where('isActive', 1)
            ->orderBy('code', 'ASC')
            ->get();
        }

        if ($request->statusID == 1) {
            $users = Franchise::where('category', $request->categoryID)
                ->where('isActive', 0)
                ->where(function($query) {
                    $query->where('status', 2)
                          ->orWhere('status', 0)
                          ->orWhere('status', 1)
                          ->orWhere('status', 3)
                          ->orWhere('status', 4);
                })
                ->orderBy('code', 'ASC')
                ->get();
        }
        

        return response()->json([
            'users' => $users
        ]);
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
    
}

