<?php

namespace App\Actions\Users ;

use App\Models\Company;
use App\Models\User;
use DefStudio\Actions\Concerns\ActsAsAction;
use Illuminate\Http\Request;

class UpdateUser
{
    use ActsAsAction;

    public function handle(Request $request , User $user): bool
    {

        if ($request->role == null){
        }
        else{
            $new_role = $request->role;
            $old_role = $user->getRoleNames()->first();

            $user->removeRole($old_role);
            $user->assignRole($new_role);
        }

      return $user->fill($request->all())->save();
    }
}
