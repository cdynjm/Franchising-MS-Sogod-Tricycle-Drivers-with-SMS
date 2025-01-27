<?php

namespace App\Repositories\Services;

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
use App\Models\Signature;

class AdminService implements AdminInterface {
    
    //creates a constructor to use the cipher for security
    public function __construct(
        protected AESCipher $aes
    ) {}
   
    //get all the categories
    public function categories() {
        return Categories::all();
    }
    
    //counts categories
    public function categoriesCount() {
        return Categories::withCount([
            'users',
            'users as active_franchises_count' => function ($query) {
                $query->whereHas('franchise', function ($query) {
                    $query->where('isActive', 1);
                });
            },
            'users as expired_franchises_count' => function ($query) {
                $query->whereHas('franchise', function ($query) {
                    $query->where('isActive', 0);
                });
            }
        ])->get();
    }
    
    //get new application
    public function newApplication() {
        return Franchise::where(function($query) {
                $query->where('status', 0)
                      ->orWhere('status', 1);
            })
            ->whereNull('hasComment')
            ->orderBy('code', 'ASC')
            ->get();
    }    
    
    //get application
    public function application($request) {
        return Franchise::where('id', $this->aes->decrypt($request->id))->first();
    }
    
    //get the renewal
    public function renewal() {
        return Franchise::where(function($query) {
            $query->where('status', 3)
                  ->orWhere('status', 4);
        })
        ->whereNull('hasComment')
        ->orderBy('code', 'ASC')
        ->get();
    }
    
    //get category users
    public function categoryUsers($request) {
        
        return Franchise::where('category', $this->aes->decrypt($request->id))
                    ->where('status', '!=', 5)
                    ->where('isActive', '!=', 5)
                    ->orderBy('code')
                    ->paginate(3);
    }
   
    //get category
    public function getCategory($request) {
        return Categories::where('id', $this->aes->decrypt($request->id))->first();
    }
    
    //get accounts
    public function getAccount($request) {
        return User::where('id', $this->aes->decrypt($request->id))->first();
    }
    
    //get the franchise history
    public function franchiseHistory($request) {
        return Franchise::where('userID', $this->aes->decrypt($request->id))
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }
    
    //get previous franchise
    public function previousFranchise($request) {
        return Franchise::where('userID', $this->aes->decrypt($request->id))
                ->orderBy('created_at', 'DESC')
                ->first();
    }
    
    //get signatures
    public function signature() {
        return Signature::where('id', 1)->first();
    }

    //get the users based on the selected category
    public function getUsersByCategory($request) {
        return User::where('category', $this->aes->decrypt($request->id))->get();
    }
}

?>