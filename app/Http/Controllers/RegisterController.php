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

class RegisterController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes, 
        protected userInterface $UserInterface
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function register(Request $request) {
        $categories = $this->UserInterface->categories();
        return view('auth.register', ['categories' => $categories]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function submitApplication(Request $request) {

        $exists = DB::table('users')
            ->where('name', $request->bodyNumber)
            ->where('category', $this->aes->decrypt($request->category))
            ->exists();
        
        if ($exists) {
            return response()->json(['Message' => 'The body number is already registered. Duplication of account is not allowed'], Response::HTTP_INTERNAL_SERVER_ERROR);
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

        $clearanceFrontExtension = $request->file('clearanceFront')->getClientOriginalExtension();
        $clearanceFrontFileName = \Str::slug($request->username.'-clearance-front-'.$timestamp).'.'.$clearanceFrontExtension;
        $transferfile = $request->clearanceFront->storeAs('public/files/', $clearanceFrontFileName); 

        $clearanceBackExtension = $request->file('clearanceBack')->getClientOriginalExtension();
        $clearanceBackFileName = \Str::slug($request->username.'-clearance-back-'.$timestamp).'.'.$clearanceBackExtension;
        $transferfile = $request->clearanceBack->storeAs('public/files/', $clearanceBackFileName); 

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

         Franchise::create([
            'userID' => $user->id,
            'code' => $request->username,
            'category' => $this->aes->decrypt($request->category),
            'applicant' => strtoupper($request->applicant),
            'address' => strtoupper($request->address),
            'contactNumber' => $request->contactNumber,
            'make' => strtoupper($request->make),
            'motorNumber' => strtoupper($request->motorNumber),
            'chassisNumber' => strtoupper($request->chassisNumber),
            'plateNumber' => strtoupper($request->plateNumber),
            'clearanceFront' => $clearanceFrontFileName,
            'clearanceBack' => $clearanceBackFileName,
            'officialReceipt' => $officialReceiptFileName,
            'certificate' => $certificateFileName,
            'cardFront' => $cardFrontFileName,
            'cardBack' => $cardBackFileName,
            'status' => 0,
            'isActive' => 0,
         ]);

         return response()->json(
            ['Message' => 'Your franchise application has been submitted successfully. Please wait for an SMS confirmation, which will be sent to you once the office processes your request'], 
            Response::HTTP_OK
        );
    }
}
