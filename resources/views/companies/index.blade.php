<?php

use App\Models\Company;
use App\Models\User;

/** @var Company[] $companies */
$companies = Company::where('contact_name', '=', null)->paginate(18, ['*'], $pageName = 'companies', $page = null);

/** @var Company[] $privates */
$privates = Company::where('business_name', '=', null)->paginate(18, ['*'], $pageName = 'privates', $page = null);

/** @var User $user */
$user = Auth::user();

?>

<script xmlns:x-on="http://www.w3.org/1999/xhtml">


</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden  shadow-sm sm:rounded-lg ">

                <div class="flex ml-10 mt-3 p-2">

                    <div class="m-7 ">
                        <a href="{{route('companies.create')}}"
                           class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm">Create a new Company/Private</a>
                    </div>
                </div>

                <div class="  p-3 ml-10 mr-10  mb-10">


                    <div class="bg-gray-100 p-3 border rounded-md">
                        <div class="ml-10 mr-10  mt-3 text-center mb-3 p-3 border w rounded-md
                        border-green-400 bg-green-200 text-sm">
                            Companies
                        </div>
                        <div class=" ml-10 mr-10 flex grid grid-cols-6">
                            @foreach($companies as $company)
                                <a class=" hover:bg-blue-50 p-3 m-2 border-green-400 border
                            rounded-md col-span-2  text-center bg-white"
                                   href="{{route('companies.show', $company)}}">
                                    <div>
                                        <p> {{$company->business_name}}</p>
                                        <p> {{$company->email}}</p>
                                        <p> {{$company->address}}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div
                            class="ml-10 mt-3 mr-10">{{$companies->appends(['privates' => $privates->currentPage()])->links()}}</div>
                    </div>

                    <div class="bg-gray-100 p-3 mt-10 border rounded-md">
                        <div class="ml-10 mr-10 mt-3 text-center mb-3 p-3 border w rounded-md
                         border-green-400 bg-green-200 text-sm">
                            Privates
                        </div>
                        <div class=" ml-10 mr-10 flex grid grid-cols-6">
                            @foreach($privates as $private)
                                <a class=" hover:bg-blue-50 p-3 m-2 border-green-400 border
                            rounded-md col-span-2  text-center bg-white"
                                   href="{{route('companies.show', $private)}}">
                                    <div>
                                        <p>{{$private->contact_name}}</p>
                                        <p>{{$private->email}}</p>
                                        <p>{{$private->address}}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div
                            class="ml-10 mt-3 mr-10">{{$privates->appends(['companies' => $companies->currentPage()])->links()}}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
