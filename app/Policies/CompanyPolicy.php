<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        if ($user->can('show company')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Company $company
     * @return Response|bool
     */
    public function view(User $user, Company $company): Response|bool
    {
        if ($user->can('show company')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function createCompany(User $user): Response|bool
    {
        if ($user->can('create company')){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Company $company
     * @return Response|bool
     */
    public function editCompany(User $user, Company $company): Response|bool
    {
        if ($user->can('edit company')){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Company $company
     * @return Response|bool
     */
    public function deleteCompany(User $user, Company $company): Response|bool
    {
        if ($user->can('delete company')){
            return true;
        }
    }


}
