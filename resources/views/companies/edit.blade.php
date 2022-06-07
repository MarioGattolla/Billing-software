<?php

use App\Models\Company;
use App\Models\User;
use Monarobase\CountryList\CountryListFacade;

/** @var User $user */
$user = Auth::user();

$countries = CountryListFacade::getList();

/** @var Company $company */
?>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-elements.validation-errors :errors="$errors"/>

                <div class=" ml-20 mt-10 bg-white  text-xl">
                    Here you can Edit : {{$company->name}}
                </div>
                <div class="m-10 ">

                    <div class="bg-gray-100 p-10 border rounded-md">

                        <form method="POST" action="/companies/{{$company->id}}" name="private_edit_form">
                            @csrf
                            @method('PUT')
                            <div class="pt-2">

                                <div class="pt-2">
                                    <p> Name</p>
                                    <input class="rounded-md " value="{{$company->name}}" type="text"
                                           id="name"
                                           name="name" required>
                                </div>

                                <p>Country</p>
                                <select class="w-1/5 rounded-md" name="country" id="country" required>
                                    <option selected>{{$company->country}}</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country}}"> {{$country}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pt-2">
                                <p>Address</p>
                                <input class="rounded-md " value="{{$company->address}}" type="text" id="address"
                                       name="address" required>
                            </div>

                            <div class="pt-2">
                                <p>Email</p>
                                <input class="rounded-md " value="{{$company->email}}" type="email" id="email"
                                       name="email" required/>
                            </div>


                            <div class="pt-2">
                                <p>Phone Number</p>
                                <input class="rounded-md " value="{{$company->phone}}" type="text" id="phone"
                                       name="phone" required/>
                            </div>
                            @if($company->vat_number)
                                <div class="pt-2">
                                    <p> Vat</p>
                                    <input class="rounded-md " value="{{$company->vat_number}}" type="text"
                                           id="vat_number"
                                           name="vat_number" required>
                                </div>

                            @endif
                            <button
                                class="w-1/5 bg-green-200 mt-3 h-10 rounded-md border border-green-400 hover:bg-green-400 type="
                                type="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
                <button
                    class="w-1/5 bg-green-200 mt-3 h-10 rounded-md border border-green-400 hover:bg-green-400 type="
                    type="submit">
                    Submit
                </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    </div>
    </div>
</x-app-layout>

