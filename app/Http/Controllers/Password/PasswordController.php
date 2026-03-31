<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\StorePasswordRequest;
use App\Http\Requests\Password\UpdatePasswordRequest;
use App\Http\Resources\Password\PasswordDetailResource;
use App\Http\Resources\Password\PasswordResource;
use App\Models\Password;
use OpenApi\Attributes as OA;

class PasswordController extends Controller
{
    #[OA\Get(path: '/passwords', operationId: 'listPasswords', summary: 'List passwords', security: [['sanctum' => []]], tags: ['Passwords'], parameters: [new OA\Parameter(name: 'with', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Optional includes. Supported values contain departments and/or products.')], responses: [new OA\Response(response: 200, description: 'Password list', content: new OA\JsonContent(ref: '#/components/schemas/PasswordCollection')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index()
    {
        return PasswordResource::collection(
            Password::query()
                ->when(
                    str(request()->string('with', ''))->contains('departments'),
                    fn ($query) => $query->with('department')
                )
                ->when(
                    str(request()->string('with', ''))->contains('products'),
                    fn ($query) => $query->with('product')
                )
                ->get()
        );
    }

    #[OA\Post(path: '/passwords', operationId: 'createPassword', summary: 'Create a password', security: [['sanctum' => []]], tags: ['Passwords'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PasswordRequest')), responses: [new OA\Response(response: 201, description: 'Password created', content: new OA\JsonContent(ref: '#/components/schemas/PasswordResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function store(StorePasswordRequest $request)
    {
        $data = $request->validated();

        $password = Password::create($data);

        return PasswordResource::make($password);
    }

    #[OA\Get(path: '/passwords/{password}', operationId: 'showPassword', summary: 'Show a password', security: [['sanctum' => []]], tags: ['Passwords'], parameters: [new OA\Parameter(name: 'password', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Password details', content: new OA\JsonContent(ref: '#/components/schemas/PasswordDetailResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function show(Password $password)
    {
        return PasswordDetailResource::make($password);
    }

    #[OA\Put(path: '/passwords/{password}', operationId: 'updatePassword', summary: 'Update a password', security: [['sanctum' => []]], tags: ['Passwords'], parameters: [new OA\Parameter(name: 'password', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PasswordRequest')), responses: [new OA\Response(response: 200, description: 'Password updated', content: new OA\JsonContent(ref: '#/components/schemas/PasswordDetailResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function update(UpdatePasswordRequest $request, Password $password)
    {
        $data = $request->validated();

        $password->update($data);

        return PasswordDetailResource::make($password);
    }
}
