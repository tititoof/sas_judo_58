<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFormRequest;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if (!empty($request->user())) {
            $data['id']         = $request->user()->id;
            $data['name']       = $request->user()->name;
            $data['email']      = $request->user()->email;
            $data['is_admin']   = $request->user()->is_admin;
            $data['is_debug']   = $request->user()->is_debug;
        }
        return response()->json(['data' => $data]);
    }
}
