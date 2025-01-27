<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Franchise;

//login controller. it will handle all the log ins of all the users and admin

class LoginController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            //creates an API token that will be use as access token for API routes.
            $user = User::where(['id' => Auth::user()->id])->first();
            $authToken = $user->createToken(\Str::random(50))->plainTextToken;
            $request->session()->put('token', $authToken);

            return response()->json([], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'Message' => $e->getMessage(),
            ],  Response::HTTP_INTERNAL_SERVER_ERROR);
            
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['Error' => 0], Response::HTTP_OK);
    }
}
