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

    public function handle(array $validated, Company $company = null): Company
    {
        /** @var Company $company */
        /** @phpstan-ignore-next-line */
        $company ??= Company::findOrFail($validated['company_id']);

        if ($company->contact_name == null) {
            $validated['contact_name'] = null;
        } else {
            $validated['business_name'] = null;
            $validated['vat_number'] = null;
        }

        $company->update($validated);
        $company->save();

        return $company;
    }
}
