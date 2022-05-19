<?php

use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

test('validation pass with correct data', function (array $data, bool $valid) {

    $translator = $this->createMock(Translator::class);
    $request = new UpdateOrderRequest();
    $validator = new Validator($translator, $data, $request->rules());

    expect($validator->passes())->toBe($valid);
})->with(
    function () {
        return
            [
                'with full data' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => today()->format('d-m-Y'),
                        'business_name' => 'test',
                        'email' => 'test@email.com',
                        'country' => 'test',
                        'address' => 'test',
                        'phone' => 'test',
                        'vat_number' => 'test',
                        'contact_name' => 'test',
                    ],
                    'valid' => true,
                ],

                'without type' => [
                    'data' => [
                        'type' => null,
                        'date' => today()->format('d-m-Y'),
                        'business_name' => 'test',
                        'email' => 'test@email.com',
                        'country' => 'test',
                        'address' => 'test',
                        'phone' => 'test',
                        'vat_number' => 'test',
                        'contact_name' => 'test',
                    ],
                    'valid' => false,
                ],

                'without date' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => null,
                        'business_name' => 'test',
                        'email' => 'test@email.com',
                        'country' => 'test',
                        'address' => 'test',
                        'phone' => 'test',
                        'vat_number' => 'test',
                        'contact_name' => 'test',
                    ],
                    'valid' => false,
                ],

                'without email' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => today()->format('d-m-Y'),
                        'business_name' => 'test',
                        'email' => null,
                        'country' => 'test',
                        'address' => 'test',
                        'phone' => 'test',
                        'vat_number' => 'test',
                        'contact_name' => 'test',
                    ],
                    'valid' => false,
                ],

                'without country' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => today()->format('d-m-Y'),
                        'business_name' => 'test',
                        'email' => 'test@email.com',
                        'country' => null,
                        'address' => 'test',
                        'phone' => 'test',
                        'vat_number' => 'test',
                        'contact_name' => 'test',
                    ],
                    'valid' => false,
                ],

                'without address' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => today()->format('d-m-Y'),
                        'business_name' => 'test',
                        'email' => 'test@email.com',
                        'country' => 'test',
                        'address' => null,
                        'phone' => 'test',
                        'vat_number' => 'test',
                        'contact_name' => 'test',
                    ],
                    'valid' => false,
                ],

                'without phone' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => today()->format('d-m-Y'),
                        'business_name' => 'test',
                        'email' => 'test@email.com',
                        'country' => 'test',
                        'address' => 'test',
                        'phone' => null,
                        'vat_number' => 'test',
                        'contact_name' => 'test',
                    ],
                    'valid' => false,
                ],
            ];
    });
