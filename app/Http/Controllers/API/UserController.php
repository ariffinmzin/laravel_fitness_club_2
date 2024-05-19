<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);

        $users = User::paginate($perPage);

        return response()->json($users);


    }
}
