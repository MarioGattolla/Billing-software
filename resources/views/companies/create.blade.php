<?php

use App\Models\User;
use Monarobase\CountryList\CountryListFacade;

/** @var User $user */
$user = Auth::user();

$countries = CountryListFacade::getList();

?>
<script>
    function formFilter() {
        return {
            radioItem:
                [{id: 1, name: 'Company'},
                    {id: 2, name: 'Private'}],
            selectedRadioID: 1,


        }
    };


</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl">
                    Here you can create a new Company or a Private User
                </div>
                <div class="m-10 ">


                    <div x-data="formFilter()" class="bg-gray-100 p-10 border rounded-md">


                        <form method="POST" action="{{route('companies.store')}}" name="company_create_form">
                            @csrf
                            <template x-for="item in radioItem" :key="item.id">
                                <div class="p-1">
                                    <input x-model="selectedRadioID" type="radio"    :value="item.id" :id="item.name">
                                    <label x-text="item.name"></label>

                                </div>
                            </template>
                            <div x-show="selectedRadioID == 1
                                " class="pt-1"
                                 x-show="open"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90">
                                <p>Business Name</p>
                                <input class="rounded-md  " type="text" id="business_name" name="business_name"/>

                                <p class="pt-2">VAT Number</p>
                                <input class="rounded-md" type="text" id="vat_number" name="vat_number"/>
                            </div>

                            <div x-show="selectedRadioID == 2"
                                 class="pt-1"
                                 x-show="open"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90">
                                <p>Contact Name</p>
                                <input class="rounded-md  " type="text" id="contact_name" name="contact_name"/>
                            </div>

                            <div class="pt-2">
                                <p>Country</p>
                                <select class="w-1/5 rounded-md" name="country_select" id="country_select" required>
                                    @foreach($countries as $country)
                                        <option value="{{$country}}"> {{$country}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pt-2">
                                <p>Address</p>
                                <input class="rounded-md  " type="text" id="address" name="address" required/>
                            </div>

                            <div class="pt-2">
                                <p>Email</p>
                                <input class="rounded-md  " type="email" id="email" name="email" required/>
                            </div>


                            <div class="pt-2">
                                <p>Phone Number</p>
                                <input class="rounded-md " type="text" id="phone" name="phone" required/>
                            </div>

                            <button class="w-1/5 bg-green-200 mt-3 h-10 rounded-md border border-green-400 hover:bg-green-400 type=" type="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
