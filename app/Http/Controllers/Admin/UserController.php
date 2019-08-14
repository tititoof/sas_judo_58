<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param User $user
     */
    public function show(User $user)
    {
        //
    }

    public function toggleAdmin(User $user)
    {
        $repo = new UserRepository;
        return response()->json($repo->toggleAdmin($user));
    }

    public function toggleTeacher(User $user)
    {
        $repo = new UserRepository;
        return response()->json($repo->toggleTeacher($user));
    }

    public function toggleDebug(User $user)
    {
        $repo = new UserRepository;
        return response()->json($repo->toggleDebug($user));
    }

    /**
     * @param User $user
     */
    public function edit(User $user)
    {
        return response()->json(['object' => $user]);
    }

    /**
     * @param Request $request
     * @param User $user
     */
    public function update(Request $request, User $user)
    {
        $repo = new UserRepository;
        $user = $repo->update($request, $user);
        return response()->json(['success' => true, 'object' => $user]);
    }

    /**
     * @param User $user
     */
    public function destroy(User $user)
    {
        $repo = new UserRepository;
        return response()->json($repo->delete($user));
    }
}
