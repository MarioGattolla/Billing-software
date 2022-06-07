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
        if ($validated['type'] == 'private') {
            $validated['vat_number'] = null;
        }

        return Company::create($validated);
    }
}
