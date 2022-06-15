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

        return \view('users.create');
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
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(User $user): RedirectResponse
    {
        match ($user->getRoleNames()->implode(',')) {
            'Admin' => $this->authorize('deleteAdmin', $user),
            'Super Admin' => $this->authorize('deleteSuperAdmin', $user),
            default => $this->authorize('deleteUser', $user),
        };

        $user->delete();

    }
}
