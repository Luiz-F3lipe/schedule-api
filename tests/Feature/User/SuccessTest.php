<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\postJson;

pest()->group('user-test');

beforeEach(function () {
    login();
    /** @var mixed $this */
    $this->departmentId = createDepartment('Engineering');
});

it('creates a user', function () {
    /** @var mixed $this */
    $response = postJson('/user', [
        'name'          => 'Created User',
        'email'         => 'created-user@example.com',
        'password'      => '1234',
        'department_id' => $this->departmentId,
    ]);

    $response->assertCreated();
    $response->assertJsonFragment([
        'name'  => 'Created User',
        'email' => 'created-user@example.com',
    ]);

    $user = User::query()->where('email', 'created-user@example.com')->firstOrFail();
    expect(Hash::check('1234', $user->password))->toBeTrue();
});
