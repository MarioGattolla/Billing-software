<?php

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

test('validation pass with correct data', function (array $data, bool $valid) {

    $translator = $this->createMock(Translator::class);
    $request = new StoreProductRequest();
    $validator = new Validator($translator, $data, $request->rules());

    expect($validator->passes())->toBe($valid);
})->with(
    function () {
        return
            [
                'with full data' => [
                    'data' => [
                        'name' => 'Test name',
                        'description' => 'Test description',
                        'min_stock' => 10,
                        'weight' => 2,
                        'category_id' => 1,
                        'price' => 20.10,
                        'vat' => 20,
                        'department' => 2,
                    ],
                    'valid' => true,
                ],

                'without name' => [
                    'data' => [
                        'name' => null,
                        'description' => 'Test description',
                        'min_stock' => 10,
                        'weight' => 2,
                        'category_id' => 1,
                        'price' => 20.10,
                        'vat' => 20,
                        'department' => 2,
                    ],
                    'valid' => false,
                ],

                'without description' => [
                    'data' => [
                        'name' => 'Test',
                        'description' => null,
                        'min_stock' => 10,
                        'weight' => 2,
                        'category_id' => 1,
                        'price' => 20.10,
                        'vat' => 20,
                        'department' => 2,
                    ],
                    'valid' => false,
                ],


            ];
    }
)->only();
