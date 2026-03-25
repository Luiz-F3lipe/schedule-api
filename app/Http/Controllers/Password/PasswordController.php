<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\StorePasswordRequest;
use App\Http\Requests\Password\UpdatePasswordRequest;
use App\Http\Resources\Password\PasswordDetailResource;
use App\Http\Resources\Password\PasswordResource;
use App\Models\Password;

class PasswordController extends Controller
{
    public function index()
    {
        return PasswordResource::collection(
            Password::all()
        );
    }

    public function store(StorePasswordRequest $request)
    {
        $data = $request->validated();

        $password = Password::create($data);

        return PasswordResource::make($password);
    }

    public function show(Password $password)
    {
        return PasswordDetailResource::make($password);
    }

    public function update(UpdatePasswordRequest $request, Password $password)
    {
        $data = $request->validated();

        $password->update($data);

        return PasswordDetailResource::make($password);
    }
}
