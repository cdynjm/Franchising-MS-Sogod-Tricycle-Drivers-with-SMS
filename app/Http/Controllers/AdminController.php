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

use App\Repositories\Interfaces\AdminInterface;

use App\Models\User;
use App\Models\Categories;
use App\Models\Franchise;

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
        protected AdminInterface $AdminInterface
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
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

        $year = date('Y') + 1;

        $franchise = Franchise::where('id', $this->aes->decrypt($request->id))->first();
        User::where('id', $franchise->userID)->update(['status' => 1]);
        $unit = User::where('id', $franchise->userID)->first();

        Franchise::where('id', $this->aes->decrypt($request->id))->update([
            'status' => 1,
            'caseNumber' => 'SO-'.date('Y').'-'.sprintf('%04d', $unit->name),
            'expiresOn' => $year.'-'.date('m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

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

        File::delete(public_path("storage/files/{$franchise->clearanceFront}"));
        File::delete(public_path("storage/files/{$franchise->clearanceBack}"));
        File::delete(public_path("storage/files/{$franchise->officialReceipt}"));
        File::delete(public_path("storage/files/{$franchise->certificate}"));
        File::delete(public_path("storage/files/{$franchise->cardFront}"));
        File::delete(public_path("storage/files/{$franchise->cardBack}"));

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

        File::delete(public_path("storage/files/{$franchise->clearanceFront}"));
        File::delete(public_path("storage/files/{$franchise->clearanceBack}"));
        File::delete(public_path("storage/files/{$franchise->officialReceipt}"));
        File::delete(public_path("storage/files/{$franchise->certificate}"));
        File::delete(public_path("storage/files/{$franchise->cardFront}"));
        File::delete(public_path("storage/files/{$franchise->cardBack}"));

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

        File::delete(public_path("storage/files/{$franchise->clearanceFront}"));
        File::delete(public_path("storage/files/{$franchise->clearanceBack}"));
        File::delete(public_path("storage/files/{$franchise->officialReceipt}"));
        File::delete(public_path("storage/files/{$franchise->certificate}"));
        File::delete(public_path("storage/files/{$franchise->cardFront}"));
        File::delete(public_path("storage/files/{$franchise->cardBack}"));

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

        File::delete(public_path("storage/files/{$franchise->clearanceFront}"));
        File::delete(public_path("storage/files/{$franchise->clearanceBack}"));
        File::delete(public_path("storage/files/{$franchise->officialReceipt}"));
        File::delete(public_path("storage/files/{$franchise->certificate}"));
        File::delete(public_path("storage/files/{$franchise->cardFront}"));
        File::delete(public_path("storage/files/{$franchise->cardBack}"));

        Franchise::where('id', $this->aes->decrypt($request->id))->delete();
        
        Franchise::where('userID', Auth::user()->id)->update([
            'status' => 2,
            'isActive' => 0
        ]);

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
        $users = $this->AdminInterface->categoryUsers($request);
        return view('pages.admin.view-category', compact('category', 'users'));
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewFranchiseHistory(Request $request) {
        $account = $this->AdminInterface->getAccount($request);
        $franchise = $this->AdminInterface->franchiseHistory($request);
        return view('pages.admin.view-franchise-history', compact('account', 'franchise'));
    }
}

