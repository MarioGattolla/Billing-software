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
     * @return mixed
     */
    public function viewAny(User $user)
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
     * @return mixed
     */
    public function view(User $user, Company $company)
    {
        if ($user->can('show company')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function createCompany(User $user)
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
     * @return mixed
     */
    public function editCompany(User $user, Company $company)
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
     * @return mixed
     */
    public function deleteCompany(User $user, Company $company)
    {
        if ($user->can('delete company')){
            return true;
        }
    }


}
