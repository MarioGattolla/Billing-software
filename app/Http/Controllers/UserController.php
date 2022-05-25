<?php

namespace App\Http\Controllers;

use App\Actions\Users\CreateNewUser;
use App\Actions\Users\UpdateUser;
use App\Models\User;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('createUser', User::class);

        $new_user = new User();
        $new_user->setRelation('roles', Collection::make([Role::findByName(\App\Enums\Role::operator->value)]));

        return \view('users.create')->with('user', $new_user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ActionException
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $role = $request->role;
        match ($role){
            'Super Admin' => $this->authorize('createSuperAdmin', User::class),
            'Admin' => $this->authorize('createAdmin', User::class),
            'Operator' => $this->authorize('createUser', User::class),
            default => 'unknown role',

        };

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $role = $request->input('role');

        CreateNewUser::run($name, $email, $password, $role) ;

        return redirect()->route('users.index')->with('success', 'User created !!');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        return \view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user): View
    {
        $this->authorize('editUser', $user);

        return \view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws ActionException
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $role = $request->role;
        match ($role){
            'Super Admin' => $this->authorize('editSuperAdmin', $user),
            'Admin' => $this->authorize('editAdmin', $user),
            'Operator' => $this->authorize('editUser', $user),
            default => 'unknown role',
        };

        if ($request->password == null){
            $this->validate($request,[
                'name' => 'required|string',
                'email' => 'required|email',
            ]);
        }
        else{
            $this->validate($request,[
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required'
            ]);

        }

        UpdateUser::run($request, $user) ;

        return redirect()->route('users.show',$user)->with('success', 'User updated !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(User $user): RedirectResponse
    {
        $role = $user->getRoleNames()->first();

        match ($role){
            'Super Admin' => $this->authorize('deleteSuperAdmin', $user),
            'Admin' => $this->authorize('deleteAdmin', $user),
            'Operator' => $this->authorize('deleteUser', $user),
        };

        $user->deleteOrFail();

        return redirect()->route('users.index')->with('success', 'User deleted !!');
    }
}
