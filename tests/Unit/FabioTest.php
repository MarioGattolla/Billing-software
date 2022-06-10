<?php


it('check prefix on class', function () {

    $path = 'resources/views/Fabio/Fabio Folder';
    $files = File::allFiles($path);


    $view = (string)$this->view(Str::betweenFirst($files[0]->getRealPath(), 'views/', '.blade'));
    $class_strings = Str::of($view)->explode('class=')->except(0);

    $classes = collect($class_strings->map(function ($string) {
        $class = Str::of($string)->betweenFirst('"', '"');
        $class_attributes = Str::of($class)->explode(' ');
        return array_filter($class_attributes->toArray(), function ($attribute) {
            return $attribute !== '';
        });
    }));

    dd($classes);
})->only();
