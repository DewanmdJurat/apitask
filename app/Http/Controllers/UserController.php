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

        $users =  User::all();
        return $this->successResponse( $users);

    }

    public function profile()
    {

    }

}
