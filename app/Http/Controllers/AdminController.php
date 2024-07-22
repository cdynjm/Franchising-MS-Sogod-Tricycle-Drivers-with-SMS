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
use App\Http\Controllers\SMSController;

use App\Repositories\Interfaces\AdminInterface;

use App\Models\User;
use App\Models\Categories;
use App\Models\Franchise;
use App\Models\SMSToken;

use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes, 
        protected AdminInterface $AdminInterface,
        protected SMSController $sms
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {

        Franchise::where('expiresOn', '<', date('Y-m-d H:i:s'))
                ->where('isActive', '!=', 5)
                ->where('status', '!=', 5)
                ->update(['isActive' => 0]);

        $categories = $this->AdminInterface->categoriesCount();
        return view('pages.admin.dashboard', compact('categories'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function categories() {
        $categories = $this->AdminInterface->categories();
        return view('pages.admin.categories', ['categories' => $categories]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function renewal() {
        $renewal = $this->AdminInterface->renewal();
        return view('pages.admin.renewal', compact('renewal'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function newApplication() {
        $newApplication = $this->AdminInterface->newApplication();
        return view('pages.admin.new-application', compact('newApplication'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewApplication(Request $request) {
        $application = $this->AdminInterface->application($request);
        $categories = $this->AdminInterface->categories();
        return view('pages.admin.view-application', compact('application', 'categories'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function applicationForm(Request $request) {
        $application = $this->AdminInterface->application($request);
        return view('pages.admin.form.application-form', ['application' => $application]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createCategory(Request $request) {

        Categories::create([
            'category' => $request->category,
            'color' => $request->color,
            'description' => $request->description
        ]);
        $aes = $this->aes;
        $categories = $this->AdminInterface->categories();
        return response()->json([
            'Message' => 'Category added successfully',
            'Category' => view('data.admin.category-data', compact('aes', 'categories'))->render()
        ]);   
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateCategory(Request $request) {

        Categories::where('id', $this->aes->decrypt($request->id))->update([
            'category' => $request->category,
            'color' => $request->color,
            'description' => $request->description
        ]);
        $aes = $this->aes;
        $categories = $this->AdminInterface->categories();
        return response()->json([
            'Message' => 'Category updated successfully',
            'Category' => view('data.admin.category-data', compact('aes', 'categories'))->render()
        ]);   
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteCategory(Request $request) {

        Categories::where('id', $this->aes->decrypt($request->id))->delete();
        $aes = $this->aes;
        $categories = $this->AdminInterface->categories();
        return response()->json([
            'Message' => 'Category deleted successfully',
            'Category' => view('data.admin.category-data', compact('aes', 'categories'))->render()
        ]);   
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function confirmFranchiseApplication(Request $request) {

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        $year = date('Y') + 1;

        User::where('id', $franchise->userID)->update(['status' => 1]);
        $unit = User::where('id', $franchise->userID)->first();

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 1,
            'caseNumber' => 'SO-'.date('Y').'-'.sprintf('%04d', $unit->name),
            'expiresOn' => $year.'-'.date('m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->sms->SMSConfirmApplication($franchise);

        return response()->json([
            'Message' => 'Franchise Application confirmed successfully for payment & signature. You can download and print the forms as follows:'
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function approveFranchiseApplication(Request $request) {

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 2,
            'isActive' => 1
        ]);

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        $this->sms->SMSApproveApplication($franchise);

        $files = [
            $franchise->validID,
            $franchise->clearanceFront,
            $franchise->clearanceBack,
            $franchise->officialReceipt,
            $franchise->certificate,
            $franchise->cardFront,
            $franchise->cardBack,
        ];
        
        foreach ($files as $file) {
            File::delete(public_path("storage/files/{$file}"));
        }

        return response()->json([
            'Message' => 'Franchise Application has been approved successfully!'
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function rejectFranchiseApplication(Request $request) {

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        $this->sms->SMSRejectApplication($franchise);

        $files = [
            $franchise->validID,
            $franchise->clearanceFront,
            $franchise->clearanceBack,
            $franchise->officialReceipt,
            $franchise->certificate,
            $franchise->cardFront,
            $franchise->cardBack,
        ];
        
        foreach ($files as $file) {
            File::delete(public_path("storage/files/{$file}"));
        }

        Franchise::where('id', $this->aes->decrypt($request->id))->delete();
        User::where('id', $franchise->userID)->delete();

        return response()->json([
            'Message' => 'Franchise Application has been rejected and deleted successfully!'
        ], Response::HTTP_OK);
    }

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function confirmFranchiseRenewal(Request $request) {

        $year = date('Y') + 1;

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();
        $unit = User::where('id', $franchise->userID)->first();

        $this->sms->SMSConfirmRenewal($franchise);

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 4,
            'caseNumber' => 'SO-'.date('Y').'-'.sprintf('%04d', $unit->name),
            'expiresOn' => $year.'-'.date('m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
            'Message' => 'Franchise Renewal confirmed successfully for payment & signature. You can download and print the forms as follows:'
        ], Response::HTTP_OK);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function approveFranchiseRenewal(Request $request) {

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 2,
            'isActive' => 1
        ]);

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        $this->sms->SMSApproveRenewal($franchise);

        $files = [
            $franchise->validID,
            $franchise->clearanceFront,
            $franchise->clearanceBack,
            $franchise->officialReceipt,
            $franchise->certificate,
            $franchise->cardFront,
            $franchise->cardBack,
        ];
        
        foreach ($files as $file) {
            File::delete(public_path("storage/files/{$file}"));
        }

        return response()->json([
            'Message' => 'Franchise Renewal has been approved successfully!'
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function rejectFranchiseRenewal(Request $request) {

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();

        $this->sms->SMSRejectRenewal($franchise);

        $files = [
            $franchise->validID,
            $franchise->clearanceFront,
            $franchise->clearanceBack,
            $franchise->officialReceipt,
            $franchise->certificate,
            $franchise->cardFront,
            $franchise->cardBack,
        ];
        
        foreach ($files as $file) {
            File::delete(public_path("storage/files/{$file}"));
        }

        Franchise::where('id', $this->aes->decrypt($request->id))->delete();
        
        $previousFranchise = Franchise::where('userID', $this->aes->decrypt($request->userID))
                    ->orderBy('expiresOn', 'DESC')->first();

        if ($previousFranchise) {
            $previousFranchise->update([
                'status' => 2,
                'isActive' => 0
            ]);
        }

        return response()->json([
            'Message' => 'Franchise Renewal has been rejected and deleted successfully!'
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewCategory(Request $request) {
        $category = $this->AdminInterface->getCategory($request);
        return view('pages.admin.view-category', ['category' => $category]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewFranchiseHistory(Request $request) {
        $account = $this->AdminInterface->getAccount($request);
        return view('pages.admin.view-franchise-history', ['account' => $account]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
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
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function smsToken(Request $request) {
       
        SMSToken::where('id', 1)->update([
            'access_token' => $request->token,
            'mobile_identity' => $request->mobile
        ]);
        
        return response()->json(['Message' => 'Your SMS token has been updated successfully!'], Response::HTTP_OK);
    }
}

