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

    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('users.index');
    }

}
