<?php

use App\Models\Company;
use App\Models\User;

/** @var Company[] $companies */
$companies = Company::where('contact_name', '=', 'null')->paginate(18, ['*'],$pageName= 'companies', $page = null );

/** @var Company[] $privates */
$privates = Company::where('business_name', '=', 'null')->paginate(18, ['*'],$pageName= 'privates', $page = null);

/** @var User $user */
$user = Auth::user();

?>

<script xmlns:x-on="http://www.w3.org/1999/xhtml">

    function showCompaniesModals() {
        return {
            companiesModal: true,
            privatesModal: false,
        }
    }

</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden  shadow-sm sm:rounded-lg ">
                <div class="flex">
                    <div class=" ml-10 p-6 bg-white   text-xl">
                        Companies
                    </div>
                    <div class="m-7 ">
                        <a href="{{route('companies.create')}}"
                           class="p-1 border rounded-md border-green-400 bg-green-300 text-sm">Create a new
                            Company/Private</a>
                    </div>
                </div>

                <div x-data="showCompaniesModals()" class="  p-3 ml-10 mr-10  mb-10">
                    <div class=" flex ml-10 pl-3 mt-3 mb-3 bg">
                        <button x-on:click="companiesModal = true, privatesModal= false"
                                class=" p-2 mr-3 w-1/6 rounded-md text-center bg-green-300 border border-green-400">
                            Companies
                        </button>
                        <button x-on:click="companiesModal = false, privatesModal= true"
                                class=" p-2 w-1/6 bg-green-300 text-center rounded-md border border-green-400">
                            Privates
                        </button>
                    </div>

                    <div x-show="companiesModal == true">
                        <div class=" ml-10 mr-10 flex grid grid-cols-6" >
                            @foreach($companies as $company)
                                <div class="p-3 m-2 border-green-400 border
                            rounded-md col-span-2 bg-white">
                                    {{$company->business_name}}</div>
                            @endforeach
                        </div>
                        <div class="ml-10 mt-3 mr-10">{{$companies->appends(['privates' => $privates->currentPage()])->links()}}</div>
                    </div>

                    <div x-show="privatesModal == true">
                        <div class=" ml-10 mr-10 flex grid grid-cols-6" >
                            @foreach($privates as $private)
                                <div class="p-3 m-2 border-green-400 border
                            rounded-md col-span-2">
                                    {{$private->contact_name}}</div>
                            @endforeach
                        </div>
                        <div class="ml-10 mt-3 mr-10">{{$privates->appends(['companies' => $companies->currentPage()])->links()}}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
