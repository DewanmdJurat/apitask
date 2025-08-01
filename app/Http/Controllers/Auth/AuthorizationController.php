<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
                'id'            => $user->id,
                'email'       => $user->email,
                'role'          => $user->role_id,
                'country_id'    => 30,
            ],
        ]);
    }
}
