<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);


test('users index return correct view', function () {

    allow_authorize('viewAny', User::class);

    $response = app(UserController::class)->index();

    expect($response)->toBeView('users.index');

});

test('only authorized user can see index page', function () {

    authorize_check_by_policy('show user', 'viewAny', User::class);
});

test('users create return correct view', function () {

    allow_authorize('createUser', User::class);

    $response = app(UserController::class)->create();

    expect($response)->toBeView('users.create');

});

test('only authorized user can see create page', function () {

    authorize_check_by_policy('create user', 'createUser', User::class);

});

test('can store users and return correct redirect', function (string $policy_name, string $role) {

   $this->seed(PermissionSeeder::class);

    allow_authorize($policy_name, User::class);

    $request = \Illuminate\Http\Request::create(route('users.create'), 'POST', [
        'name' => 'Test Name',
        'email' => 'email@test.it',
        'password' => 'Test',
        'role' => $role,
    ]);

    $response = app(UserController::class)->store($request);

    /** @var User $user */
    $user = User::findOrFail(1);

    expect($user->name)->toBe('Test Name');
    expect($user->email)->toBe('email@test.it');
    expect(Hash::check('Test', $user->password))->toBeTrue();
    expect($user->getRoleNames()->first())->toBe($role);
    expect($response)->toBeRedirect(route('users.index'));
    expect($response)->toHaveStatus(302);

})->with([
    ['createUser' , 'Operator'],
    ['createAdmin' , 'Admin'],
    ['createSuperAdmin', 'Super Admin'],
]);

test('users show return correct view', function () {

    $user = User::factory()->make();

    allow_authorize('view', $user);

    $response = app(UserController::class)->show($user);

    expect($response)->toBeView('users.show');

});

test('only authorized user can see user show page', function () {

    $user = User::factory()->make();

    authorize_check_by_policy('show user', 'view', $user);

});

test('users edit return correct view', function () {

    $user = User::factory()->make();

    allow_authorize('editUser', $user);

    $response = app(UserController::class)->edit($user);

    expect($response)->toBeView('users.edit');

});

test('only authorized user can see user edit page', function () {

    $user = User::factory()->make();

    authorize_check_by_policy('edit user', 'editUser', $user);

});


test('can update users and return correct redirect', function (string $policy_name, string $role) {

    $this->seed(PermissionSeeder::class);


    Role::create(['name' => 'TestRole']);
    Role::create(['name' => 'NewTestRole']);

    /** @var User $old_user */
    $old_user = User::factory()->create([
        'name' => 'Test Name',
        'email' => 'email@test.it',
        'password' => 'Test',
    ]);
    $old_user->assignRole('TestRole');

    allow_authorize($policy_name, $old_user);

    $request = \Illuminate\Http\Request::create(route('users.edit', $old_user), 'PUT', [
        'name' => 'Test New Name',
        'email' => 'newEmail@test.it',
        'password' => 'NewTest',
        'role' => $role,
    ]);

    $response = app(UserController::class)->update($request, $old_user);

    expect($response)->toHaveStatus(302);

    /** @var User $user */
    $user = User::findOrFail(1);

    expect($user->name)->toBe('Test New Name');
    expect($user->email)->toBe('newEmail@test.it');
    expect(Hash::check('NewTest', $user->password))->toBeTrue();
    expect($user->getRoleNames()->first())->toBe($role);
    expect($response)->toBeRedirect(route('users.show', $user));

})->with([
    ['editUser' , 'Operator'],
    ['editAdmin' , 'Admin'],
    ['editSuperAdmin', 'Super Admin'],
]);



test('can delete user and return correct redirect', function (string $policy_name, string $role) {

    $this->seed(PermissionSeeder::class);

    /** @var User $user */
    $user = User::factory()->create();
    $user->assignRole($role);

    allow_authorize($policy_name, $user);

    $response = app(UserController::class)->destroy($user);

    expect(User::count())->toBe(0);
    expect($response)->toBeRedirect(route('users.index'));

})->with([
    ['deleteUser' , 'Operator'],
    ['deleteAdmin' , 'Admin'],
    ['deleteSuperAdmin', 'Super Admin'],
]);
