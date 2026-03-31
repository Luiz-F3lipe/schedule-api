<?php

declare(strict_types = 1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(path: '/user', operationId: 'listUsers', summary: 'List users', security: [['sanctum' => []]], tags: ['Users'], responses: [new OA\Response(response: 200, description: 'User list', content: new OA\JsonContent(ref: '#/components/schemas/UserCollection')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index()
    {
        return UserResource::collection(
            User::with('department')->get()
        );
    }

    #[OA\Post(path: '/user', operationId: 'createUser', summary: 'Create a user', security: [['sanctum' => []]], tags: ['Users'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserRequest')), responses: [new OA\Response(response: 201, description: 'User created', content: new OA\JsonContent(ref: '#/components/schemas/UserResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        return UserResource::make(User::create($data));
    }

    #[OA\Get(path: '/user/{user}', operationId: 'showUser', summary: 'Show a user', security: [['sanctum' => []]], tags: ['Users'], parameters: [new OA\Parameter(name: 'user', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'User details', content: new OA\JsonContent(ref: '#/components/schemas/UserResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function show(User $user)
    {
        return UserResource::make($user->load('department'));
    }
}
