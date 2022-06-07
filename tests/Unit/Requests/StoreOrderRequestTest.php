<?php

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

test('validation pass with correct data', function (array $data, bool $valid) {

    $translator = $this->createMock(Translator::class);
    $request = new StoreOrderRequest();
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
                        'company' => [
                            'company_id' => 1,
                            'email' => 'test@email.com',
                            'country' => 'Test',
                            'address' => 'Test',
                            'phone' => '080808080',
                            'vat_number' => '13346678',
                            'name' => 'Test',
                        ],
                        'products' => [
                            [1, 2, 3],
                        ],
                    ],
                    'valid' => true,
                ],

                'without company' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => today()->format('d-m-Y'),
                        'company' => null,
                        'products' => [
                            [1, 2, 3],
                        ],
                    ],
                    'valid' => false,
                ],

                'without products' => [
                    'data' => [
                        'type' => 'ingoing',
                        'date' => today()->format('d-m-Y'),
                        'company' => [
                            'company_id' => 1,
                            'email' => 'test@email.com',
                            'country' => 'Test',
                            'address' => 'Test',
                            'phone' => '080808080',
                            'vat_number' => '13346678',
                            'name' => 'Test',
                        ],
                        'products' => null,
                    ],
                    'valid' => false,
                ],


            ];
    }
);
