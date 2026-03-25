<?php

declare(strict_types = 1);

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\StoreSystemRequest;
use App\Http\Resources\System\SystemResource;
use App\Models\System;

class SystemController extends Controller
{
    public function index()
    {
        return SystemResource::collection(
            System::all()
        );
    }

    public function store(StoreSystemRequest $request)
    {
        $system = $request->validated();

        return SystemResource::make(
            System::create($system)
        );
    }

    public function show(System $system)
    {
        return SystemResource::make($system);
    }

    public function update(StoreSystemRequest $request, System $system)
    {
        $data = $request->validated();

        $system->update($data);

        return SystemResource::make($system);
    }
}
