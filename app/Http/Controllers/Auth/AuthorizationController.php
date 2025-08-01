<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    use ApiResponseTrait;
    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:30',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Failed', 422, $validator->errors());
        }
        $email = $request->get('email');
        $user = User::where('email', $email)->first();
        if($user == null) {
          return  $this->errorResponse('The provided credentials are incorrect.',401);
        }
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->errorResponse('The provided credentials are incorrect.',401);
//            throw ValidationException::withMessages([
//                'general' => ['The provided credentials are incorrect.'],
//            ]);
        }

        $token =  $user->createToken($email)->plainTextToken;

        return $this->successResponse([
            'accessToken' => $token,
            'user' => (object)[
                'id'          => $user->id,
                'name'       => $user->name,
                'email'       => $user->email,
            ],
        ]);
    }
    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:30',
            'password' => 'required|min:6|max:50|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Failed', 422, $validator->errors());
        }
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $token =  $user->createToken($email)->plainTextToken;

        return $this->successResponse([
            'accessToken' => $token,
            'user' => (object)[
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
            ],
        ]);
    }

    public function Logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse( '','Logged out');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong. please try again.',500);
        }

    }

}
