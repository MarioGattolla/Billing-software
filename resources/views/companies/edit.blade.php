<?php

use App\Models\User;

/** @var User $user */
$user = Auth::user();

?>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-10 p-6 bg-white border-b border-gray-200 text-xl">
                    Companies
                </div>
                <div>
                    Create new Company Or Private User
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
