<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        Gate::authorize('admin-only');
        try {
            $users =  User::all();

            return $this->successResponse( $users,'Logged out');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong. please try again.',500);
        }
    }

    public function profile()
    {

    }

}
