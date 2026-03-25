<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return DepartmentResource::collection(
            Department::all()
        );
    }

    public function show(Department $department)
    {
        return DepartmentResource::make($department);
    }

    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();

        $department = Department::create($data);

        return DepartmentResource::make($department);
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $data = $request->validated();

        $department->update($data);

        return DepartmentResource::make($department);
    }
}
