<?php

namespace App\Actions\Companies;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

/**
 * @method static Company run(array $validated, Company $company = null)
 */
class CreateNewCompany
{
    use ActsAsAction;

    public function handle(array $validated): Company
    {

        // Request is a Company
        if ($validated['type'] == 'private') {
            $validated['vat_number'] = null;
        }

        return Company::create($validated);
    }
}
