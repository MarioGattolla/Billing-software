<?php

namespace App\Actions\Companies;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

/**
 * @method static Company run(array $validated, Company $company = null)
 */
class UpdateCompany
{
    use ActsAsAction;

    public function handle(mixed $validated, Company $company = null): Company
    {
        $company ??= Company::findOrFail($validated['company_id']);

        if ($company->contact_name == null) {
            $validated['contact_name'] = null;
        } // Request is a Private
        else {
            $validated['business_name'] = null;
            $validated['vat_number'] = null;
        }

        $company->update([$validated]);


        return $company->tap(fn($company) => $company->save());
    }
}
