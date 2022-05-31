<?php


namespace App\Actions\Ddts;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

/**
 * @method static Company run(array $validated)
 */
class CreateNewDdt
{
    use ActsAsAction;

    public function handle(array $validated): Company
    {

        // Request is a Company
        if ($validated['selectedRadioID'] == 1) {
            $validated['contact_name'] = null;
        } // Request is a Private
        else {
            $validated['business_name'] = null;
            $validated['vat_number'] = null;
        }

        return Company::create($validated);
    }
}
