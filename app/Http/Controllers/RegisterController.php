<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AESCipher;

use App\Repositories\Interfaces\UserInterface;

use App\Models\User;
use App\Models\Categories;
use App\Models\Franchise;
use App\Models\Barangay;
use App\Models\Municipal;
use App\Models\Province;
use App\Models\Region;

//this controller will register franchise applications.

class RegisterController extends Controller
{
    //creates a constructor to use the interface, cipher for security
    public function __construct(
        protected AESCipher $aes, 
        protected UserInterface $UserInterface
    ) {}
    //aes cipher will be used to encrypt data like IDs to prevent data breach and enhance security

    //register. it will first send a request for all the categories (A,B,C etc,) so that the applicant will only select categories during application
    public function register(Request $request) {
        $region = Region::all();
        $categories = $this->UserInterface->categories();
        return view('auth.register', ['categories' => $categories, 'region' => $region]);
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

    //submits the franchise application
    public function submitApplication(Request $request) {

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
            'status' => 0
         ]);


        $timestamp = Carbon::now();

        $validIDExtension = $request->file('validID')->getClientOriginalExtension();
        $validIDFileName = \Str::slug($request->username.'-valid-id-'.$timestamp).'.'.$validIDExtension;
        $transferfile = $request->validID->storeAs('public/files/', $validIDFileName); 

        $clearanceFrontExtension = $request->file('clearanceFront')->getClientOriginalExtension();
        $clearanceFrontFileName = \Str::slug($request->username.'-clearance-front-'.$timestamp).'.'.$clearanceFrontExtension;
        $transferfile = $request->clearanceFront->storeAs('public/files/', $clearanceFrontFileName); 

     /*   $clearanceBackExtension = $request->file('clearanceBack')->getClientOriginalExtension();
        $clearanceBackFileName = \Str::slug($request->username.'-clearance-back-'.$timestamp).'.'.$clearanceBackExtension;
        $transferfile = $request->clearanceBack->storeAs('public/files/', $clearanceBackFileName); */

        $officialReceiptExtension = $request->file('officialReceipt')->getClientOriginalExtension();
        $officialReceiptFileName = \Str::slug($request->username.'-official-receipt-'.$timestamp).'.'.$officialReceiptExtension;
        $transferfile = $request->officialReceipt->storeAs('public/files/', $officialReceiptFileName); 

        $certificateExtension = $request->file('certificate')->getClientOriginalExtension();
        $certificateFileName = \Str::slug($request->username.'-certificate-'.$timestamp).'.'.$certificateExtension;
        $transferfile = $request->certificate->storeAs('public/files/', $certificateFileName); 

        $cardFrontExtension = $request->file('cardFront')->getClientOriginalExtension();
        $cardFrontFileName = \Str::slug($request->username.'-card-front-'.$timestamp).'.'.$cardFrontExtension;
        $transferfile = $request->cardFront->storeAs('public/files/', $cardFrontFileName); 

        $cardBackExtension = $request->file('cardBack')->getClientOriginalExtension();
        $cardBackFileName = \Str::slug($request->username.'-card-back-'.$timestamp).'.'.$cardBackExtension;
        $transferfile = $request->cardBack->storeAs('public/files/', $cardBackFileName); 


        $region = Region::where('regCode', $this->aes->decrypt($request->region))->first();
        $province = Province::where('provCode',$this->aes->decrypt($request->province))->first();
        $municipal = Municipal::where('citymunCode', $this->aes->decrypt($request->municipal))->first();
        $barangay = Barangay::where('brgyCode', $this->aes->decrypt($request->barangay))->first();

         Franchise::create([
            'userID' => $user->id,
          //  'password' => $request->password,
            'code' => $request->username,
            'category' => $this->aes->decrypt($request->category),

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
         //   'clearanceBack' => $clearanceBackFileName,
            'officialReceipt' => $officialReceiptFileName,
            'certificate' => $certificateFileName,
            'cardFront' => $cardFrontFileName,
            'cardBack' => $cardBackFileName,
            'mayor' => $this->UserInterface->signature()->mayor,
            'police' => $this->UserInterface->signature()->police,
            'status' => 0,
            'isActive' => 0,
            'dateSubmitted' => date('Y-m-d H:i:s'),
         ]);

         return response()->json(
            ['Message' => 'Your franchise application has been submitted successfully. Please wait for an SMS confirmation, which will be sent to you once the office processes your request'], 
            Response::HTTP_OK
        );
    }
}
