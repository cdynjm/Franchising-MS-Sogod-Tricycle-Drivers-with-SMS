<?php

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
use Illuminate\Http\Response;

use App\Http\Controllers\AESCipher;

use App\Repositories\Interfaces\UserInterface;

use App\Models\User;
use App\Models\Categories;
use App\Models\Franchise;

use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes, 
        protected UserInterface $UserInterface
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        $user = $this->UserInterface->activeUser();
        return view('pages.user.dashboard', ['user' => $user]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function renewFranchise(Request $request) {
        $unit = $this->aes->decrypt($request->unit);
        $previousFranchise = $this->UserInterface->previousFranchise();

        if($previousFranchise->isActive == 0) {
            if($previousFranchise->status == 2)
                return view('pages.user.renew-franchise', compact('unit', 'previousFranchise'));
            else
                return abort(404);
        }
        else
            return abort(404);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function submitRenewal(Request $request) {

        Franchise::where('userID', Auth::user()->id)->update([
            'status' => 5,
            'isActive' => 5
        ]);
        
        $timestamp = Carbon::now();

        $validIDExtension = $request->file('validID')->getClientOriginalExtension();
        $validIDFileName = \Str::slug($request->username.'-valid-id-'.$timestamp).'.'.$validIDExtension;
        $transferfile = $request->validID->storeAs('public/files/', $validIDFileName); 

        $clearanceFrontExtension = $request->file('clearanceFront')->getClientOriginalExtension();
        $clearanceFrontFileName = \Str::slug(Auth::user()->email.'-clearance-front-'.$timestamp).'.'.$clearanceFrontExtension;
        $transferfile = $request->clearanceFront->storeAs('public/files/', $clearanceFrontFileName); 

        $clearanceBackExtension = $request->file('clearanceBack')->getClientOriginalExtension();
        $clearanceBackFileName = \Str::slug(Auth::user()->email.'-clearance-back-'.$timestamp).'.'.$clearanceBackExtension;
        $transferfile = $request->clearanceBack->storeAs('public/files/', $clearanceBackFileName); 

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

         Franchise::create([
            'userID' => Auth::user()->id,
            'code' => Auth::user()->email,
            'category' => Auth::user()->category,
            'applicant' => strtoupper($request->applicant),
            'address' => strtoupper($request->address),
            'contactNumber' => $request->contactNumber,
            'make' => strtoupper($request->make),
            'motorNumber' => strtoupper($request->motorNumber),
            'chassisNumber' => strtoupper($request->chassisNumber),
            'plateNumber' => strtoupper($request->plateNumber),
            'validID' => $validIDFileName,
            'clearanceFront' => $clearanceFrontFileName,
            'clearanceBack' => $clearanceBackFileName,
            'officialReceipt' => $officialReceiptFileName,
            'certificate' => $certificateFileName,
            'cardFront' => $cardFrontFileName,
            'cardBack' => $cardBackFileName,
            'mayor' => $this->UserInterface->signature()->mayor,
            'police' => $this->UserInterface->signature()->police,
            'status' => 3,
            'isActive' => 0,
         ]);

         return response()->json(
            ['Message' => 'Your franchise renewal has been submitted successfully. Please wait for an SMS confirmation, which will be sent to you once the office processes your request'], 
            Response::HTTP_OK
        );
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function renewalHistory(Request $request) {
        $franchise = $this->UserInterface->franchiseHistory($request);
        return view('pages.user.view-franchise-history', compact('franchise'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewApplication(Request $request) {
        $application = $this->UserInterface->application($request);
        $categories = $this->UserInterface->categories();
        return view('pages.user.view-application', compact('application', 'categories'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProfile(Request $request) {

        if(!empty($request->password)) {
            Auth::user()->update(['password' => Hash::make($request->password)]);
        }
        
        return response()->json(['Message' => 'Your password has been updated successfully!'], Response::HTTP_OK);
    }
}
