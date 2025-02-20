<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Responses\User\UserIndexResponse;
use App\Http\Responses\User\UserStoreResponse;
use App\Http\Responses\User\UserUpdateResponse;
use App\Http\Responses\User\UserDestroyResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->expectsJson()) {
            return new UserIndexResponse;
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        return new UserStoreResponse;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        return new UserUpdateResponse;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return new UserDestroyResponse;
    }
}
