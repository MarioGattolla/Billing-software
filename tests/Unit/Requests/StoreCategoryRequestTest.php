<?php

use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

test('validation pass with correct data', function (array $data, bool $valid) {

    $translator = $this->createMock(Translator::class);
    $request = new StoreCategoryRequest();
    $validator = new Validator($translator, $data, $request->rules());

    expect($validator->passes())->toBe($valid);
})->with(
    function () {
        return
            [
                'with name only' => [
                    'data' => [
                        'name' => 'Test',
                        'description' => null,
                        'parent_id' => null
                    ],
                    'valid' => true,
                ],

                'without parent_id' => [
                    'data' => [
                        'name' => 'Test',
                        'description' => 'test',
                        'parent_id' => null
                    ],
                    'valid' => true,
                ],


                'without description' => [
                    'data' => [
                        'name' => 'Test',
                        'description' => null,
                        'parent_id' => 1
                    ],
                    'valid' => true,
                ],

                'with all data' => [
                    'data' => [
                        'name' => 'Test',
                        'description' => 'test',
                        'parent_id' => 1
                    ],
                    'valid' => true,
                ],

                'without name' => [
                    'data' => [
                        'name' => null,
                        'description' => 'test',
                        'parent_id' => 1
                    ],
                    'valid' => false,
                ],
            ];
    }
);
