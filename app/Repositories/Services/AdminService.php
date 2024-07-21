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

class AdminService implements AdminInterface {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function categories() {
        return Categories::all();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
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
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function newApplication() {
        return Franchise::where('status', 0)
        ->orWhere('status', 1)->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function application($request) {
        return Franchise::where('id', $this->aes->decrypt($request->id))->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function renewal() {
        return Franchise::where('status', 3)
        ->orWhere('status', 4)->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function categoryUsers($request) {
        
        return Franchise::where('category', $this->aes->decrypt($request->id))
                    ->where('status', '!=', 5)
                    ->where('isActive', '!=', 5)
                    ->orderBy('code')
                    ->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getCategory($request) {
        return Categories::where('id', $this->aes->decrypt($request->id))->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getAccount($request) {
        return User::where('id', $this->aes->decrypt($request->id))->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function franchiseHistory($request) {
        return Franchise::where('userID', $this->aes->decrypt($request->id))
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }
}

?>