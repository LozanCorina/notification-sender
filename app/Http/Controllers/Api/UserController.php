<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUserRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            'status' => 'success'
        ], Response::HTTP_OK);
    }
}
