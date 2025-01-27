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

use App\Repositories\Interfaces\UserInterface;

use App\Models\User;
use App\Models\Categories;
use App\Models\Franchise;
use App\Models\Signature;

class UserService implements UserInterface {
   
    //creates a constructor to use the cipher for security
    public function __construct(
        protected AESCipher $aes
    ) {}
    
    //get all categories
    public function categories() {
        return Categories::all();
    }
    
    //get the current and active user of the franchise
    public function activeUser() {
        return Franchise::where('userID', Auth::user()->id)
                ->orderBy('created_at', 'DESC')
                ->first();
    }
    
    //get the previous user of the franchise
    public function previousFranchise() {
        return Franchise::where('userID', Auth::user()->id)
                ->orderBy('created_at', 'DESC')
                ->first();
    }
    
    //get the franchise history
    public function franchiseHistory($request) {
        return Franchise::where('userID', Auth::user()->id)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }
    
    //get the franchise application
    public function application($request) {
        return Franchise::where('id', $this->aes->decrypt($request->id))->first();
    }
    
    //get the signatures
    public function signature() {
        return Signature::where('id', 1)->first();
    }
}

?>