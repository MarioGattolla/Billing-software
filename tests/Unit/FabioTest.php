<?php


use Illuminate\Support\Collection;

it('check prefix on class', function () {

    $path = resource_path('views/Fabio');
    $files = File::allFiles($path);

    $files_ext = collect($files)->where(fn(SplFileInfo $file) => str_contains($file->getRelativePath(), "ext-"));
    $files = collect($files)->where(fn(SplFileInfo $file) => !str_contains($file->getRelativePath(), "ext-"));

    expect($files->count())->toEqual($files_ext->count());
    $files->values()->each(function (SplFileInfo $file, $index) use ($files_ext) {

        expect($file->getBasename())->toEqual($files_ext->values()->get($index)->getBasename())
            ->and($file->getRelativePath())->toEqual(Str::after($files_ext->values()->get($index)->getRelativePath(), 'ext-'));

        $file_classes = get_classes_attributes($file);

        $file_ext_classes = get_classes_attributes($files_ext->values()->get($index));

        expect($file_ext_classes->count())->toEqual($file_classes->count());

        $file_classes->values()->each(function ($class, $index) use ($file_ext_classes) {
            $class_ext = collect($file_ext_classes->values()->get($index));

            expect(collect($class)->count())->toEqual($class_ext->count());

            collect($class)->values()->each(function ($attribute, $index) use ($class_ext) {
                $attribute_ext = $class_ext->values()->get($index);

                expect($attribute_ext)->toContain("ext-")
                    ->and($attribute)->toEqual(Str::after($attribute_ext, "ext-"));
            });
        });
    });
})->only();

function get_classes_attributes($file): Collection
{
    $class_strings = Str::of($file->getContents())->explode('class=')->except(0);

    return collect($class_strings->map(function ($string) {
        $class = Str::of($string)->betweenFirst('"', '"');
        $class_attributes = Str::of($class)->explode(' ');
        return array_filter($class_attributes->toArray(), function ($attribute) {
            return $attribute !== '';
        });
    }));
}

