<?php

declare(strict_types = 1);

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\ScheduleStatus\UpdateScheduleStatusRequest;
use App\Http\Requests\System\PutSystemRequest;

pest()->group('requests-test');

it('login request is authorized and exposes rules and messages', function () {
    $request = new LoginRequest();

    expect($request->authorize())->toBeTrue();
    expect($request->rules())->toHaveKeys(['email', 'password']);
    expect($request->messages())->toHaveKeys([
        'email.required',
        'email.email',
        'email.exists',
        'password.required',
        'password.string',
        'password.min',
    ]);
});

it('update schedule status request is authorized and exposes rules and messages', function () {
    $request = new UpdateScheduleStatusRequest();

    expect($request->authorize())->toBeTrue();
    expect($request->rules())->toHaveKeys(['description', 'color', 'active']);
    expect($request->messages())->toHaveKeys([
        'description.required',
        'description.string',
        'description.max',
        'description.min',
        'color.required',
        'color.string',
        'color.size',
        'active.required',
        'active.boolean',
    ]);
});

it('put system request is authorized and exposes rules and messages', function () {
    $request = new PutSystemRequest();

    expect($request->authorize())->toBeTrue();
    expect($request->rules())->toHaveKey('description');
    expect($request->messages())->toHaveKeys([
        'description.required',
        'description.string',
        'description.min',
        'description.max',
    ]);
});
