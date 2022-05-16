<?php

use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

test('validation pass with correct data', function (array $data, bool $valid) {

    $translator = $this->createMock(Translator::class);
    $request = new StoreCompanyRequest();
    $validator = new Validator($translator, $data, $request->rules());

    expect($validator->passes())->toBe($valid);
})->with(
    function () {
        return
            [
                'with full data' => [
                    'data' => [
                        'selectedRadioID' => 1,
                        'business_name' => 'Test ',
                        'vat_number' => 'Test',
                        'contact_name' => 'Test',
                        'country' => 'Test',
                        'email' => 'email@test.it',
                        'phone' => '080808080',
                        'address' =>'Test',
                    ],
                    'valid' => true,
                ],

                'without country' => [
                    'data' => [
                        'selectedRadioID' => 1,
                        'business_name' => 'Test ',
                        'vat_number' => 'Test',
                        'contact_name' => 'Test',
                        'country' => null,
                        'email' => 'email@test.it',
                        'phone' => '080808080',
                        'address' =>'Test',
                    ],
                    'valid' => false,
                ],

                'without email' => [
                    'data' => [
                        'selectedRadioID' => 1,
                        'business_name' => 'Test ',
                        'vat_number' => 'Test',
                        'contact_name' => 'Test',
                        'country' => 'Test',
                        'email' => null,
                        'phone' => '080808080',
                        'address' =>'Test',
                    ],
                    'valid' => false,
                ],

                'without phone' => [
                    'data' => [
                        'selectedRadioID' => 1,
                        'business_name' => 'Test ',
                        'vat_number' => 'Test',
                        'contact_name' => 'Test',
                        'country' => 'Test',
                        'email' => 'test@email.it',
                        'phone' => null,
                        'address' =>'Test',
                    ],
                    'valid' => false,
                ],

                'without address' => [
                    'data' => [
                        'selectedRadioID' => 1,
                        'business_name' => 'Test ',
                        'vat_number' => 'Test',
                        'contact_name' => 'Test',
                        'country' => 'Test',
                        'email' => 'test@email.it',
                        'phone' => '080808080',
                        'address' => null,
                    ],
                    'valid' => false,
                ],




            ];
    }
);
