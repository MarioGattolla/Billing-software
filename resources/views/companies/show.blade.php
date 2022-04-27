<?php

use App\Models\Company;

$logged_user = Auth::user();

/** @var Company $company */
?>
<script>
    function modal() {
        return {
            modal: false,
        }
    }

</script>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($company->vat_number == null)

                    <div class=" ml-10 p-6 bg-white   text-xl">
                        Private : {{$company->contact_name}}
                    </div>

                    <div class="  p-3 ml-10 mr-10  mb-10" x-data="modal()">
                        <div class="bg-gray-100 p-3 border rounded-md">

                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Country
                                : {{ $company->country }}</div>
                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Address
                                : {{$company->address }}</div>
                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Email : {{ $company->email }}</div>
                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Phone : {{$company->phone }}

                            </div>

                            <div>
                                <a href="{{route('companies.edit', $company)}}" class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2">
                                    Edit Private
                                </a>

                                <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2 modal" x-on:click="modal = true">
                                    Delete Private
                                </button>
                            </div>

                            <div x-show="modal == true"
                                 class="fixed top-0 right-0 left-0  h-full w-full bg-gray-100 bg-opacity-75 flex
                             items-center  ">
                                <div class="  bg-white rounded-md border m-auto w-1/3 text-center
                            rounded-md border-2 p-3 ">
                                    <div class="m-3">
                                        <div>
                                            You are trying to cancel the current Private.

                                        </div>
                                        <div>
                                            By clicking "DELETE" , Private will be permanently deleted. Are you sure?

                                        </div>
                                    </div>
                                    <div class=" flex grid grid-cols-2 items-center ">

                                        <div class="col-span-1 items-center ">
                                            <form method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="mt-1   p-3 border rounded-md border-green-400 hover:bg-green-400
                                            bg-green-200 text-sm"> Delete Private
                                                </button>
                                            </form>

                                        </div>

                                        <div class="col-span-1 items-center ">
                                            <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                                            bg-green-200 text-sm" x-on:click="modal = false">
                                                Return Back
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class=" ml-10 p-6 bg-white   text-xl">
                        Company : {{$company->business_name}}
                    </div>

                    <div class="  p-3 ml-10 mr-10  mb-10" x-data="modal()">
                        <div class="bg-gray-100 p-3 border rounded-md">

                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">VAT Number
                                : {{ $company->vat_number }}</div>
                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Country
                                : {{ $company->country }}</div>
                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Address
                                : {{$company->address }}</div>
                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Email : {{ $company->email }}</div>
                            <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Phone : {{$company->phone }}

                            </div>

                            <div>
                                <a href="{{route('companies.edit', $company)}}" class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2">
                                    Edit Company
                                </a>

                                <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2 modal" x-on:click="modal = true">
                                    Delete Company
                                </button>
                            </div>

                            <div x-show="modal == true"
                                 class="fixed top-0 right-0 left-0  h-full w-full bg-gray-100 bg-opacity-75 flex
                             items-center  ">
                                <div class="  bg-white rounded-md border m-auto w-1/3 text-center
                            rounded-md border-2 p-3 ">
                                    <div class="m-3">
                                        <div>
                                            You are trying to cancel the current Company.

                                        </div>
                                        <div>
                                            By clicking "DELETE" , Company will be permanently deleted. Are you sure?

                                        </div>
                                    </div>
                                    <div class=" flex grid grid-cols-2 items-center ">

                                        <div class="col-span-1 items-center ">
                                            <form method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="mt-1   p-3 border rounded-md border-green-400 hover:bg-green-400
                                            bg-green-200 text-sm"> Delete Company
                                                </button>
                                            </form>

                                        </div>

                                        <div class="col-span-1 items-center ">
                                            <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                                            bg-green-200 text-sm" x-on:click="modal = false">
                                                Return Back
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
